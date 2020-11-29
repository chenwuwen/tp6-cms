<?php

namespace app\admin\controller;

use app\BaseController;
use app\lib\ResponseResult;
use app\model\CustomerInfoModel;
use think\facade\View;
use think\facade\Config;

class CustomerManagerController extends BaseController
{


    public function index()
    {
        return View::fetch('/customer/index');
    }

    public function list()
    {
        $customerInfoModel =  new CustomerInfoModel;
        $customer_name = input('post.customer_name', '', 'trim');
        if (empty($customer_name)) {
            $list = $customerInfoModel->page($_POST["page"], $_POST["limit"])->select();
            $count = CustomerInfoModel::count();
        } else {
            $list = $customerInfoModel->where('customer_name', 'like', '%' . $customer_name . '%')->page($_POST["page"], $_POST["limit"])->select();
            $count = $customerInfoModel->where('customer_name', 'like', '%' . $customer_name . '%')->count();
        }
        // dump($customerInfoModel->getLastSql());
        return ResponseResult::Success($list, $count);
    }

    public function addOrEditCustomerIndex()
    {
        // 获取路由动态参数
        $customerId = request()->param('customerId');
        View::assign('customer', null);
        if (!empty($customerId)) {
            $customerInfo = CustomerInfoModel::find($customerId);
            View::assign('customer',  $customerInfo);
        }
        return View::fetch('/customer/customer');
    }

    public function addOrEditCustomer()
    {
        $customer = request()->param();
        // \dump($customer);

        try {
            $customerInfoModel =  new CustomerInfoModel;
            $result = false;
            if (empty($customer['id'])) {
                $result = $customerInfoModel->save($customer);
            } else {
                $customerInfo = $customerInfoModel->find($customer['id']);
                $result = $customerInfo->save($customer);
            }
            if ($result) {
                return ResponseResult::Success();
            } else {
                return ResponseResult::Error(Config::get('ResponseResultStatus.validate_error_code'), "操作失败!");
            }
        } catch (\Exception $e) {
            return ResponseResult::Error(null, $e->getMessage());
        }
    }

    /**
     * 删除客户
     */
    public function deleteCustomer()
    {
        $idStr = request()->param("ids");
        $ids = explode('_', $idStr);
        // 这里的删除是使用了Tp的软删除功能,在模型中配置的
        CustomerInfoModel::destroy($ids);
        return ResponseResult::Success();
    }
}
