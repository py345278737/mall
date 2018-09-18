<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/18 0018
 * Time: 9:38
 */

namespace app\api\validate;


class TypeMustRequiredValidate extends BaseValidate
{
    protected  $rule = [
        'type'  => 'require',
    ];
}