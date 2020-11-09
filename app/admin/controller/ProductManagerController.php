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
        $productModel = new ProductInfoModel();
        $count = $productModel->count();
        $list = $productModel::select();
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
        $result = $productModel->save($productInfo);
        if ($result) {
            return ResponseResult::Success();
        } else {
            return ResponseResult::Error();
        }
    }
}
