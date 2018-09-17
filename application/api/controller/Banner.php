<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/17 0017
 * Time: 14:36
 */

namespace app\api\controller;


use app\api\model\Config;

class Banner
{
    //获取首页轮播图
    public function getBannerList(){

        $banner = Config::get(['name' => 'index_img']);//无数据时，将返回null
        if (!empty($banner)){
            return json([
                'id' => ''
            ],200);
        }
    }
}