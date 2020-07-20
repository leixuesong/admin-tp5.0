<?php
namespace app\merchant\controller;
use think\Controller;

class Base extends Controller
{
    protected static $pageNum =1 ;
    protected  static $pageSize=10;
    public static $id=0;

    public function _initialize()
     {
        $token = request()->header('token');
        if($token){
            $user=db('merchant')->where(['session_sign'=>$token])->find();
            if($user){
                self::$id = $user['mer_id'];
            }else{
                return ['data'=>false,'code'=>500,'message'=>'token已经过期'];
            }
        }else{
            return ['data'=>false,'code'=>200,'message'=>'操作完成'];
        }
    }
}
