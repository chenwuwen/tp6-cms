<?php
use app\api\ApiExceptionHandle;
use app\Request;

// 容器Provider定义文件
return [
    'think\Request'          => Request::class,
    'think\exception\Handle' => 'app\\api\\ApiExceptionHandle',
];