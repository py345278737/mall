<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/17 0017
 * Time: 16:17
 */

namespace app\api\validate;


class IDMustRequiredValidate extends BaseValidate
{
    protected  $rules = [
        'id'  => 'require',
    ];
}