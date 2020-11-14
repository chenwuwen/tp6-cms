<?php

namespace app\model;

use think\Model;
use think\model\concern\SoftDelete;

class OrderInfoModel extends Model
{
    // 使用软删除
    use SoftDelete;
    protected $table = 'order_info';
    protected $deleteTime = 'delete_time';
}
