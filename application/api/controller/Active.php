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
     *  通过分配表的type获取分类下的所有活动
     *  param
     *  @string type
     * */
    public function getActivesByType(){
        (new TypeMustRequiredValidate())->goCheck();
        $request = Request::instance();
        $type = $request->param('type','');
        $actives = ActiveCategory::with('actives')->with('actives.tags.tagsDetail')->where('type',$type)->find();
        $actives = $actives->toArray()['actives'];
        foreach ($actives as &$value){
            $value['period'] = diffBetweenTwoDays($value['s_time'],$value['e_time']) + 1;
        }
        if (empty($actives)){
            throw new MissException();
        }
        return json([
            'msg' => 'success',
            'data' => $actives
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
    public function getActivesByFilterPaginate($filter = null,$cid = null,$page = 1,$size = 10){
        (new PagingParameter())->goCheck();
        $request = Request::instance();
        $parms = $request->param();
        if (isset($parms['filter'])){
            $filter = $parms['filter'];
        }
        if(isset($parms['cid'])){
            $cid = $parms['cid'];
        }
        $pagingActives = ActiveInfo::getActivesByFilterPaginate($filter,$cid,$parms['page'],$parms['size']);
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
        //find方法返回的是模型对象
        $active = ActiveInfo::with(['getDetail','comments','comments.user'])->find($id)->hidden(['comments.updatetime']);
        if (!$active){
            throw new MissException();
        }
        $active = $active->hidden(['createtime','status'])->append(['period'])->toArray();
        return json([
            'msg' => 'success',
            'data' => $active
        ],200);
    }
}