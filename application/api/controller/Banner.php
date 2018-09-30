<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/17 0017
 * Time: 14:36
 */

namespace app\api\controller;


use app\api\model\ActiveImg;
use app\lib\exception\BannerException;

class Banner
{
    //获取首页轮播图
    public function getBannerList(){
        //$banner = Config::get(['name' => 'index_img']);//无数据时，将返回null
        $banners =ActiveImg::all();//返回数组对象集（就是数组里包含多个对象）
        if (!empty($banners)){
            return json([
                //对组对象集不能直接toArray，需要将他转换为collection再用toArray函数
                'data' => collection($banners)->toArray()
            ],200);
        }else{
            throw new BannerException();
        }
    }
}