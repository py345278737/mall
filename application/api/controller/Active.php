<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/18 0018
 * Time: 10:02
 */

namespace app\api\controller;


use app\api\model\ActiveCategory;
use app\api\model\ActiveInfo;
use app\api\validate\PagingParameter;
use app\api\validate\TypeMustRequiredValidate;
use think\Request;

class Active
{
    /*
     *  通过type取分类下的所有活动
     *  param
     *  @string type
     * */
    public function getActivesByType(){
        (new TypeMustRequiredValidate())->goCheck();
        $request = Request::instance();
        $type = $request->param('type','');
        $actives = ActiveCategory::with('actives')->with('actives.tags.tagsDetail')->where('type',$type)->find()->toArray();
        return json([
            'msg' => 'success',
            'data' => $actives
        ],200);
    }
    public function getActivesByFilterPaginate($filter = null,$page = 1,$size = 20){
        (new PagingParameter())->goCheck();
        $request = Request::instance();
        $parms = $request->param();
        if (isset($parms['filter'])){
            $filter = $parms['filter'];
        }
        $pagingActives = ActiveInfo::getActivesByFilterPaginate($filter,$parms['page'],$parms['size']);
//        return json([
//            'msg' => 'success',
//            'data' => $pagingActives
//        ],200);
    }
}