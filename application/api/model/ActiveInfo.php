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
    protected $hidden = ['active_category_id'];
    protected $type = [
        's_time' => 'timestamp',
        'e_time' => 'timestamp'
    ];
    //查询范围
    protected function base($query)
    {
        $query->where('status','<>',0);
    }
    public function tags(){
        return $this->hasMany('ActiveTags','active_id','id');
    }
    public static function getActivesByFilterPaginate($filter,$page = 1,$size = 20){
        if (isset($filter)){
            return  $query = self::with('tags.tagsDetail')->where('name|from','like','%'.trim($filter).'%')->paginate($size, true, [
                'page' => $page
            ]);
        }else{
            return $query = self::with('tags.tagsDetail')->paginate($size, true, [
                'page' => $page
            ]);
        }

    }
    public  function getDetail(){
        return $this->belongsToMany('Tags','active_tags','tag_id','active_id');
    }
}