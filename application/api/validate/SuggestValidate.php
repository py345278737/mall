<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/25 0025
 * Time: 16:57
 */

namespace app\api\validate;


class SuggestValidate extends BaseValidate
{
    protected  $rule = [
        'type'  => 'require',
        'content'  => 'require',
        'image'  => 'require',
        'phone'  => 'require',
        'name'  => 'require',
    ];
}