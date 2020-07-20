<?php
namespace app\admin\controller;
use app\admin\controller\Base;

class Agent extends Base
{
    protected static $table='agent';

    public function index()
    {
        $search=[];
        if(input('post.agent_acc')){
            $search['agent_acc'] = ['like','%'.input('post.agent_acc').'%'];
        }
        if(input('post.status')){
            $search[self::$table.'.status'] =input('post.status');
        }
        $data = db(self::$table)
        ->join('agent level_agent',self::$table.'.agent_id = level_agent.agent_id','left')
        ->where($search)->page(self::$pageNum, self::$pageSize)->select();
        $total = db(self::$table)->where($search)->count();
        return ['data'=>compact('data','total'),'code'=>200,'message'=>'操作完成'];
    }
    public function all()
    {
        $list = db(self::$table)->where(['status'=>0])->select();
        return ['data'=>$list,'code'=>200,'message'=>'操作完成'];
    }
    public function reset()
    {
        $search=[
            'agent_id'=> input('post.agent_id')
        ];
        $number = db(self::$table)->where($search)->update(['agent_pwd'=>md5('123456')]);
        if($number === 1){
            return ['data'=>[],'code'=>200,'message'=>'操作成功'];
        }else{
            return ['data'=>[],'code'=>201,'message'=>'添加失败'];
        }
    }

    public function status()
    {
        $data = request()->post();
        $number = db(self::$table)->update($data);
        if($number === 0){
        return ['data'=>[],'code'=>201,'message'=>'操作失败'];
        }else{
        return ['data'=>[],'code'=>200,'message'=>'操作成功'];
        }

    }
}
