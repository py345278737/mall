<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/20 0020
 * Time: 16:18
 */

namespace app\api\controller;


use think\Request;
use app\api\service\Order as orderService;
class Order extends BaseController
{
    protected $beforeActionList = [
        //这里有个问题：placeOrder必须全部小写才能生效
        'checkSessionExits' => ['only' => 'placeorder']
    ];
    //生成订单
    public function placeOrder(){
        /*
         * 下订单之前先判断
         * 1、session是否存在
         * 2、是否有库存
         * */
        $request = Request::instance();
        $params = $request->param();
        $data = array();
        foreach ($params as $key => $value){
            $data[$key] = $value;
        }
        //生成订单。。。
        $order = orderService::order($data);
    }
}