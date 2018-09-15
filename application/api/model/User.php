<?php

namespace app\api\model;

class User extends BaseModel {

    protected $autoWriteTimestamp = true;
    protected $createTime = 'createtime';// 默认的字段为create_time 和 update_time
    protected $updateTime = 'updatetime';
}


