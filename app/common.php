<?php

use think\facade\Env;
// 应用公共文件

/**
 * 用户登录的Session的key
 */
define('ADMIN_SESSION_KEY', 'PHP_ADMIN_USER');

/**
 * 自定义方法,模板调用,获取系统环境变量
 */
function getSystemEnv()
{
    // thinkphp的env()助手函数只能获取 app及数据库的配置信息
    // dump(env());
    // php的getenv()函数获取的是,系统配置的环境变量信息
    // dump(getenv());
    // php的$_SERVER变量获取的是当前项目的一些基础信息
    // dump($_SERVER);
    // dump(config());

    // phpinfo()函数虽然能显示系统信息但是由于返回的是boolean类型的值,因此不能通过phpinfo获得一些信息
    // phpinfo(1);

    $appInfo = env();

    $info['系统版本'] = php_uname();
    $info['PHP版本'] = PHP_VERSION;
    $info['Zend版本'] = Zend_Version();
    $info['PHP安装路径'] = DEFAULT_INCLUDE_PATH;
    $info['Zend版本'] = Zend_Version();
    $info['数据库类型'] = $appInfo['DATABASE_TYPE'];
    $info['数据库编码类型'] = $appInfo['DATABASE_CHARSET'];
    $info['系统时区'] = $appInfo['APP_DEFAULT_TIMEZONE'];

    return $info;
}


function  msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true)

{
    if (function_exists("mb_substr")) {

        if ($suffix)

            return mb_substr($str, $start, $length, $charset) . "...";

        else

            return mb_substr($str, $start, $length, $charset);
    } elseif (function_exists('iconv_substr')) {

        if ($suffix)

            return iconv_substr($str, $start, $length, $charset) . "...";

        else

            return iconv_substr($str, $start, $length, $charset);
    }
}
