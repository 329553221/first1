<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
class Role extends Controller
{
    public function get_condition()
    {
        
    }
    public function index()
    {
        return $this->fetch();
    }
    
    public function ajax_load_data()
    {
        $result=get_data('think_auth_group', '');
        
        return $result;
    }
    
    public function edit()
    {
        $group_id=$_REQUEST['id']; 
        $self_rules=db('think_auth_group')->field('rules')->where('id',$group_id)->find();
        $rules=db('think_auth_rule')->select();
        $arr=tree($rules);
        $self_rules=explode(',',$self_rules['rules']);
        $this->assign('arr',$arr);
        $this->assign('self_rules',$self_rules);
        $this->assign('group_id',$group_id);
        return $this->fetch();
    }
    
    function update(){
        $arr=array();
        if(!empty($_REQUEST['class_1']) && !empty($_REQUEST['class_2']))
        {
            $class_1=$_REQUEST['class_1'];
            $class_2=$_REQUEST['class_2'];
            $class=array_merge($class_1,$class_2);
            $arr['rules']=implode(',',$class);
        }
        else
        {
            $arr['rules']='';
        }
        $group_id=$_REQUEST['group_id'];
        if(!empty($_REQUEST['title']))
        {
            $arr['title']=$_REQUEST['title'];
        }
        $arr['note']=$_REQUEST['note'];
        
        $result=db('think_auth_group')->where('id',$group_id)->update($arr);
        if($result)
        {
            $array['status']=1;
            $array['msg']='更新成功';
        }
        else 
        {
            $array['status']=0;
            $array['msg']='更新失败';
        }
        
        return $array;
    }
    
    public function add()
    {
        return $this->fetch();
    }
}
