<?php

namespace app\controller;

use app\BaseController;
use app\lib\ResponseResult;
use think\file\UploadedFile;
use think\helper\Str;

class UploadController extends BaseController
{


    public function upload()
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 上传到本地服务器(如果你希望上传的文件是可以直接访问或者下载的话，可以使用public存储方式。),自定义存储规则(闭包,这个闭包最终会自动加上扩展名,因此只需要返回文件名即可)
        $savename = \think\facade\Filesystem::disk('public')->putFile('topic', $file, function ($file) {
            $d = date("Y/m/d");
            $fileName = $file->getOriginalName();
            // 获取文件扩展名(不带.)
            $extTmp = $file->getOriginalExtension();
            // $ext = $file->extension();
            $name = '';
            if (!empty($extTmp)) {
                $name =  substr($fileName, 0, (strlen($fileName) - strlen($extTmp) - 1));
                $ext = substr($extTmp, strpos($extTmp, '.', 0));
                $name = $name . '_' . time() ;
            } else {
                $name = $fileName . '_' . time();
            }
            return $d . '/' . $name;
        });
        $savename = '/storage/' . $savename;
        // 字符串替换
        // $path = str_replace('\\', '/', $savename);
        return ResponseResult::Success($savename);
    }
}
