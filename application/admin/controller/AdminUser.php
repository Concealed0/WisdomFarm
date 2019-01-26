<?php
namespace app\admin\controller;

use think\Request;
/**
 * 后台用户
 */
class AdminUser extends Admin {
    /**
     * 当前模块参数
     */
    protected function _infoModule(){
        return array(
            'info'  => array(
                'name' => '用户管理',
                'description' => '管理网站后台管理员',
                ),
            'menu' => array(
                    array(
                        'name' => '用户列表',
                        'url' => url('index'),
                        'icon' => 'list',
                    ),
                ),
            '_info' => array(
                    array(
                        'name' => '添加用户',
                        'url' => url('info'),
                    ),
                ),
            );
    }
	/**
     * 列表
     */
    public function index(){
        //筛选条件
        $where = array();
        $keyword = input('keyword');
        if(!empty($keyword)){
            $where[] = ' (A.username like "%'.$keyword.'%")  OR ( A.nicename like "%'.$keyword.'%") ';
        }
        $groupId = input('group_id');
        if(!empty($groupId)){
            $where['A.group_id'] = $groupId;
        }
        //URL参数
        $pageMaps = array();
        $pageMaps['keyword'] = $keyword;
        $pageMaps['group_id'] = $groupId;
        //查询数据
        $limit=0;
        $list = model('AdminUser')->loadList($where,$limit);
        //位置导航
        $breadCrumb = array('用户列表'=>url());
        //模板传值
        $this->assign('breadCrumb',$breadCrumb);
        $this->assign('list',$list);
        $this->assign('_page',$list->render());
        $this->assign('groupList',model('AdminGroup')->loadList());
        $this->assign('keyword',$keyword);
        $this->assign('groupId',$groupId);
        return $this->fetch();
    }
    /**
     * 详情
     */
    public function info(){
        $userId = input('user_id');
        $model = model('AdminUser');
        if (input('post.')){
            if($userId == 1){
                return ajaxReturn(0,'保留用户无法编辑');
            }
            if (input('post.password')){
                if (empty(input('post.password2'))){
                    return ajaxReturn(0,'确认密码不能为空');
                }
                if (input('post.password2')!=input('post.password')){
                    return ajaxReturn(0,'两次密码不一致');
                }
            }
            if ($userId){
                $status=$model->edit();
            }else{
                if (empty(input('post.password'))){
                    return ajaxReturn(0,'请填写密码');
                }
                $status=$model->add();
            }
            if($status!==false){
                return ajaxReturn(200,'操作成功',url('index'));
            }else{
                return ajaxReturn(0,'操作失败');
            }
        }else{
            $this->assign('info', $model->getInfo($userId));
            $this->assign('groupList',model('AdminGroup')->loadList());
            return $this->fetch();
        }
    }
    // public function info(){
    //     $username=input('post.username');
    //     $data['password']=md5(input('post.pwd'));
    //     $data['nicename']=input('post.nicename');
    //     $data['email']=input('post.email');
    //     $data['le_tel']=input('post.tel');
    //     $data['remark']=input('post.remark');
    //     $data['sex']=input('post.sex');
    //     //获取当前时间
    //     $data['last_login_time']=date('Y-m-d H:i:s', time());

    //     $request = Request::instance();
    //     // 获取当前ip
    //     $data['last_login_ip']=$request->ip();
        
    //     $map = array();
    //     $map['username'] = $username;
    //     $data['username'] = $username;
    //     $userInfo = model('LepassType')->getWhereInfo($map);
    //     if(!empty($userInfo)){
    //         return $this->error('账号已存在！');
    //     }
    //     if($data['nicename']=='管理员'){
    //         $data['group_id']=1;
    //     }else $data['group_id']=4;

    //     if(model('LepassType')->leadd($data)){
    //         return $this->success('添加成功!','index');
    //     }  
    // }

    

    /**
     * 删除
     */
    public function del(){
        $userId = input('id');
        if(empty($userId)){
            return ajaxReturn(0,'参数不能为空');
        }
        if($userId == 1){
            return ajaxReturn(0,'保留用户无法删除');
        }
        if(model('AdminUser')->del($userId)){
            return ajaxReturn(200,'用户删除成功！');
        }else{
            return ajaxReturn(0,'用户删除失败');
        }
    }
}

