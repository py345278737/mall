<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/29 0029
 * Time: 8:58
 */

namespace app\lib\exception;


class BannerException extends BaseException
{
    public $code = 404;
    public $msg = 'banner不存在';
    public $errorCode = 40000;
}