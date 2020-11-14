<?php

namespace app\model;

use think\Model;
use think\model\concern\SoftDelete;

class CustomerInfoModel extends Model
{
    // 使用软删除
    use SoftDelete;
    protected $table = 'customer_info';
    protected $deleteTime = 'delete_time';
}
