<?php
namespace app\admin\controller;

use think\Controller;
use think\Session;

class Login extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
    
    public function do_login()
    {
        $status=0;
        $msg='';
        
        $rule=[
            'username'=>'require',
            'password'=>'require',
            'verify'=>'require|captcha'
        ];
        
        $msg=[
            'username'=>['require'=>'用户名不能为空，请检查'],
            'password'=>['require'=>'密码不能为空，请检查'],
            'verify'=>['require'=>'验证码不能为空，请检查','captcha'=>'验证码错误']
        ];
        
        $msg=$this->validate($_REQUEST, $rule,$msg);
        
        if($msg==true)
        {
            $arr=array();
            $arr['name']=$_REQUEST['username'];
            $arr['password']=$_REQUEST['password'];
            $result=db('admin')->where($arr)->find();
            
            if($result)
            {
                $status=1;
                $msg='登陆成功';
                session('user_id',$result['id']);
                session('user_name',$result['name']);
            }
            else 
            {
                $msg='用户名账号不存在';
            }
            
        }
        
        return ['status'=>$status,'msg'=>$msg];
    }
    
}
