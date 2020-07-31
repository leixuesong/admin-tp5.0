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
function createTree($data,$p_id=0){
    $tree =[];
    foreach($data as $row){
        if($row['pid']===$p_id){
            $tmp =createTree($data,$row['node_id']);
            if($tmp){
                $row['children']=$tmp;
            }
            $tree[]=$row;                
        }
    }
    return $tree;
}
