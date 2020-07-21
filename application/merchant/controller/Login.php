<?php
namespace app\merchant\controller;

class Login 
{
    public function auth()
    {
        $request = request();
        $search=[
            'mer_acc'=>input('post.username'),
        ];
        $user = db('merchant')->where($search)->find();
        if($user['mer_pwd']!==md5(input('post.password'))){
            return ['data'=>[],'code'=>201,'message'=>'用户名或密码不正确！'];
        }
        if($user['status']!==0){
            return ['data'=>[],'code'=>201,'message'=>'该用户状态异常！'];
        }
        // 验证白名单
        if($user['permit_ip']!=='' && strpos( $user['permit_ip'],$request->ip())){
            return ['data'=>[],'code'=>201,'message'=>'该IP不在白名单列表中'];
        }
        $token=md5($user['mer_id'].time());
        db('merchant')->where('mer_id',$user['mer_id'])->setField('session_sign', $token);
        return ['data'=>compact('token'),'code'=>200,'message'=>'操作完成'];
        
    }
}
