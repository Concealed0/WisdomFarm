<?php
namespace app\api\controller;
use think\Controller;

class Article extends Controller 
{
    //获取数据库文件接口
    public function article()
    {
        $id = input('param.id/d',null);
       

        $page = input('post.page/d',1);
        $limit = input('post.limit/d',10);
    //    return ajaxReturn(array('err'=>$id));
        try{
      //      $article_title = model('ContentArticle');
      //      $article_contents=$article_title->article_content($id);
            if($id == null)
            { 
                return ajaxReturn(array('err'=>'content_id=null'));
            }
            else
            {
                $article_title = model('ContentArticle');
                $article_contents=$article_title->article_content($id);
            }        

        }catch(Exception $e){
            return ajaxReturn(array(
                'status'=>false,
                'err'=>"获取文章失败[".$e."]",
            ));
        }
        
        //回应请求
        return ajaxReturn(array(
            'status'=>true,
            'article_content'=>$article_contents,
            'err'=>"",
        ));

        //return 'api 接口配置';
        
    }
    public function content()
    {
        $page = input('post.page/d',1);
        $limit = input('post.limit/',10);
        try{
            $article_title = model('ContentArticle');
            $article_list=$article_title->article_list($page,$limit);

        }catch(Exception $e){
            return ajaxReturn(array(
                'status'=>false,
                'err'=>"获取文章失败[".$e."]",
            ));
        }
        //回应请求
        return ajaxReturn(array(
            'status'=>true,
            'article_list'=>$article_list,
            'err'=>"",
        ));
    }
}

