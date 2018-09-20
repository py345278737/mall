<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/20 0020
 * Time: 17:33
 */

namespace app\api\controller;
use app\lib\exception\SessionException;
use think\Controller;

class BaseController extends Controller
{
    protected function checkSessionExits(){
        session_start();
        if(empty($_SESSION['user'])){
            throw new SessionException();
        }
        return true;
    }
}