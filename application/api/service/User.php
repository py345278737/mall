<?php
namespace app\api\service;
use app\api\model\User as UserModel;
use think\Exception;

class User {
    protected $openid;
    public function addUser($openid =null){
        $this->openid = $openid;
        $username = "puqiang";
        $password = md5("chaiwei".$_SERVER['REQUEST_TIME'].rand(1000,9999));
        $result = UserModel::create([
            "username" => $username,
            "password" => $password,
            "openid" => $openid
        ]);
        if(!empty($result)){
            return $result;
        }else{
            throw new Exception(
                [
                    'msg' => '用户添加失败',
                    'errorCode' => 500
                ]
            );
        }
    }


}


?>