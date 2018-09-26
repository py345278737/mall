<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/26 0026
 * Time: 18:07
 */

namespace app\api\service;

use think\Loader;
use think\Log;
use app\lib\exception\OrderStatusException;
use think\Exception;
Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');
class Pay
{
    private $orderID;
    function __construct($orderID)
    {
        if (!$orderID)
        {
            throw new Exception('订单号不允许为NULL');
        }
        $this->orderID = $orderID;
    }
    public  function pay(){

    }
    private function makeWxPreOrder($order){
        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($order->order_sn);
        $wxOrderData->SetTrade_type('JSAPI');
        $price = $order->price;
        $wxOrderData->SetTotal_fee($price*100);
        $wxOrderData->SetBody($order->name);
        $openid = $_SESSION['user']->openid;
        if($openid != $order->openid){
            throw new OrderStatusException([
                'msg' => '您支付的不是您的订单',
                'errorCode' => 80006
            ]);
        }
        $wxOrderData->SetOpenid($openid);
        $wxOrderData->SetNotify_url(config('wx.pay_back_url'));
        return $this->getPaySignature($wxOrderData);
    }

    private function getPaySignature($wxOrderData){
        $wxOrder = \WxPayApi::unifiedOrder($wxOrderData);
        // 失败时不会返回result_code,这里必须关闭php报错提示（即设置为display_errors = Off），否则会报出$result_code不存在,加了isset就不会报错了
        if((isset($wxOrder['return_code']) && $wxOrder['return_code'] != 'SUCCESS')  || (isset($wxOrder['result_code']) && $wxOrder['result_code'] !='SUCCESS')){
            Log::record($wxOrder,'error');
            Log::record('获取预支付订单失败','error');
            // throw new Exception('获取预支付订单失败');
        }
    }
}