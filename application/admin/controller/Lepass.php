<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;
class Lepass extends Controller
{
    //更改密码
    public function index(){
        return $this->fetch();
    }
     //更改密码
     public function change(){
        $username=input('post.username');
        $data['password']=md5(input('post.pwd'));
        $data['nicename']=input('post.nicename');
        $data['email']=input('post.email');
        $data['le_tel']=input('post.tel');
        $data['remark']=input('post.remark');
        $data['sex']=input('post.sex');
        //获取当前时间
        $data['last_login_time']=date('Y-m-d H:i:s', time());

        $request = Request::instance();
        // 获取当前ip
        $data['last_login_ip']=$request->ip();
        
        $map = array();
        $map['username'] = $username;
        $data['username'] = $username;
        $userInfo = model('LepassType')->getWhereInfo($map);
        if(!empty($userInfo)){
            return $this->error('账号已存在！');
        }
        if($data['nicename']=='管理员'){
            $data['group_id']=1;
        }else $data['group_id']=4;

        if(model('LepassType')->leadd($data)){
            return $this->success('添加成功!');
        }  
    }
    public function leshow(){
        $leshow = model('LepassType')->leshow();
        $this->assign('leshow',$leshow);
        return $this->fetch();
       // return AjaxLe($leshow);
    }
    public function delete(){

    }

}