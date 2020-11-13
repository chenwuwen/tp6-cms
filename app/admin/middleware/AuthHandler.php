<?php

namespace app\admin\middleware;

use think\facade\Log;
use think\helper\Str;


class AuthHandler
{
    /**
     * 忽略权限检测数组,但是需要登录
     */
    static $IGNORE_PERMISSION_URL = [
        'dashboard', 'updatePassword', "index"
    ];

    public function handle($request, \Closure $next)
    {

        // 前置中间件

        // 判断登录状态
        $requestPath = $request->pathinfo();
        Log::debug($requestPath);
        if (empty(session(ADMIN_SESSION_KEY)) && !preg_match('/login/', $requestPath)) {
            Log::debug('未登录状态下访问非登录页面[' . $requestPath . ']直接跳转至登录页');
            return redirect(url("/admin/login"));
        }

        // 判断是否拥有权限
        foreach (self::$IGNORE_PERMISSION_URL as $ignore) {
            if (Str::contains($requestPath, $ignore)) {
                $response = $next($request);
                return $response;
            }
        }
       
        $permissionCollection = session(ADMIN_SESSION_KEY)['permission'];
        // dump(session(ADMIN_SESSION_KEY));
        // dump($permissionCollection);
        foreach ($permissionCollection  as $permission) {
            $allowUrl = $permission['url'];
            if (!empty($allowUrl)) {
                if (!Str::contains($allowUrl, $requestPath)) {
                    throw new \think\exception\HttpException(403, '你没有权限进行该操作');
                }
            }
        }
        $response = $next($request);
        // 后置中间件
        return $response;
    }

    /**
     * 中间件结束调用
     */
    public function end(\think\Response $response)
    {
        # code...
    }

    /**
     * php并没有标准的startwith函数
     */
    public function startwith($str, $pattern)
    {

        return strpos($str, $pattern) === 0;
    }
}
