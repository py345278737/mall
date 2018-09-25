<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/21 0021
 * Time: 11:34
 */

namespace app\api\model;


class ActiveOrder extends BaseModel
{
    protected $hidden = ['openid','wx_order_sn','act_id','uid','wx_name','wx_avatar','status'];
    protected $type = [
        's_time' => 'timestamp:Y-m-d',
        'e_time' => 'timestamp:Y-m-d',
        'createtime' => 'timestamp:Y-m-d H:m:s',
        'paytime' => 'timestamp:Y-m-d H:m:s'
    ];
}