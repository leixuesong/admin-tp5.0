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
        $data = db(self::$table)
        ->join('admin_role',self::$table.'.admin_role_id = admin_role.role_id','left')
        ->where($search)->field(self::$table.'.*,admin_role.name as role_name')->page(self::$pageNum, self::$pageSize)->select();
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
            'admin_id'=> input('post.id')
        ];
        $user = db(self::$table)
        ->field(['admin_id','admin_account','admin_role_id','admin_phone','admin_email','admin_remarks','admin_status'])->where($search)->find();
        return ['data'=>$user,'code'=>200,'message'=>'操作完成'];
    }
    public function getuserinfo()
    {
        $search=[
            'admin_id'=> parent::$id
        ];
        $user = db(self::$table)
        ->join('admin_role',self::$table.'.admin_role_id = admin_role.role_id','left')
        ->field(['admin_account','admin_role_id','node_id','admin_phone','admin_email','admin_remarks','admin_status'])->where($search)->find();
        $nodeList =  db('admin_node')->where(['node_id'=>['in',$user['node_id']]])->select();
        $menu = [];
        foreach($nodeList as $item){
            $menuItem =[
              'path'=> '/' .$item['controller'],
              'children'=>[[
                    'path'=>$item['method'],
                    'name'=>$item['controller'] .'-'.$item['method'],
                    'view'=>$item['controller']."/".$item['method'],
                    'meta'=>['title'=>$item['name'],'icon'=>$item['icon']]
              ]]
            ];
            array_push($menu,$menuItem);
    }
    $user['menu'] = $menu;
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
        $data['admin_create_time'] = date('Y-m-d H:i:s');
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
        $data['admin_update_time']=date('Y-m-d H:i:s');
        $number = db(self::$table)->where(['admin_id'=> $data['admin_id']])->update($data);
        return ['data'=>[],'code'=>200,'message'=>'操作成功'];
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
