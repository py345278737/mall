<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/17 0017
 * Time: 15:30
 */

namespace app\api\controller;


use app\api\model\ActiveCategory;
use app\api\validate\IDMustRequiredValidate;
use app\api\validate\TypeMustRequiredValidate;
use app\lib\exception\MissException;
use think\Request;

class Category
{   /*
    *   通过type来获取分类
   */
    public function getCategoryByType($type = 1){
        $category = ActiveCategory::all(['type' => $type]);
        if (!empty($category)){
            return json([
                'msg' => 'success',
                'data' => $category
            ],200);
        }
        throw new MissException([
            'code' => 200
        ]);
    }
    /*
    *   通过分类id获取分类下所有活动
     */
    public function getActiveByCatrgotyId(){
        (new IDMustRequiredValidate())->goCheck();
        $request = Request::instance();
        $id = $request->param('id','');
        $actives = ActiveCategory::with('actives')->with('actives.tags.tagsDetail')->where('id',$id)->find()->toArray();
        return json([
            'msg' => 'success',
            'data' => $actives
        ],200);
    }


}