<?php

namespace app\lib;

use think\facade\Config;
use think\Response;

class ResponseResult
{

    static function create($code, $msg, $data, $count)
    {
        $result = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
            'count' => $count,
        ];
        return Response::create($result, 'json', 200);
    }

    /**
     * @param int 
     * @param array 
     * @return \think\response\Json
     */
    public static function Success($data = [], $count = NULL)
    {
        return self::create(Config::get('ResponseResultStatus.success_code'), config('ResponseResultStatus.success_msg'), $data, $count);
    }

    public static function Error($code = null, $msg = null)
    {
        if ($code === null) {
            $code = Config::get('ResponseResultStatus.system_error_code');
        }
        if ($msg  === null) {
            $code = Config::get('ResponseResultStatus.error_msg');
        }
        return self::create($code, $msg, null,null);
    }
}
