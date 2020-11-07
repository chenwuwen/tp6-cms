<?php

namespace app\admin\middleware;

use think\facade\Log;


class AuthHandler
{

    public function handle($request, \Closure $next)
    {

        // 前置中间件

        if (empty(session(ADMIN_SESSION_KEY)) && !preg_match('/login/', $request->pathinfo())) {
            Log::debug('未登录状态下访问非登录页面，直接跳转至登录页');
            return redirect(url("/admin/login"));
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
}
