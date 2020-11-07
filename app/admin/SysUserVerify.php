<?php

namespace app\admin;

use think\Validate;

/**
 * 自定义登录验证类
 */
class SysUserVerify extends Validate{

    protected $rule = [
        'usercode' => 'require',
        'password' => 'require',
        'vercode' => 'require|checkCaptcha',
    ];

    protected $message=[
        'usercode' => '用户名不能为空',
        'password' => '密码不能为空',
        'vercode' => '验证码不能为空', 
    ];

    /**
     * 检查验证码
     */
    protected function checkCaptcha( $value,$rule,$data=[]  ){
        // captcha_check thinkphp 内置的验证码检测方法
        if(!captcha_check($value)){
            return "验证码不正确";
        }
        return true;
    }
}