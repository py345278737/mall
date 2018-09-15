<?php

namespace app\api\validate;

class OpenidValidate extends BaseValidate {
    protected  $rules = [
        'openid'  => 'require',
    ];
}