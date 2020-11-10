<?php

namespace app\admin\controller;

use app\BaseController;
use app\model\SysRoleModel;
use think\facade\View;
use app\lib\ResponseResult;
use app\model\SysPermissionModel;
use app\model\SysRolePermissionModel;

class SysRoleManagerController extends BaseController
{

    public function index()
    {

        $sysRoleModel = new SysRoleModel;
        $list = $sysRoleModel->select();
        View::assign('sysRoleList', $list);
        // 默认访问的模板页面是dashboard_controller,因为模板文件是直接放在了view下,所以,需要写成/dashboard
        return View::fetch('/role/index');
    }


    public function list()
    {
        $sysRoleModel = new SysRoleModel;
        $roleId = request()->param('id');
        if (!empty($roleId)) {
            $list = $sysRoleModel->select([$roleId]);
            $count = 1;
        } else {
            $list = $sysRoleModel->select();
            $count = $sysRoleModel->count();
        }

        return ResponseResult::Success($list, $count);
    }

    public function addOrEditRoleIndex()
    {
        $roleId = request()->param('roleId');
        $roleInfo = null;
        $hasPermissionIds = null;
        if (!empty($roleId)) {
            $roleInfo =  SysRoleModel::find($roleId);
            $hasPermissionIds = SysRolePermissionModel::where('sys_role_id', $roleId)->column('sys_permission_id');
            // 将数组转成字符串
            $hasPermissionIds = implode(",", $hasPermissionIds);
        }

        return  View::fetch('/role/role', ['roleInfo' => $roleInfo, 'hasPermissionIds' => $hasPermissionIds]);
    }

    public function addOrEditRole()
    {
        $role = request()->param();
        $sysRolePermissionModel =  new SysRolePermissionModel;
        if (!empty($role['id'])) {
            // 如果包含roleId,说明是修改,则先删除角色权限关联表数据
            SysRolePermissionModel::where('sys_role_id', $role['id'])->delete();
        };
        $permissionIds = $role['permissionList'];
        $permissionList = explode(',', $permissionIds);
        // dump($permissionList );
        $sysRoleModel = new SysRoleModel;
        $sysRoleModel->save($role);
        $permissionRoleList = array();
        foreach ($permissionList as $value) {
            $permissionRole = ['sys_role_id' => $sysRoleModel['id'], 'sys_permission_id' => $value];
            array_push($permissionRoleList, $permissionRole);
        }

        $sysRolePermissionModel->saveAll($permissionRoleList);
        return ResponseResult::Success();
    }
}
