<?php
namespace app\model;
use think\Model;
use think\model\concern\SoftDelete;
class ProductInfoModel extends Model{
    // 使用软删除
    use SoftDelete;
    protected $table = 'product_info';
    protected $deleteTime = 'delete_time';
}

?>