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
    protected $hidden = ['id','createtime','tag_id','active_id','pivot'];

//    public function tagsDetail(){
//        return $this->belongsTo('Tags','tag_id','id');
//    }
}