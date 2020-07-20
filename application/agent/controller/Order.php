<?php
namespace app\agent\controller;
use app\agent\controller\Base;

class Order extends Base
{
    protected static $table='`order`';

    public function index()
    {
        $search=[];
        $data = db(self::$table)
        ->join('merchant',self::$table.'.mer_id = merchant.mer_id','left')
        ->where($search)->page(self::$pageNum, self::$pageSize)->select();
        $total = db(self::$table)->where($search)->count();
        return ['data'=>compact('data','total'),'code'=>200,'message'=>'操作完成'];
    }
}
