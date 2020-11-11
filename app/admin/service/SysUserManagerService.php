<?php

namespace app\admin\service;

use app\model\SysRoleModel;
use app\model\SysUserModel;
use app\model\SysUserRole;
use app\model\SysUserRoleModel;
use \think\facade\Db;


class SysUserManagerService
{

    public function getSysUserList($userName, $roleCode, $pageNum, $pageSize)
    {

        // 定义多行字符串
        $sql = <<<sql
        SELECT
        a.id,
        a.user_name,
        a.user_code,
        a.create_time,
        locked,
        c.role_name 
    FROM
        sys_user AS a
        LEFT JOIN sys_user_role AS b ON a.id = b.sys_user_id
        LEFT JOIN sys_role AS c ON b.sys_role_id = c.id WHERE 1=1
    sql;

        if (!empty($userName)) {
            $sql = $sql . ' AND a.user_name like ' . '\'%' . $userName . '%\'';
        }
        // empty()函数会把0也判断为真,因此当参数为0时,不会走if里面的代码
        if (!empty($roleCode)) {
            $sql = $sql . ' AND c.id=' . $roleCode;
        }

        // echo $sql;

        $count = SysUserModel::count();
        // 拼接分页代码
        $sql = $sql . ' limit '  . ($pageNum - 1) * $pageSize . ',' . $pageSize;

        $userList = Db::query($sql);

        $data = ['count' => $count, 'list' => $userList];
        return $data;
    }


    public function getUserDetailByUserId($id)
    {
        // find() 查询一条 select() 查询多条
        $user = SysUserModel::find($id)->toArray();
        // \dump($user);
        $sysRole = SysUserRoleModel::where('sys_user_id', $id)->field('sys_role_id')->find()->toArray();
        // \dump($sysRole);
        $user['sys_role_id'] = $sysRole['sys_role_id'];
        \dump($user);
        return $user;
    }

    public function addOrUpdateSysUser($user)
    {
        if (empty($user['id'])) {
            $user['create_time'] = date("Y-m-d H:i:s");
        }
        $user['update_time'] = date("Y-m-d H:i:s");

        $salt = AuthService::getSalt($user['user_name']);
        $pass = AuthService::encryption($user['user_name'], $user['password']);
        $user['password'] = $pass;
        $user['salt'] = $salt;
        $sysUser = new SysUserModel;
        // \dump($user);
        // 保存sys_user表
        $sysUser->save([
            'user_code' => $user['user_code'],
            'user_name' => $user['user_name'],
            'password' => $user['password'],
            'salt' => $user['salt'],
            'create_time' => $user['create_time'],
            'update_time' => $user['update_time'],
        ]);
        // \dump($sysUser->getLastSql());
        // 获取自增ID
        $user_id = $sysUser->id;
        $sysUserRole = new SysUserRoleModel();
        $sysUserRole->sys_user_id =  $user_id;
        $sysUserRole->sys_role_id =  $user['role'];
        $sysUserRole->save();
        return true;
    }
}
