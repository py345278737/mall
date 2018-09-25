<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/21 0021
 * Time: 17:46
 */

namespace app\api\validate;


class OrderValidate extends BaseValidate
{
    protected  $rule = [
        'id'  => 'require',
        'act_id'  => 'require',
        'image'  => 'require',
        'name'  => 'require',
        'from'  => 'require',
        'to'  => 'require',
        's_time'  => 'require',
        'e_time'  => 'require',
        'number'  => 'require',
        'price'  => 'require',
        'uid'  => 'require',
        'contact'  => 'require',
        'mobile'  => 'require',
        'idcard'  => 'require',
        'wx_name'  => 'require',
        'yingqi'  => 'require'
    ];
    protected $message = [
        'yingqi' => '营期不能为空'
    ];
}