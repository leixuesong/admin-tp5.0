<?php
namespace app\admin\controller;
use app\admin\controller\Base;

class Merchant extends Base
{
    protected static $table='merchant';

    public function index()
    {
        $search=[];
        if(input('post.mer_acc')){
            $search['mer_acc'] = ['like','%'.input('post.mer_acc').'%'];
        }
        if(input('post.status')){
            $search[self::$table.'.status'] =input('post.status');
        }
        $data = db(self::$table)
        ->join('agent',self::$table.'.agent_id = agent.agent_id','left')
        ->where($search)->page(self::$pageNum, self::$pageSize)->field(self::$table.'.*,agent.agent_acc')->select();
        $total = db(self::$table)->where($search)->count();
        return ['data'=>compact('data','total'),'code'=>200,'message'=>'操作完成'];
    } 
    public function info()
    {
        $agent = db(self::$table)->where(['mer_id'=>input('post.mer_id')])->field('mer_id,permit_IP')->find();
        return ['data'=>$agent,'code'=>200,'message'=>'操作完成'];
    }
    public function modify()
    {
        $data = request()->post();
        $agent = db(self::$table)->where(['mer_id'=>$data['mer_id']])->update($data);
        return ['data'=>$agent,'code'=>200,'message'=>'操作完成'];
    }
    public function all()
    {
        $list = db(self::$table)->where(['status'=>0])->select();
        return ['data'=>$list,'code'=>200,'message'=>'操作完成'];
    }
    public function reset()
    {
        $search=[
            'mer_id'=> input('post.mer_id')
        ];
        $number = db(self::$table)->where($search)->update(['mer_pwd'=>md5('123456')]);
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
