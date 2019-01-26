<?php
namespace app\api\model;
use think\Model;

class ContentArticle extends Model 
{
    //测试一下获取表article_content中信息
    public function article_list($page=1,$num=10)
    {
        $result=$this->table('ykb_content')->page($page,$num)->select();
        return $result;
    }

    //获取新闻内容content
    public function article_content($id)
    {
        //用于join的连表查询
        $res=$this->table('ykb_content')->alias('a')->join('ykb_content_article b','a.content_id=b.content_id')->where("a.content_id=$id")->select();
        return $res;

        //下面查询都可以进行
        //$res=$this->table('ykb_content_article')->where(array('content_id' => $id))->select('content');
        //$map['content_id']  = array('eq', $id);
        //$sql= 'select a.*,b.* from ykb_content as a left join ykb_content_article as b on a.content_id=b.content_id where a.content=$id';
        //$res = $this->query($sql);
    }
}

