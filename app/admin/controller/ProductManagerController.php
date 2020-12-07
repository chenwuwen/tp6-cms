<?php

namespace app\admin\controller;

use app\BaseController;
use app\lib\ResponseResult;
use app\model\ProductInfoModel;
use think\facade\Log;
use think\facade\View;
use think\annotation\Route;


class ProductManagerController extends BaseController
{
    public function index()
    {
        // 不带任何参数 自动定位当前操作的模板文件
        return View::fetch('product/index');
    }

    public function list()
    {
        $productModel = new ProductInfoModel();

        // $_POST函数获取值,需要取到key存在,否则会报错:未定义数组索引:xxx
        $productNumber = isset($_POST["product_number"]) ? $_POST["product_number"] : '';
        $productName = isset($_POST["product_name"]) ? $_POST["product_name"] : '';

        // 以下的两个where是AND的的关系
        // empty()函数会把0也判断为真,is_numeric()函数判断是否是数字
        if (is_numeric($productNumber)) {
            Log::debug("产品信息过滤查询,productNumber:" . $productNumber);
            $productModel = $productModel->where('product_number', 'LIKE', '%' . $productNumber . '%');
        }
        if (!empty($productName)) {
            Log::debug("产品信息过滤查询,productName:" . $productName);
            $productModel = $productModel->where('product_name', 'like', '%' . $productName . '%');
        }
        $count = $productModel->count();
        // dump($productModel->getLastSql());
        // echo $productModel->getLastSql();
        $list = $productModel->page($_POST["page"], $_POST["limit"])->select();
        return ResponseResult::Success($list, $count);
    }

    public function addOrEditProductIndex()
    {
        $productId = request()->param('productId');
        View::assign('productInfo', null);
        if (!empty($productId)) {
            $productInfo = ProductInfoModel::find($productId);
            View::assign('productInfo', $productInfo);
        }
        return View::fetch('product/product');
    }


    /**
     * 添加或编辑产品信息
     */
    public function addOrEditProduct()
    {
        $productInfo = request()->param();
        $productModel = new ProductInfoModel;
        $result = false;
        if (empty($productInfo['id'])) {
            $result = $productModel->save($productInfo);
        } else {
            $product = $productModel->find($productInfo['id']);
            $result = $product->save($productInfo);
        }

        if ($result) {
            return ResponseResult::Success();
        } else {
            return ResponseResult::Error();
        }
    }

    /**
     * 删除产品
     */
    public function deleteProduct()
    {
        $idStr = request()->param("ids");
        $ids = explode('_', $idStr);
        // 这里的删除是使用了Tp的软删除功能,在模型中配置的
        ProductInfoModel::destroy($ids);
        return ResponseResult::Success();
    }

    /**
     * 导出数据到Excel,使用注解路由
     * @Route("product/export")
     */
    public function export()
    {
        $productInfoModel =  new ProductInfoModel;
        return ResponseResult::Success($productInfoModel->select(),$productInfoModel->count());
    }
}
