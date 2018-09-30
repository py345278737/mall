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
        's_time' => 'timestamp:Y-m-d',
        'e_time' => 'timestamp:Y-m-d'
    ];
    //查询范围
    protected function base($query)
    {
        $query->where('status','<>',0);
    }
    //获取器
    public function getPeriodAttr(){
        $period = diffBetweenTwoDays($this->s_time,$this->e_time) + 1;
        return $period;
    }
    public function tags(){
        return $this->hasMany('ActiveTags','active_id','id');
    }
    public function comments(){
        return $this->hasMany('ActiveComment','active_info_id','id');
    }
    public static function getActivesByFilterPaginate($filter,$cid,$page = 1,$size = 10){
        $query = self::with('tags.tagsDetail');
        if (isset($filter)){
            $query = $query->where('name|from','like','%'.trim($filter).'%');
        }
        if (isset($cid)){
            $query = $query->where('active_category_id','=',$cid);
        }
        return $query = $query->paginate($size, true, [
            'page' => $page
        ]);
    }
    public  function getDetail(){
        return $this->belongsToMany('Tags','active_tags','tag_id','active_id');
    }
}