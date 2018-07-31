<?php
namespace app\admin\controller;

use think\Session;
use org\Auth;
use think\Db;
class Index extends Base
{
    public function index()
    {
        
        $result=db('menu')->select();
        
        $rules=Db::query('select rules from think_auth_group_access a join think_auth_group b on a.group_id=b.id  where a.uid='.session('user_id'));
        
        $sql='select * from think_auth_rule where id in ('.$rules[0]['rules'].')';
        $menus=Db::query($sql);
        $arr=tree($menus);
        $this->assign('result',$arr);
        return $this->fetch();
    }
    
    public function welcome()
    {
        return $this->fetch();
    }
    
    public  function login_out()
    {
        Session::delete('user_id');
        Session::delete('user_name');
        $this->success('注销成功，正在返回',url('login/index'));
    }
}
