<?php
namespace app\Api\controller;
use think\Controller;
use think\Db;

class Api extends Controller{
    
    public function index()
    {
     //   return 'sjfkjklajd';
       return $this->fetch();
    //    return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">前台index模块 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ad_bd568ce7058a1091"></think>';
    }

    /**
     * 更新字段
     */
    public function upField(){
        $table=input('table');//表名
        $id_name=input('id_name');//条件字段
        $id_value=input('id_value');//条件值
        $field=input('field');//修改的字段
        $field_value=input('field_value');//修改的值
        if ($field_value=='false'){
            $field_value=2;
        }
        if (empty($table)||empty($id_name)||empty($id_value)||empty($field)||$field_value===false){
            return ajaxReturn(0,'参数不足');
        }
        $where[$id_name]=['eq',$id_value];
        $status=Db::name($table)->where($where)->setField($field,$field_value);
        if ($status){
            return ajaxReturn(200,'操作成功');
        }else{
            return ajaxReturn(0,'操作失败');
        }
    }
    /**
     * 切换语言
     */
    public function change(){
        switch (input('lang')) {
            case 'zh-cn':
                cookie('think_var', 'zh-cn');
                break;
            case 'en-us':
                cookie('think_var', 'en-us');
                break;
            //其它语言
        }
        return ajaxReturn(200,'语言切换成功！您现在操作的是'.input('lang'));
    }
}
