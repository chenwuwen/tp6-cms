<?php

namespace app\admin\controller;

use app\BaseController;
use app\lib\ResponseResult;
use app\model\ProductInfoModel;
use think\facade\View;

class ProductManagerController extends BaseController
{
    public function index()
    {
        // 不带任何参数 自动定位当前操作的模板文件
        return View::fetch('product/index');
    }

    public function list()
    {
        $product = new ProductInfoModel();
        $count = $product->count();
        $list = $product::select();
        return ResponseResult::Success($list, $count);

        # code...
    }

    public function addOrEditProductIndex()
    {
        $productId = request()->param('productId');
        View::assign('productInfo', null);
        if (empty($productId)) {
            $productModel = new ProductInfoModel();
            $productInfo =  $productModel->find($productId);
            View::assign('productInfo', $productInfo);
        }
        return View::fetch('product/product');
    }


    public function addOrEditProduct($productInfo)
    {
        $productModel = new ProductInfoModel();
        $result = $productModel->save($productInfo);
        if ($result) {
            return ResponseResult::Success();
        } else {
            return ResponseResult::Error();
        }
    }
}
