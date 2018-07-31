<?php
namespace app\admin\controller;
use think\Controller;
use org\Auth; 
class Base extends Controller
{
    protected  function  _initialize()
    {
        
        $controller = request()->controller();
        $action = request()->action();
        $auth = new Auth();
        if(!$auth->check($controller . '/' . $action, session('user_id'))){
            $this->error('你没有权限访问');
        }
    }
   
 }