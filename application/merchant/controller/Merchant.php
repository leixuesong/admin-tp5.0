<?php
namespace app\merchant\controller;
use app\merchant\controller\Base;

class Merchant extends Base
{
    protected static $table='merchant';

    public function info()
    {
        $search=[
            'mer_id'=> parent::$id
        ];
        $user = db(self::$table)->where($search)->find();
        return ['data'=>$user,'code'=>200,'message'=>'操作完成'];
    }
    public function modify()
    {
        $search=[
            'mer_id'=> parent::$id
        ];
        $user = db(self::$table)->where($search)->find();
        if($user['mer_pwd']!==md5(input('post.oldPassword'))){
            return ['data'=>false,'code'=>201,'message'=>'原密码错误！'];
        }else{
            db(self::$table)->where($search)->update(['mer_pwd'=>md5(input('post.newPassword'))]);
            return ['data'=>true,'code'=>200,'message'=>'操作完成'];
        }
       
    }
}
