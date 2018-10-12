<?php
/**
 * Created by 七月.
 * Author: 七月
 * 微信公号：小楼昨夜又秋风
 * 知乎ID: 七月在夏天
 * Date: 2017/2/20
 * Time: 0:10
 */

namespace app\api\validate;


class PagingParameter extends BaseValidate
{
    protected $rule = [
        'page' => 'require',
        'size' => 'require'
    ];

    protected $message = [
        'page' => '分页参数必须',
        'size' => '分页参数必须'
    ];
}