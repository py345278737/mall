<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/27 0027
 * Time: 14:32
 */

namespace app\api\service;

use app\api\model\ActiveOrder;
use think\Db;
use think\Exception;
use think\Loader;
use think\Log;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');
class WxNotify extends \WxPayNotify
{
    public function NotifyProcess($data, &$msg){
        if ($data['result_code'] == 'SUCCESS') {
            Db::startTrans();
            try{
                $orderNo = $data['out_trade_no'];
                $order = ActiveOrder::where('wx_order_sn','=',$orderNo)->lock(true)->find();
                if($order->status == 0){
                    ActiveOrder::where('id','=',$order->id)->update(['status' => 2]);
                }
                Db::commit();
            }catch (Exception $e){
                Db::rollback();
                Log::error($e);
                return false;
            }
        }
        if(!$this->Queryorder($data['transaction_id'])){
            $msg = "微信服务器订单查询失败";
            return false;
        }
        return true;
    }
    public function Queryorder($transaction_id)
    {
        $input = new \WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = \WxPayApi::orderQuery($input);
        if(array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS")
        {
            return true;
        }
        Log::error("query:" . json_encode($result));
        return false;
    }
}