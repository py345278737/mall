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
    protected $hidden = ['active_category_id','images','Info_content','price_content','pre_content','status','yingqi'];
    public function tags(){
        return $this->hasMany('ActiveTags','active_id','id');
    }
    public static function getActivesByFilterPaginate($filter,$page = 1,$size = 20){
        if (isset($filter)){
            return  $query = self::where('name|from','like','%'.trim($filter).'%')->with('tags.tagsDetail')->paginate($size, true, [
                'page' => $page
            ]);
        }else{

            return $query = self::paginate($size, true, [
                'page' => $page
            ]);
        }

    }
}