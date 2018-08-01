<?php
namespace app\admin\controller;

use think\Controller;
use think\Session;

class Login extends Controller
{
    public function index()
    {
        $user_id=session('user_id');
        
        if(!empty($user_id))
        {
            $this->error('用户已登录，请勿重新登陆',url('index/index'));
        }
        return $this->fetch();
    }
    
    public function do_login()
    {
        $status=0;
        $msg='';
        $data=$_REQUEST;
        
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
        
        $msg=$this->validate($data,$rule,$msg);
        
        if($msg===true)
        {
            $arr=array();
            $arr['name']=$data['username'];
            $arr['password']=$data['password'];
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
    
    
    public function  have_try()
    {
        $url='http://www.kuaidi100.com/query';
        $arr['type']='shunfeng';
        $arr['postid']='123456';
        $arr['temp']='0.2760640405065877';
        $data_string=http_build_query($arr);
        
        /* print_r($data_string);exit; */
        $timeout=60;
        //curl验证成功
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            print curl_error($ch);
        }
        curl_close($ch);
        
        $content=json_decode($result,true); 
       /*  $content=$content->toArray(); */
        /* $list = $this -> jsonDatacount()->toArray(); */
        var_dump($content['data']);exit;
        return $result;
    }
    
}
