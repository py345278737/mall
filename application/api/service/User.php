<?php
namespace app\api\service;
use app\api\model\User as UserModel;
use think\Exception;

class User {
    protected $openid;
    public function addUser($wxUser){
        $this->openid = $wxUser['openid'];
        $result = UserModel::create([
            "username" => $wxUser['nickname'],
            "openid" => $this->openid,
            "avatar" => $wxUser['headimgurl']
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
    public function addUserToSession($obj=null){
        session_start();
        $_SESSION['user'] = $obj;
    }
}


?>