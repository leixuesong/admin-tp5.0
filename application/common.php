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
function getParent($data,$targetId){
    global $parent;
    foreach($data as $key =>$item) {
        if($item['node_id'] == $targetId && $item['pid']!==0 ) {
            $parent[]=$item['pid'];
            getParent($data,$item['pid']);
        }
    }
    return $parent ? array_reverse($parent):[0];  
}