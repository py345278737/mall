<?php
namespace app\api\controller;

use app\api\model\User as UserModel;
use app\api\service\User as UserService;
use app\api\validate\OpenidValidate;
use app\lib\exception\ParameterException;
use app\lib\exception\SessionException;
use app\lib\exception\SuccessMessage;
use think\Exception;
use think\Log;
use think\Request;

class User extends BaseController
{
    protected $code;
    //用户刷新access_token
    protected $refresh_token;
    protected $openid;
    protected $access_token;
    public function login()
    {
        session_start();
        if(!empty($_SESSION['user'])){
            header("Location:".config('wx.index'));
        }else{
            $wxUser = $this->getWxUser();
            $result =  UserModel::get(['openid'=>$this->openid]);
            $userservice = new UserService();
            if (empty($result)){
                $user = $userservice->addUser($wxUser);
                //添加用户信息到session
                $userservice->addUserToSession($user);
            }else{
                //添加用户信息到session
                $userservice->addUserToSession($result);
            }
            header("Location:".config('wx.index'));
        }
    }
    public function getWxUser(){
        $request = Request::instance();
        if(empty($request->get('code'))){
            $this->getCode();
        }else{
            try{
                //已经有了code
                $code = $request->get('code');
                $this->code = $code;
                $access_token = $this->getAccessToken($code);
                $data = json_encode($access_token,true);
                $this->refresh_token = $data['refresh_token'];
                $this->openid = $data['openid'];
                $this->access_token = $data['access_token'];
                $wxUser = $this->getWxUserInfo();
                return $wxUser;
            }catch (Exception $e){
                Log::error('error:'.$e);
                throw new SessionException([
                    'msg' => '获取用户微信信息失败',
                    'errorCode' => 60002
                ]);
            }

        }
    }
    public function getCode(){
        $url = sprintf(config('wx.get_code_url'),config('wx.app_id'),urlencode(config('wx.redirect_uri')),'snsapi_userinfo');
        curl_get($url);
    }
    private function getAccessToken(){
        $url  = sprintf(config('wx.get_access_token_openid_url'),config('wx.app_id'),config('wx.app_secret'),$this->code);
        $access_token = curl_get($url);
        $data = json_decode($access_token,true);
        if(isset($data['errmsg'])){
            Log::error($data['errmsg']);
            throw new SessionException([
                'msg' => '获取用户微信信息失败',
                'errorCode' => 60002
            ]);
        }
        return $data;
    }
    private function getWxUserInfo(){
        $url = sprintf(config('wx.get_userinfo_url'),$this->access_token,$this->openid);
        $user = curl_get($url);
        try{
            $data = json_decode($user,true);
            if(isset($data['errmsg'])){
                throw new SessionException([
                    'msg' => '获取用户微信信息失败',
                    'errorCode' => 60002
                ]);
            }
            return $data;
        }catch (Exception $e){
            Log::error('error:'.$e);
        }
    }
}
