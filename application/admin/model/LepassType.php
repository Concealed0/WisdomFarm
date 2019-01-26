<?php
namespace app\admin\model;
use think\Model;
use think\Db;

class LepassType extends Model
{
   
     /**
     * 获取信息
     * @param array $where 条件
     * @return array 信息
     */
    public function leshow(){
        return $this->name('admin_user')->field('user_id,username,nicename,email,le_tel,last_login_time,status')->order('user_id')->select();
    }


     //查找账号
    public function getWhereInfo($where){
        return $this->name('admin_user')->where($where)->find();
    }


    //更新用户密码
    public function lechange($userInfo,$password){
        $res=$this->name('admin_user')->where('user_id', $userInfo['user_id'])->update(['password'=>$password]);
        return $res;
    }

    //增加账号信息
    public function leadd($data){
        $res=$this->name('admin_user')->insertGetId($data);
        return $res;
    }
}