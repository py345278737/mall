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
        //生成订单前，检测库存
        $status = self::getActiveStatus($data['id'],$data['number']);
        $openid= $_SESSION['user']->openid;
        $wx_name = $_SESSION['user']->username;
        $uid = $_SESSION['user']->id;
        $orderNo = self::makeOrderNo();
        if(empty($openid)){
            throw new SessionException([
                'msg' =>'session已失效，请重试'
            ]);
        }
        if ($status){
            $order = [
                'order_sn' => $orderNo,
                'act_id' => $data['act_id'],
                'thumbnail' => $data['image'],
                'name' => $data['name'],
                'from' => $data['from'],
                'to' => $data['to'],
               // 'courses' => $data['courses'],
                //'object' => $data['object'],
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
    }
    public static function createOrder($order){
        $activeOrder = new ActiveOrder();
        $activeOrder->data($order);
        $result = $activeOrder->save();
        if (!$result){
            throw new OrderStatusException([
                'code' => 500,
                'msg' => '订单创建失败',
                'errorCode' => 80004
            ]);
        }
        return true;
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
    public static function getActiveStatus($orderId,$number){
        $status = ActiveInfo::get($orderId);
        if(empty($status)){
            throw new OrderStatusException([
                'msg' => '商品不存在',
                'errorCode' => '20000'
            ]);
        }
        if(($status->number - $number) < 0){
            throw new OrderStatusException();
        }
        return true;
    }
}