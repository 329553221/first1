<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use think\Db;
function get_data($table_name,$condition)
{
    $iSortCol_0=$_REQUEST['iSortCol_0']; //根据哪个字段来排序
    $ziduan=$_REQUEST['mDataProp_'.$iSortCol_0];
    $sSortDir_0=$_REQUEST['sSortDir_0']; //asc还是desc
    
    $start=$_REQUEST['iDisplayStart'];  //起始页开始数
    $length=$_REQUEST['iDisplayLength']; //每页展示条数
    
    
    $sql='select * from '.$table_name.' where 1=1';
    $sql .=$condition;
    $sql .=' order by '.$ziduan.' '.$sSortDir_0.' limit '.$start.','.$length;
    
    $result=Db::query($sql);
    $json_data=array();
    $json_data['draw']=null;
    if(!empty($condition))
    {
        $count=Db::query('select count(*) as count from (select * from '.$table_name.' where 1=1 '.$condition.' limit '.$start.','.$length.')a');
    }
    else
    {
        $count=Db::query('select count(*) as count from '.$table_name);
    }
    
    $json_data['recordsTotal']=$count[0]['count'];
    $json_data['recordsFiltered']=$count[0]['count'];
    $json_data['data']=$result;
    return $json_data;
}



function tree($menus)
{
    $arr=array();
    foreach ($menus as $key=>$value)
    {
        if(strpos($value['name'],'/'))
        {
            $menus[$key]['name']='/public/index.php/admin/'.$value['name'];
        }
        if($value['pid']==0)
        {
            $arr[]=$value;
        }
    }
    
    foreach ($arr as $key=>$value)
    {
        foreach ($menus as $k=>$v)
        {
            if($v['pid']==$value['id'])
            {
                $arr[$key]['child'][]=$v;
            }
        }
    };
    
    return $arr;
}