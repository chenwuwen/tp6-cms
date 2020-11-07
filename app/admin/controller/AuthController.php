<?php

namespace app\admin\controller;

use app\BaseController;
use app\lib\ResponseResult;
use app\admin\service\AuthService;
use think\facade\View;
use think\facade\Session;
use think\facade\Request;
use think\facade\Config;

class AuthController extends BaseController
{

    public function doLogin()
    {
        $userCode =  Request::param("user_code",);
        $password =  Request::param("password");
        $vercode =  Request::param("vercode");

        $data = [
            'usercode' => $userCode,
            'password' => $password,
            'vercode' => $vercode,
        ];

        // 表单验证
        $validate = new \app\admin\SysUserVerify();

        if ($validate->check($data)) {
            $authService =  new AuthService();
            try {
                $result = $authService->checkLoginSysUser($userCode, $password);
            } catch (\Exception $e) {
                if ($e instanceof \think\exception\ValidateException) {
                    //    验证失败
                    return ResponseResult::Error(Config::get('ResponseResultStatus.validate_error_code'), $e->getError());
                }
                halt($e);
                //    系统错误  
                return ResponseResult::Error();
            }
            if (!empty($result)) {
                session(ADMIN_SESSION_KEY,$result);
                
                // 登陆成功
                return ResponseResult::Success();
            }
            // 登陆失败
            return ResponseResult::Error();
        }
        //表单验证失败
        return ResponseResult::Error(Config::get('ResponseResultStatus.validate_error_code'), $validate->getError());
    }

    /**
     * 重定向到登录页
     */
    public function login()
    {

        if (Session::has(ADMIN_SESSION_KEY)) {
            return View::fetch('index/index');
        }
        // 这里没有直接写View::fetch()是因为类名是AuthController,使用View::fetch()默认是找auth_controller/login.html
        return View::fetch('auth/login');
    }


    /**
     * 注销,重定向到登录页
     */
    public function logout()
    {
        Session::delete(ADMIN_SESSION_KEY);
        // 这里没有直接写View::fetch()是因为类名是AuthController,使用View::fetch()默认是找auth_controller/login.html
        return redirect('/admin/');
    }
}
