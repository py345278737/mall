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
use app\api\validate\IDMustRequiredValidate;
use app\api\validate\PagingParameter;
use app\api\validate\TypeMustRequiredValidate;
use app\lib\exception\MissException;
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
        $actives = ActiveCategory::with('actives')->with('actives.tags.tagsDetail')->where('type',$type)->find();
        if (empty($actives)){
            throw new MissException();
        }
        return json([
            'msg' => 'success',
            'data' => $actives->toArray()
        ],200);
    }
    /*
     * 分页查询
     * params
     * @filter int notrequired
     * @page int required
     * @size int required
     * @return json
     * */
    public function getActivesByFilterPaginate($filter = null,$page = 1,$size = 20){
        (new PagingParameter())->goCheck();
        $request = Request::instance();
        $parms = $request->param();
        if (isset($parms['filter'])){
            $filter = $parms['filter'];
        }
        $pagingActives = ActiveInfo::getActivesByFilterPaginate($filter,$parms['page'],$parms['size']);
        if ($pagingActives->isEmpty()){
            throw new MissException();
        }
        return json([
            'msg' => 'success',
            'data' => $pagingActives->toArray()
        ],200);
    }
    /*
     * 获取活动详情
     *  params
     *  @id int required
     * */
    public function getDetail(){
        (new IDMustRequiredValidate())->goCheck();
        $request = Request::instance();
        $id = $request->param('id');
        $active = ActiveInfo::with('getDetail')->find($id);
        if (!$active){
            throw new MissException();
        }
        $active = $active->hidden(['createtime','status']);
        return json([
            'msg' => 'success',
            'data' => $active->toArray()
        ],200);
    }
}