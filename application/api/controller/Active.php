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
use app\api\model\ActiveTags;
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
        $actives = ActiveCategory::with('actives')->where('type',$type)->find();
        $actives = $actives->toArray()['actives'];
        foreach ($actives as &$value){
            $value['period'] = diffBetweenTwoDays($value['s_time'],$value['e_time']) + 1;
            $value['tags'] = ActiveTags::all($value['active_tags_ids']);
            unset($value['active_tags_ids']);
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
    public function getActivesByFilterPaginate($filter = null,$cid = null,$page = 1,$size = 10,$sort = null){
        (new PagingParameter())->goCheck();
        $request = Request::instance();
        $parms = $request->param();
        if (!empty($parms['filter'])){
            $filter = $parms['filter'];
        }
        if(!empty($parms['cid'])){
            //var_dump($parms['cid']);die;null传过来居然变成了空字符串。。。奇怪
            $cid = (int)$parms['cid'];
        }
        $pagingActives = ActiveInfo::getActivesByFilterPaginate($filter,$cid,$parms['page'],$parms['size'],$sort);
        if ($pagingActives->isEmpty()){
            throw new MissException();
        }
        $pagingActives = $pagingActives->toArray();
        foreach ($pagingActives['data'] as &$value){
            $tags = ActiveTags::all($value['active_tags_ids']);
            $value['tags'] = $tags;
            $value['period'] = diffBetweenTwoDays($value['s_time'],$value['e_time']) + 1;
            unset($value['active_tags_ids']);
        }
        return json([
            'msg' => 'success',
            'data' => $pagingActives
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
        $active = ActiveInfo::with(['comments','comments.user'])->find($id)->hidden(['comments.updatetime']);
        if (!$active){
            throw new MissException();
        }
        $active = $active->hidden(['createtime','status'])->append(['period','tags'])->toArray();
        return json([
            'msg' => 'success',
            'data' => $active
        ],200);
    }
}