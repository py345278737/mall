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
    public function getTagsAttr($value,$data){
        $tags = ActiveTags::all($data['active_tags_ids']);
        return $tags;
    }
//    public function tags(){
//        return $this->hasMany('ActiveTags','active_id','id');
//    }
    public function comments(){
        return $this->hasMany('ActiveComment','active_info_id','id');
    }
    public static function getActivesByFilterPaginate($filter,$cid,$page = 1,$size = 10,$sort){
        $query = new ActiveInfo();
        if (!empty($filter)){
            $query = $query->where('name|to','like','%'.trim($filter).'%');
        }
        if (!empty($cid)){
            $query = $query->where('active_category_id','=',$cid);
        }
        if (!empty($sort) && $sort == '2'){
            $query = $query->order('price asc');
        }
        if (!empty($sort) && $sort == '3'){
            $query = $query->order('price desc');
        }
        return $query = $query->paginate($size, true, [
            'page' => $page
        ]);
    }
//    public  function getDetail(){
//        return $this->belongsToMany('Tags','active_tags','tag_id','active_id');
//    }
}