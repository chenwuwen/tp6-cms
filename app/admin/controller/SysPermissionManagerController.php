<?php

namespace app\admin\controller;

use app\admin\service\SysPermissionService;
use app\BaseController;
use app\model\SysPermissionModel;
use think\facade\View;
use app\lib\ResponseResult;

class SysPermissionManagerController extends BaseController
{

    public function index()
    {
        // 默认访问的模板页面是dashboard_controller,因为模板文件是直接放在了view下,所以,需要写成/dashboard
        return View::fetch('/permission/index');
    }


    public function list()
    {
        $sysPermissionModel = new SysPermissionModel;
        $roleId = request()->param('permissionId');
        if (!empty($roleId)) {
            $list = $sysPermissionModel->select([$roleId]);
            $count = 1;
        } else {
            $list = $sysPermissionModel->select();
            $count = $sysPermissionModel->count();
        }

        return ResponseResult::Success($list, $count);
    }

    public function getTree()
    {
        $list = SysPermissionModel::select();
        //  $sysPermissionService = new SysPermissionService ;
        $tree = SysPermissionService::buildTree($list, 0);
        return ResponseResult::Success($tree, 0);
    }

    public function addOrEditPermissionIndex()
    {
        $permissionId = request()->param('permissionId');
        $permissionInfo = null;
        if (!empty($roleId)) {
            $permissionInfo =  SysPermissionModel::find($permissionId);
        }
        return  View::fetch('/role/role', ['permissionInfo' => $permissionInfo]);
    }

    public function addOrEditPermission()
    {
        $role = request()->param();
    }
}
