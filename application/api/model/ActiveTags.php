<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/17 0017
 * Time: 17:16
 */

namespace app\api\model;


class ActiveTags extends BaseModel
{
    protected $hidden = ['id','createtime'];

    public function tagsdetail(){
        return $this->belongsTo('Tags','active_id','id');
    }
}