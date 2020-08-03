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

// 数组生成树状结构
function createTree($data,$p_id=0){
    $tree =[];
    foreach($data as $row){
        if($row['pid']===$p_id){
            $tmp =createTree($data,$row['node_id']);
            if(!empty($tmp)){
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
        if($item['node_id'] === $targetId && $item['pid']!==0 ) {
            $parent[]=$item['pid'];
            getParent($data,$item['pid']);
        }
    }
    return $parent ? array_reverse($parent):[0];  
}
// 根据节点查找所有的父级节点
function getParentNodes($data,$target){
    global $parent;
    foreach($data as $key =>$item) {
        if($item['node_id'] === $target['pid'] ) {
            if(!(is_array($parent)&& in_array($item,$parent))){
                $parent[]= $item;
            }
            getParentNodes($data,$item,false);
        }
    }
    return ($parent);  
}