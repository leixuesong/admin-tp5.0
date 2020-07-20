<?php
namespace app\merchant\controller;
use app\merchant\controller\Base;

class Profit extends Base
{
    protected static $table='share';

    public function index()
    {
        $search=[];
        $data = db(self::$table)
        ->join('agent',self::$table.'.agent_id = agent.agent_id','left')
        ->where($search)->page(self::$pageNum, self::$pageSize)->select();
        $total = db(self::$table)->where($search)->count();
        return ['data'=>compact('data','total'),'code'=>200,'message'=>'操作完成'];
    }
}
