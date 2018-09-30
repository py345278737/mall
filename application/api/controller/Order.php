<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/20 0020
 * Time: 16:18
 */

namespace app\api\controller;


use app\api\model\ActiveOrder;
use app\api\validate\IDMustRequiredValidate;
use app\api\validate\OrderValidate;
use app\lib\exception\OrderStatusException;
use think\Log;
use think\Request;
use app\api\service\Order as orderService;
class Order extends BaseController
{
    protected $beforeActionList = [
        //这里有个问题：placeOrder必须全部小写才能生效
        'checkSessionExits' => ['only' => 'placeorder,getallorder,getorderbystatus,getorderbyid']
    ];
    //生成订单
    public function placeOrder(){
        (new OrderValidate())->goCheck();
        /*
         * 下订单之前先判断
         * 1、session是否存在
         * 2、是否有库存
         * */
        $params = input('post.','','trim');
        //生成商户订单。。。
        $id = orderService::GenerateOrder($params);
        if($id){
            //生成未定预订单
            //return $this->makeWxPreOrder($order);
            //返回订单id
            return $id;
        }
    }
    public function getAllOrder(){
        $uid = $_SESSION['user']->id;
        $order = ActiveOrder::all(['uid' => $uid]);
        if(empty($order)){
            throw new OrderStatusException([
                'msg' => '暂无订单数据',
                'errorCode' => '80005'
            ]);
        }
        $order = collection($order)->hidden(['prepay_id'])->toArray();
        return json([
            'msg' => 'success',
            'data' => $order
        ]);
    }
    public function getOrderByStatus(){
        $request = Request::instance();
        $status = $request->param('status');
        $uid = $_SESSION['user']->id;
        $order = ActiveOrder::all(['status' => trim($status),'uid' => $uid]);
        if(empty($order)){
            throw new OrderStatusException([
                'msg' => '暂无订单数据',
                'errorCode' => '80005'
            ]);
        }
        $order = collection($order)->toArray();
        return json([
            'msg' => 'success',
            'data' => $order
        ]);
    }
    public function getOrderById(){
        (new IDMustRequiredValidate())->goCheck();
        $request = Request::instance();
        $id = $request->param('id');
        $order = ActiveOrder::get(trim($id));
        if(empty($order)){
            throw new OrderStatusException([
                'msg' => '暂无订单数据',
                'errorCode' => '80005'
            ]);
        }
        $order = $order->toArray();
        return json([
            'msg' => 'success',
            'data' => $order
        ]);
    }
}