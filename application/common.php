<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function diffBetweenTwoDays ($day1, $day2)
{
    $second1 = strtotime($day1);
    $second2 = strtotime($day2);

    if ($second1 < $second2) {
        $tmp = $second2;
        $second2 = $second1;
        $second1 = $tmp;
    }
    return ($second1 - $second2) / 86400;
}
function curl_get($url, &$httpCode = 0){
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    //不做证书校验，部署在linux环境下请改为true
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,10);
    $file_contents = curl_exec($ch);
    $httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $file_contents;
}
function curl_post($url,$data){
    //将数组转化为json字符串，但是此方法下$data中的中文将继续被编码成unicode字符进行传递，要看微信服务器能否自动转换了
    $data = urldecode(json_encode($data));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
//获取一组随机字符串
function getRandChars($length){
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWSYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max = strlen($strPol) - 1;
    for ($i = 0;$i < $length;$i++){
        $str .=$strPol[rand(0,$max)];
    }
    return $str;
}