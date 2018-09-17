<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/17 0017
 * Time: 16:22
 */

namespace app\api\model;


class ActiveInfo extends BaseModel
{
    public function tags(){
        return $this->hasMany('ActiveTags','active_id','id');
    }
}