<?php

namespace app\model;

use think\Model;

class SysUserModel extends Model
{

    // 设置表名,不管前缀后缀
    protected  $table  = 'sys_user';

    // 设置字段信息
    protected $schema = [
        'id'          => 'int',
        'user_name'        => 'string',
        'user_code'      => 'string',
        'password'       => 'string',
        'create_time' => 'date',
        'update_time' => 'date',
        'salt' => 'string',
        'available' => 'char',
    ];
}
