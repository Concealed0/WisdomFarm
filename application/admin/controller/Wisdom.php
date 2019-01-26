<?php
namespace app\admin\controller;

use think\Controller;

class Wisdom extends Controller
{
    public function index()
    {
        $wisdom= model('WisdomType');
        $res=$wisdom->lezhu();
        return AjaxLe($res);
    }

    //平度
    //打开A1 对照观测点页面
    public function pfixed()
    {
        return $this->fetch('wisdom\pingdu\A1fixed');
    }

    //打开A0 对照观测点页面
    public function pscene()
    {
        return $this->fetch('wisdom\pingdu\A0scene');
    }
    //打开A2 地膜监测点页面
    public function pmonitor()
    {
        return $this->fetch('wisdom\pingdu\A2monitor');
    }
    //打开A3 地膜监测点页面
    public function pmonitora()
    {
        return $this->fetch('wisdom\pingdu\A3monitor');
    }


    //威海区域

    //打开A0 对照观测点页面
    public function wscene()
    {
        return $this->fetch('wisdom\weihai\A0scene');
    }
    //打开A1 地膜监测点页面
    public function wmonitor()
    {
        return $this->fetch('wisdom\weihai\A1monitor');
    }
    




    //所有气象站 数据api
    public function alldata()
    {
        //$stat=input('post.stat/d');
        $stat['start']=input('post.start');
        $stat['end']=input('post.end');
        $stat['stat']=input('post.stat/d');
        $wisdom=model('WisdomType');
        $metaid=$wisdom->metaid($stat); 
        //return json($data);
        $meta=$wisdom->meta($metaid);
        //dump($num);
    /*    $num = count($data); 
        for($i=0;$i<$num;$i++){
            echo $data[$i];
        }
        */        
        $data=$wisdom->A1data($metaid,$stat);
        $DATA['data']=$data;
        $DATA['meta']=$meta;
        return AjaxLe($DATA);
    }

    //获取平度所有气象站
    public function allmeta(){

        $aaa=model('WisdomType');
        $allmeta=$aaa->allmeta();

        $this->assign('allmeta',$allmeta);
        //return ajaxReturn($wisdom_data);
        return $this->fetch('a');
        //dump(allmeta);


        //return ajaxReturn($allmeta);
        //echo "dsafdf";
       // dump($allmeta);
    }



    
}