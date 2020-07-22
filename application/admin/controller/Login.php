<?php
namespace app\admin\controller;

class Login 
{
    public function auth()
    {
        $request = request();
        $search=[
            'admin_account'=>input('post.username'),
        ];
        $user = db('admin_user')->where($search)->find();
        if($user['admin_password']!==md5(input('post.password'))){
            return ['data'=>[],'code'=>201,'message'=>'用户名或密码不正确！'];
        }
        if($user['admin_status']!==0){
            return ['data'=>[],'code'=>201,'message'=>'该用户状态异常！'];
        }
        // 验证白名单
        if($user['admin_permit_ip']!=='' && strpos( $user['admin_permit_ip'],$request->ip())){
            return ['data'=>[],'code'=>201,'message'=>'该IP不在白名单列表中'];
        }
        $token = md5($user['admin_id'].time());
        $loginData = [
            'admin_session_sign'=> $token,
            'login_count'=>$user['login_count']+1,
            'last_login_ip'=>$request->ip()
        ];
        db('admin_user')->where('admin_id',$user['admin_id'])->update($loginData);
        return ['data'=>compact('token'),'code'=>200,'message'=>'操作完成'];
        
    }
}
