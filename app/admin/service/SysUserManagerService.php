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
            sys_user AS a,
            sys_user_role AS b,
            sys_role AS c 
        WHERE
            a.id = b.sys_user_id 
            AND b.sys_role_id = c.id
    sql;

        $sql . 'AND c.id=' . $roleCode;
        if (empty($userName)) {
            $sql . 'AND a.user_name = ' . $userName;
        }
        $userList = Db::query($sql);
        // $userList = Db::query($sql)->paginate([
        //     'list_rows'=> 20,
        //     'var_page' => 'page',
        // ])->toArray();
        return $userList;
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
