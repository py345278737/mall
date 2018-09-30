<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

return [
    'app_id' => 'wxc899eaf22d16f342',
    'app_secret' => '123Zxcvbnm',
    //商户号
    'MCHID' => '1515351951',
    'login_url' => "https://api.weixin.qq.com/sns/jscode2session?" .
        "appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",
    'unifiedorder' => 'https://api.mch.weixin.qq.com/pay/unifiedorder',
    //支付回调接口
    'pay_back_url' => '',
    //调用微信用户授权信息后回调地址
    'redirect_uri' => 'qzbx.net.cn/api/user/getWxUser',
    'get_code_url' => 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=%s&state=STATE#wechat_redirect',
    'get_access_token_openid_url' => 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code',
    'fresh_access_token_url' => 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=%s&grant_type=refresh_token&refresh_token=%s',
    'get_userinfo_url' => 'https://api.weixin.qq.com/sns/userinfo?access_token=%s&openid=%s&lang=zh_CN',
    'check_access_token_availability_url' => 'https://api.weixin.qq.com/sns/auth?access_token=%s&openid=%s',
    'index' => 'http://qzbx.net.cn/'
];
