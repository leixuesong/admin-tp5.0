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
        $result = db(self::$table)->where($search)->select();
        $data = createTree($result);
        return ['data'=>compact('data'),'code'=>200,'message'=>'操作完成'];
    }
    public function all()
    {
        $result = db(self::$table)->where(['status'=>0])->field('node_id,pid,name')->select();
        $list = createTree($result);
        return ['data'=>$list,'code'=>200,'message'=>'操作完成'];
    }
    public function info()
    {
        $search=[
            'node_id'=> input('post.id',1)
        ];
        $user = db(self::$table)->where($search)->find();
        $result = db(self::$table)->where(['status'=>0])->field('node_id,pid,name')->select();
        $user['pidList'] = getParent($result,$user['node_id']);
        return ['data'=>$user,'code'=>200,'message'=>'操作完成'];
    }
    public function add()
    {
        $data = request()->post();
        unset($data['pidList']);
        if(input('post.pid') != 0){
           $parent =  db(self::$table)->where(['node_id'=>input('post.pid')])->field('level')->find($data);
           $data['level'] = $parent['level'] +1;
        }
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
        unset($data['pidList']);
        if(input('post.pid') != 0){
           $parent =  db(self::$table)->where(['node_id'=>input('post.pid')])
           ->field('level')->find();
           $data['level'] = $parent['level'] +1;
        }
        $number = db(self::$table)->where(['node_id'=>$data['node_id']])->update($data);
        return ['data'=>[],'code'=>200,'message'=>'操作成功'];

    }
}
