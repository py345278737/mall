<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/17 0017
 * Time: 15:30
 */

namespace app\api\controller;


use app\api\model\ActiveCategory;
use app\api\model\ActiveTags;
use app\api\validate\IDMustRequiredValidate;
use app\lib\exception\MissException;
use think\Request;

class Category
{   /*
    *   通过type来获取分类
    *   all方法返回的是一个数组，如果需要使用hidden或者visibel append扥方法需要用collection()方法转换一下
    * 1.模型的 all 方法或者 select 方法返回的是一个包含模型对象的二维数组或者数据集对象。
    * 2.get 或者 find 方法返回的是当前模型的对象实例，可以使用模型方法。
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
    public function getActiveByCatrgoryId(){
        (new IDMustRequiredValidate())->goCheck();
        $request = Request::instance();
        $id = $request->param('id','');
        $actives = ActiveCategory::with('actives')->where('id',$id)->find();
        if (empty($actives)){
            throw new MissException();
        }
        $actives = $actives->hidden(['actives.images','actives.Info_content','actives.price_content','actives.pre_content','status','yingqi','actives.createtime']);
        $arr = $actives->toArray()['actives'];
        foreach ($arr as &$value){
            $value['period'] = diffBetweenTwoDays($value['s_time'],$value['e_time']) + 1;
            $value['tags'] = ActiveTags::all($value['active_tags_ids']);
            unset($value['active_tags_ids']);
        }
        return json([
            'msg' => 'success',
            'data' => $arr
        ],200);
    }


}