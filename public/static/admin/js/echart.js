/*
 * @Author: lezhu
 * @Date:   2019-01-22
 * +----------------------------------------------------------------------
 * | jqadmin [ jq酷打造的一款懒人后台模板 ]
 * | Copyright (c) 2017 http://jqadmin.jqcool.net All rights reserved.
 * | Licensed ( http://jqadmin.jqcool.net/licenses/ )
 * | Author: Paco <admin@jqcool.net>
 * +----------------------------------------------------------------------
 */
//模块依赖其它模块，如：layui.define('layer', callback) 该模板依赖echarts 该名称在全局变量config中有引用 
layui.define(['echarts'], function (exports) {
    var echarts = layui.echarts,
        $ = layui.jquery;
        
    var fs=[];       //ph
    var tim = [];         //时间
    var aaa='dsfadfs';

    var myecharts = echarts.init(document.getElementById('echarts'));
    var option = {
        title: {
            text: '未来一周气温变化',
            subtext: '纯属虚构'
        },
        tooltip : {
            trigger: 'axis'
        },
        xAxis: {
            type: 'category',
            data: []
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            name: '二氧化碳',
            type: 'line',
            symbol: 'emptycircle',    //设置折线图中表示每个坐标点的符号；emptycircle：空心圆；emptyrect：空心矩形；circle：实心圆；emptydiamond：菱形       
            data: []
        }]
    };

    $.ajax({
        type: 'post',
        //async : true, 
        url: '/admin/wisdom/index',  //数据传输的控制器方法
        success: function (result) {
            
            console.log(result);
            //console.log(result.data[4]);
            if (result != null) {
                console.log(result[2]);
                //判断data数据
                if (result != null && result.length > 0) {
                    for (var j = 0; j < result.length; j++) {
                        console.log(result.length);
                        fs.push(result[j].value);
                        tim.push(result[j].timestamp);
                    }
                }
            }
            else {
                alert("图表请求data数据为空，可能服务器暂未录入的观测数据，您可以稍后再试！");
                myecharts.hideLoading();
            }
            if (fs != null) {
                console.log('sdfas');
            }
            myecharts.hideLoading();//隐藏加载动画
            myecharts.setOption({
                xAxis: {
                    data: tim
                },
                series: [
                    {
                        name: '二氧化碳',
                        data: fs
                    }]
            });
        },
        error: function () {
            alert("数据加载失败！");
            myecharts.hideLoading();
        }
    });

    console.log(aaa);
    console.log(fs);
    myecharts.setOption(option);
    exports('echart', {});
});