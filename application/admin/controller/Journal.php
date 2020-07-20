<?php
namespace app\admin\controller;
use app\admin\controller\Base;

class Journal extends Base
{
    protected static $table='sys_log';

    public function index()
    {
        $search=[];
        $data = db(self::$table)
        ->join('admin_user',self::$table.'.sys_log_id = admin_user.admin_id','left')
        ->where($search)->page(self::$pageNum, self::$pageSize)->select();
        $total = db(self::$table)->where($search)->count();
        return ['data'=>compact('data','total'),'code'=>200,'message'=>'操作完成'];
    }
}
