<?php

namespace app\api\validate;

class OpenidValidate extends BaseValidate {
    protected  $rule = [
        'openid'  => 'require',
    ];
}