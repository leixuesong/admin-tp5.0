<?php
namespace app\admin\controller;
use app\admin\controller\Base;

class User extends Base
{
    protected static $table='admin_user';

    public function index()
    {
        $search=[
            self::$table.'.admin_status'=>['neq','3']
        ];
        if(input('post.admin_account')){
            $search['admin_account'] = ['like','%'.input('post.admin_account').'%'];
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
            'admin_id'=> parent::$id
        ];
        $user = db(self::$table)->where($search)->find();
        return ['data'=>$user,'code'=>200,'message'=>'操作完成'];
    }
    public function modify()
    {
        $search=[
            'admin_id'=> parent::$id
        ];
        $user = db(self::$table)->where($search)->find();
        if($user['admin_password']!==md5(input('post.oldPassword'))){
            return ['data'=>false,'code'=>201,'message'=>'原密码错误！'];
        }else{
            db(self::$table)->where($search)->update(['admin_password'=>md5(input('post.newPassword'))]);
            return ['data'=>true,'code'=>200,'message'=>'操作完成'];
        }
       
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
        if($number === 0){
        return ['data'=>[],'code'=>201,'message'=>'操作失败'];
        }else{
        return ['data'=>[],'code'=>200,'message'=>'操作成功'];
        }

    }
    
    public function delete()
    {
        
        $number = db(self::$table)->where(['admin_id'=>input('post.admin_id')])->update(['admin_status'=>3]);
        if($number === 0){
        return ['data'=>[],'code'=>201,'message'=>'操作失败'];
        }else{
        return ['data'=>[],'code'=>200,'message'=>'操作成功'];
        }

    }
}
