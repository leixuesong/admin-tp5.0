<?php
namespace app\agent\controller;
use app\agent\controller\Base;

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
    public function info()
    {
        $search=[
            'agent_id'=> parent::$id
        ];
        $user = db(self::$table)->where($search)->find();
        return ['data'=>$user,'code'=>200,'message'=>'操作完成'];
    }
    public function modify()
    {
        $search=[
            'agent_id'=> parent::$id
        ];
        $user = db(self::$table)->where($search)->find();
        if($user['agent_pwd']!==md5(input('post.oldPassword'))){
            return ['data'=>false,'code'=>201,'message'=>'原密码错误！'];
        }else{
            db(self::$table)->where($search)->update(['agent_pwd'=>md5(input('post.newPassword'))]);
            return ['data'=>true,'code'=>200,'message'=>'操作完成'];
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
