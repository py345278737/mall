<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/21 0021
 * Time: 10:15
 */

namespace app\lib\exception;


class OrderStatusException extends BaseException
{
    public $code = 200;
    public $msg = '该商品库存不足';
    public $errorCode = 20001;
}