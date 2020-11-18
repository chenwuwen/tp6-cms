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

/**
 * 生成订单编号
 */
function get_sn()
{
    //生成24位唯一订单号码，格式：YYYY-MMDD-HHII-SS-NNNN,NNNN-CC，其中：YYYY=年份，MM=月份，DD=日期，HH=24格式小时，II=分，SS=秒，NNNNNNNN=随机数，CC=检查码

    @date_default_timezone_set("PRC");
    //订购日期

    $order_date = date('Y-m-d');

    //订单号码主体（YYYYMMDDHHIISSNNNNNNNN）

    $order_id_main = date('YmdHis') . rand(10000000, 99999999);

    //订单号码主体长度

    $order_id_len = strlen($order_id_main);

    $order_id_sum = 0;

    for ($i = 0; $i < $order_id_len; $i++) {

        $order_id_sum += (int)(substr($order_id_main, $i, 1));
    }

    //唯一订单号码（YYYYMMDDHHIISSNNNNNNNNCC）

    $order_id = $order_id_main . str_pad((100 - $order_id_sum % 100) % 100, 2, '0', STR_PAD_LEFT);

    return $order_id;
}
