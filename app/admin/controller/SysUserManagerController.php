<?php

namespace app\admin\controller;

use app\admin\service\SysUserManagerService;
use app\admin\service\AuthService;
use app\BaseController;
use app\lib\ResponseResult;
use app\model\SysRoleModel;
use app\model\SysUserModel;
use app\model\SysUserRoleModel;
use think\facade\View;
use think\facade\Config;

class SysUserManagerController extends BaseController
{

    public function index()
    {
        $roleList = SysRoleModel::select()->toArray();
        View::assign('sysRoleList', $roleList);
        // \dump($roleList);
        return View::fetch("/sys_user/index");
    }


    /**
     * 管理员列表Ajax请求
     */
    public function list()
    {
        $sysUserManagerService = new SysUserManagerService();
        $pageNum = input('post.page', 0, 'int');
        $pageSize = input('post.limit', 30, 'int');
        $userName = input('post.user_name', '', 'trim');
        $roleCode = input('post.role_code', 0, 'int');
        $data = $sysUserManagerService->getSysUserList($userName, $roleCode, $pageNum, $pageSize);
        // \dump($list);
        return ResponseResult::Success($data['list'], $data['count']);
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

        // if ($sysUser['available'] == 'on') {
        //     $sysUser['available'] = 1;
        // } else {
        //     $sysUser['available'] = 0;
        // }

        // layui checkbox 的switch 当未选中状态时,是不传参数的,当为选中状态时,传递的参数的值为 on
        if (isset($sysUser['available'])) {
            $sysUser['available'] = 1;
        } else {
            $sysUser['available'] = 0;
        }

        // \dump($sysUser);
        try {
            $result = $sysUserManagerService->addOrUpdateSysUser($sysUser);
        } catch (\Exception $e) {
            return ResponseResult::Error(null, $e->getMessage());
        }
        if ($result) {
            return ResponseResult::Success();
        } else {
            return ResponseResult::Error(Config::get('ResponseResultStatus.validate_error_code'), "操作失败!");
        }
    }

    /**
     * 修改管理员密码
     */
    public function updatePassword()
    {
        $userDetail =  session(ADMIN_SESSION_KEY);
        $userId = $userDetail['user_id'];
        $userInfo = SysUserModel::find($userId);
        //    原密码
        $oldPassword = $_POST['oldPassword'];
        $pass = \md5($oldPassword . $userInfo['salt']);
        if ($pass == $userInfo['password']) {
            $newPassword = $_POST['password'];
            $newPass = \md5($newPassword . $userInfo['salt']);
            SysUserModel::update(['password' => $newPass, 'id' => $userId]);
            // 修改密码成功清除Session,重新登录
            session(ADMIN_SESSION_KEY, null);
            return ResponseResult::Success();
        } else {
            return ResponseResult::Error(Config::get('ResponseResultStatus.validate_error_code'), '原密码错误!');
        }
    }

    /**
     * 删除,删除用户的同时,也将用户和角色关联的关系删除了
     */
    public function deleteSysUser()
    {
        $idStr = request()->param('ids');

        $ids = explode("_", $idStr);
        SysUserModel::destroy($ids);
        // dump(SysUserModel::getlastsql());
        SysUserRoleModel::where('sys_user_id', 'in', $ids)->delete();
        return ResponseResult::Success();
    }
}
