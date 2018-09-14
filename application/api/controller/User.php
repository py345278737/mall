<?php
namespace app\api\controller;

use app\api\model\User as UserModel;
use app\api\service\User as UserService;
use think\Request;

class User
{
    public function login()
    {
       // $request = Request::instance();
        //$parm = $request->param("code",'');
        $openid = "sadasdasdasd23dasd".time();
        $result =  UserModel::get(['openid'=>$openid]);
        if (empty($result)){

            $userservice = new UserService();
            $user = $userservice->addUser($openid);
            //添加用户信息到session
        }
    }
}
