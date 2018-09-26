<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/26 0026
 * Time: 18:07
 */

namespace app\api\controller;

use app\api\validate\IDMustRequiredValidate;
use think\Loader;
use app\api\service\Pay as PayService;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkSessionExits' => ['only' => 'pay']
    ];
    public function pay($id='')
    {
        (new IDMustRequiredValidate()) -> goCheck();
        $pay= new PayService($id);
        return $pay->pay();
    }

}