<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/20 0020
 * Time: 18:25
 */

namespace app\api\service;


use app\api\model\ActiveInfo;
use app\api\model\ActiveOrder;
use app\lib\exception\OrderStatusException;
use app\lib\exception\SessionException;

class Order
{
    public static function GenerateOrder($data){
        //生成订单前，检测库存,这里暂时不做
        //$status = self::getActiveStatus($data['act_id'],$data['number']);
        $openid= $_SESSION['user']->openid;
        $wx_name = $_SESSION['user']->username;
        $uid = $_SESSION['user']->id;
        $orderNo = self::makeOrderNo();
        if(empty($openid)){
            throw new SessionException([
                'msg' =>'session已失效，请重试'
            ]);
        }
        $order = [
            'order_sn' => $orderNo,
            'act_id' => $data['act_id'],
            //这里要传商品的缩略图是因为有可能id下的活动会变，传图相当于快照
            'thumbnail' => $data['image'],
            'name' => $data['name'],
            'from' => $data['from'],
            'to' => $data['to'],
            's_time' => strtotime($data['s_time']),
            'e_time' => strtotime($data['e_time']),
            'number' => $data['number'],
            'price' => $data['price'],
            'uid' => $uid,
            'contact' => $data['contact'],
            'mobile' => $data['mobile'],
            'idcard' => $data['idcard'],
            'openid' => $openid,
            'wx_name' => $wx_name,
            'createtime' => time(),
            'yingqi' => $data['yingqi'],
            'status' => 0,
        ];
       return self::createOrder($order);
    }
    public static function createOrder($order){
        //$activeOrder = new ActiveOrder();
        //$activeOrder->data($order);
        //save方法返回int，create返回model对象
        //$result = $activeOrder->save();
        $order = ActiveOrder::create($order);
        if (!$order){
            throw new OrderStatusException([
                'code' => 500,
                'msg' => '订单创建失败',
                'errorCode' => 80004
            ]);
        }
        return $order->id;
    }
    public static function makeOrderNo()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn =
            $yCode[intval(date('Y')) - 2017] . strtoupper(dechex(date('m'))) . date(
                'd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf(
                '%02d', rand(0, 99));
        return $orderSn;
    }
    //库存检测，现在先不做
//    public static function getActiveStatus($act_id,$number){
//        $act = ActiveInfo::get($act_id);
//        if(empty($act)){
//            throw new OrderStatusException([
//                'msg' => '商品不存在',
//                'errorCode' => '20000'
//            ]);
//        }
//        if(($act->number - $number) < 0){
//            throw new OrderStatusException();
//        }
//        return true;
//    }
}