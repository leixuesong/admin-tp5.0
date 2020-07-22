<?php
namespace app\agent\controller;

class Login 
{
    public function auth()
    {
        $request = request();
        $search=[
            'agent_acc'=>input('post.username'),
        ];
        $user = db('agent')->where($search)->find();
        if($user['agent_pwd']!==md5(input('post.password'))){
            return ['data'=>[],'code'=>201,'message'=>'用户名或密码不正确！'];
        }
        if($user['status']!==0){
            return ['data'=>[],'code'=>201,'message'=>'该用户状态异常！'];
        }
        // 验证白名单
        if($user['permit_IP']!=='' && strpos( $user['permit_IP'],$request->ip())){
            return ['data'=>[],'code'=>201,'message'=>'该IP不在白名单列表中'];
        }
        $token = md5($user['agent_id'].time());
        $loginData = [
            'session_sign'=> $token,
            'login_count'=>$user['login_count']+1,
            'last_log_ip'=>$request->ip(),
            'last_login_time'=>date('Y-m-d H:i:s')
        ];
        db('agent')->where('agent_id',$user['agent_id'])->update($loginData);
        return ['data'=>compact('token'),'code'=>200,'message'=>'操作完成'];
        
    }
}
