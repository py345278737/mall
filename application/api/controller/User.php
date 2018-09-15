<?php
namespace app\api\controller;

use app\api\model\User as UserModel;
use app\api\service\User as UserService;
use app\api\validate\OpenidValidate;
use app\lib\exception\ParameterException;
use app\lib\exception\SuccessMessage;
use think\Request;

class User
{
    public function login()
    {
        (new OpenidValidate())->goCheck();
        $request = Request::instance();
        $parm = $request->param("openid",'');
        $openid = $parm;
        $result =  UserModel::get(['openid'=>$openid]);
        $userservice = new UserService();
        if (empty($result)){
            $user = $userservice->addUser($openid);
            //添加用户信息到session
            $userservice->addUserToSession($user);
        }else{
            $userservice->addUserToSession($result);
        }
        //var_dump($_SESSION['user']->username);
        return json(new SuccessMessage());
    }
}
