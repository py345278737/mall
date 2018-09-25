<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/25 0025
 * Time: 17:15
 */

namespace app\lib\exception;


class SuggestException extends BaseException
{
    public $code = 200;
    public $msg = '反馈提交失败';
    public $errorCode = 90000;
}