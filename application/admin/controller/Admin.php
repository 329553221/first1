<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
class Admin extends Base
{
    public function get_condition()
    {
        $sql='';
        if(!empty($_REQUEST['name']))
        {
            $name=$_REQUEST['name'];
            $sql=' and name=\''.$name.'\'';
        }
        return $sql;
    }
    
    public function index()
    {
        return $this->fetch();
    }
    
    public function ajax_load_data()
    {
        $condition=$this->get_condition();
        $json_data=get_data('admin',$condition);
        return $json_data;
    }
    
    public function add()
    {
        return $this->fetch();
    }
    
    public function insert()
    {
        $data=array();
        $data['name']=$_REQUEST['adminName'];
        $data['password']=$_REQUEST['password'];
        $data['sex']=$_REQUEST['sex'];
        $data['phone']=$_REQUEST['phone'];
        $data['email']=$_REQUEST['email'];
        $data['role']=$_REQUEST['adminRole'];
        $data['note']=$_REQUEST['note'];
        
        if($data['password'] != $_REQUEST['password2'])
        {
            $arr=array();
            $arr['status']=0;
            $arr['msg']='两次密码输入不一致';
            
            return  $arr;
        }
        
        $result=db('admin')->insert($data);
        if($result)
        {
            $arr=array();
            $arr['status']=1;
            $arr['msg']='数据添加成功';
        }
        else 
        {
            $arr=array();
            $arr['status']=0;
            $arr['msg']='数据添加失败';
        }
        
        return $arr;
        
    }
}
