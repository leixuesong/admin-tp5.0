<?php
namespace app\admin\controller;
use app\admin\controller\Base;

class Menu extends Base
{
    protected static $table='admin_node';

    public function index()
    {
        $search=[];
        if(input('post.name')){
            $search['name'] = ['like','%'.input('post.name').'%'];
        }
        $data = db(self::$table)->where($search)->page(self::$pageNum, self::$pageSize)->select();
        $total = db(self::$table)->where($search)->count();
        return ['data'=>compact('data','total'),'code'=>200,'message'=>'操作完成'];
    }
    public function all()
    {
        $list = db(self::$table)->where(['status'=>0])->select();
        return ['data'=>$list,'code'=>200,'message'=>'操作完成'];
    }
    public function info()
    {
        $search=[
            'node_id'=> input('post.id',1)
        ];
        $user = db(self::$table)->where($search)->find();
        return ['data'=>$user,'code'=>200,'message'=>'操作完成'];
    }
    public function add()
    {
        $data = request()->post();
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
        $number = db(self::$table)->update($data);
        return ['data'=>[],'code'=>200,'message'=>'操作成功'];

    }
}
