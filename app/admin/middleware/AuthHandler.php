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
        'dashboard', "notice", "index", "permission", "logout"
    ];

    public function handle($request, \Closure $next)
    {

        // 前置中间件

        // 判断登录状态
        $requestPath = $request->pathinfo();
        Log::debug('请求的地址： [' . $requestPath . ']');

        // 如果请求的是登录页,则直接返回
        if (preg_match('/login/', $requestPath)) {
            $response = $next($request);
            return $response;
        }

        // 如果session为空,且请求的地址非登录页,则重定向至登录页
        if (empty(session(ADMIN_SESSION_KEY)) && !preg_match('/login/', $requestPath)) {
            Log::debug('未登录状态下访问非登录页面[' . $requestPath . ']直接跳转至登录页');
            return redirect(url("/admin/login"));
        }

        // 判断请求的URI是否在忽略权限数组中
        foreach (self::$IGNORE_PERMISSION_URL as $ignore) {
            if (Str::contains($requestPath, $ignore)) {
                $response = $next($request);
                return $response;
            }
        }

        $permissionCollection = session(ADMIN_SESSION_KEY)['permission'];
        // dump(session(ADMIN_SESSION_KEY));
        // dump($permissionCollection);
        // 判断 $permissionCollection是否是数组
        if (!is_array($permissionCollection)) return;
        foreach ($permissionCollection  as $permission) {
            $allowUrl = $permission['url'];
            if (!empty($allowUrl)) {
                Log::debug('允许请求的地址： [' . $allowUrl . ']');
                // 由于权限是粗粒度权限,因此先将请求URI进行截取,然后进行比较
                // 如请求的Uri是 [aaa/bbb],而数据库保存的只是 [aaa],因此这是粗粒度权限,所以在比较时,需要先截取
                $requestPath = strpos($requestPath, '/') ? substr($requestPath, 0, strpos($requestPath, '/')) : $requestPath;
                if (Str::contains($allowUrl, $requestPath)) {
                    // 如果允许请求的URL包含请求的URL,则直接返回
                    return $next($request);
                }
            }
        }
        // 抛出没有权限的异常,不再向下执行
        throw new \think\exception\HttpException(403, '你没有权限进行该操作');
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
