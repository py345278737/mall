<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/17 0017
 * Time: 15:32
 */

namespace app\api\model;

//分类表
class ActiveCategory extends BaseModel
{
    protected $hidden = ['createtime','type'];

    public function actives(){
        return $this->hasMany('ActiveInfo','active_category_id','id');
    }

}