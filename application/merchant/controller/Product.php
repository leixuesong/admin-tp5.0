<?php
namespace app\merchant\controller;
use app\merchant\controller\Base;

class Product extends Base
{
    protected static $table='commodity';

    public function index()
    {
        $search=[
            'mer_id'=>parent::$id
        ];
        if(input('post.comm_name')){
            $search['comm_name'] = ['like','%'.input('post.comm_name').'%'];
        }
        if(input('post.status')){
            $search[self::$table.'.status'] =input('post.status');
        }
        $data = db(self::$table)
        ->where($search)->page(self::$pageNum, self::$pageSize)->select();
        $total = db(self::$table)->where($search)->count();
        return ['data'=>compact('data','total'),'code'=>200,'message'=>'操作完成'];
    }
    public function info()
    {
        $search=[
            'comm_id'=> input('post.id')
        ];
        $user = db(self::$table)->field('create_time,mer_id',true)->where($search)->find();
        return ['data'=>$user,'code'=>200,'message'=>'操作完成'];
    }
    public function add()
    {
        $data = request()->post();
        $data['mer_id'] = parent::$id;
        $data['create_time'] = date('Y-m-d H:i:s');
        $number = db(self::$table)->insert($data);
        if($number === 1){
            return ['data'=>[],'code'=>200,'message'=>'操作成功'];
        }else{
            return ['data'=>[],'code'=>201,'message'=>'添加失败'];
        }

        
    }
    public function edit()
    {
        $data = request()->post();
        $number = db(self::$table)->where(['comm_id'=>$data['comm_id']])->update($data);
        return ['data'=>[],'code'=>200,'message'=>'操作成功'];

    }
    public function status()
    {
        $data = request()->post();
        $number = db(self::$table)->where(['comm_id'=> input('post.comm_id')])->update($data);
        if($number === 0){
        return ['data'=>[],'code'=>201,'message'=>'操作失败'];
        }else{
        return ['data'=>[],'code'=>200,'message'=>'操作成功'];
        }

    }
}
