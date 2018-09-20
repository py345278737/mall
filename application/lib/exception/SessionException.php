<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/20 0020
 * Time: 17:01
 */

namespace app\lib\exception;


class SessionException extends BaseException
{
    public $code = 200;
    public $msg = '用户未登录';
    public $errorCode = 10006;
}