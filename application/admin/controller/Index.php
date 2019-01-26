<?php
namespace app\admin\controller;

class Index extends Admin{
    /**
     * 当前模块参数
     */
    protected function _infoModule(){
        return array(
            'info' => array(
                'name' => '管理首页',
                'description' => '站点运行信息',
            ),
            'menu' => array(
                array(
                    'name' => '首页',
                    'url' => url('index'),
                    'icon' => 'list',
                ),
            ),
        );
    }
    public function index(){
        //前台引导
        $this->assign('home_url',model('HomeUrl')->loadList());
        $this->assign('langList',model('Lang')->loadList());
        $this->assign('loginUserInfo',$this->loginUserInfo);
       // return AjaxLe(model('HomeUrl')->loadList());
        return $this->fetch();
    }
    //控制台
    public function home(){
        //获取当天的年份
        $y = date("Y");
        //获取当天的月份
        $m = date("m");
        //获取当天的号数
        $d = date("d");
        //将今天开始的年月日时分秒，转换成unix时间戳(开始示例：2015-10-12 00:00:00)
        $todayTime= mktime(0,0,0,$m,$d,$y);

        $info=array();
        $info['user_count']=model('User')->countList();//会员总量
        $where_user['add_time']=['gt',$todayTime];
        $info['user_count_today']=model('User')->countList($where_user);//今日注册
        $info['content_count']=model('article/ContentArticle')->countList();//文章总量
        $where_content['time']=['gt',$todayTime];
        $info['content_count_today']=model('article/ContentArticle')->countll($where_content);//今日新增
        $this->assign('info',$info);
        return $this->fetch();
    }
    //后台菜单
    public function menu(){
        $list = model('admin/menu')->menuLoadlist();
        $this->assign('list',$list);
        return $this->fetch();
    }


    //更新账号密码
    public function change(){
        $username=input('post.name');
        $password=md5(input('post.newpass'));

        $map = array();
        $map['username'] = $username;
        $userInfo = model('LepassType')->getWhereInfo($map);
        if(empty($userInfo)){
            return $this->error('用户不存在！');
        }   
        if(model('LepassType')->lechange($userInfo,$password)==1){
            return $this->success('密码重置成功!','index/index');
        }else{
            return $this->error('密码重置失败!');
        }
    //     return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ad_bd568ce7058a1091"></think>';
    }
}
