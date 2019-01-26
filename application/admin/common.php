<?php
//ajaxReturn返回json数据
function AjaxLe($code){
     // header('Content-Type:application/json; charset=utf-8');
    //  $tmp=array($code);
      //echo json_encode($code, JSON_UNESCAPED_UNICODE);
      return json($code);
  }