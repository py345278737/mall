<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/25 0025
 * Time: 16:56
 */

namespace app\api\controller;

use app\api\model\ActiveSuggest;
use app\api\validate\SuggestValidate;
use app\lib\exception\SuggestException;
use think\Request;

class Suggest extends BaseController
{
    protected $beforeActionList = [
        //这里有个问题：placeOrder必须全部小写才能生效
        'checkSessionExits' => ['only' => 'pushsuggest']
    ];
    public function pushSuggest(){
        (new SuggestValidate())->goCheck();
        $request = Request::instance();
        $suggest = $request->param();
        $data['type'] = $suggest['type'];
        $data['content'] = $suggest['content'];
        $data['image'] = $suggest['image'];
        $data['phone'] = $suggest['phone'];
        $data['name'] = $suggest['name'];
        $obj = new ActiveSuggest();
        $obj->data($data);
        $result = $obj->save();
        if(!$result){
            throw new SuggestException();
        }
        return json([
            'msg' => 'success'
        ],200);
    }
}