<?php

namespace app\controller;

use app\BaseController;
use app\lib\ResponseResult;

class DownloadController extends BaseController
{


    public function upload()
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 上传到本地服务器(如果你希望上传的文件是可以直接访问或者下载的话，可以使用public存储方式。)
        $savename = \think\facade\Filesystem::disk('public')->putFile('topic', $file);
        // 字符串替换
        $path = str_replace('\\', '/', $savename);
        return ResponseResult::Success($path);
    }
}
