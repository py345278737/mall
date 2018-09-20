<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/20 0020
 * Time: 15:41
 */

namespace app\api\model;


class ActiveComment extends BaseModel
{
    protected $hidden = ['id','user_id','active_info_id','status'];
    protected $type = [
        'createtime' => 'timestamp:Y-m-d H:m:s'
    ];
    protected function base($query)
    {
        $query->where('status','normal');
    }
    public function user()
    {
       return $this->belongsTo('User','user_id','id');
    }
}