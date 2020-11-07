<?php

namespace app\admin\controller;

use app\admin\service\SysUserManagerService;
use app\BaseController;
use app\lib\ResponseResult;
use app\model\SysRoleModel;
use think\facade\View;
use think\facade\Config;

class SysUserManagerController extends BaseController
{

    public function index()
    {
        $roleList = SysRoleModel::select()->toArray();
        View::assign('roleList', $roleList);
        // \dump($roleList);
        return View::fetch("/sys_user/index");
    }


    /**
     * 管理员列表Ajax请求
     */
    public function list()
    {
        $sysUserManagerService = new SysUserManagerService();
        $pageNum = input('$page', 0, 'int');

        $pageSize = input('$limit', 30, 'int');
        $userName = input('$userName', null, 'trim');
        $roleCode = input('$roleCode', 1, 'int');

        $list = $sysUserManagerService->getSysUserList($userName, $roleCode, $pageNum, $pageSize);
        // \dump($list);
        return ResponseResult::Success($list, 1);
    }

    /**
     * 返回添加/或编辑管理员界面
     */
    public function addOrEditSysUserIndex()
    {
        // 获取路由动态参数
        $id = request()->param('id');
        $roleList = SysRoleModel::select()->toArray();
        View::assign('roleList', $roleList);
        if (empty($id)) {
            View::assign('userDetail', null);
        } else {
            $sysUserManagerService = new SysUserManagerService();
            $userDetail = $sysUserManagerService->getUserDetailByUserId($id);
            View::assign('userDetail', $userDetail);
        }
        return View::fetch("/sys_user/sys_user");
    }


    /**
     * 添加/或编辑管理员
     */
    public function addOrEditSysUser()
    {
        $sysUser = request()->param();
        $sysUserManagerService = new SysUserManagerService();

        // \dump($sysUser);
        try {
            $result = $sysUserManagerService->addOrUpdateSysUser($sysUser);
        } catch (\Exception $e) {
            return ResponseResult::Error(null,$e->getMessage());
        }
        if ($result) {
            return ResponseResult::Success();
        } else {
            return ResponseResult::Error(Config::get('ResponseResultStatus.validate_error_code'),"操作失败!");
        }
    }
}
