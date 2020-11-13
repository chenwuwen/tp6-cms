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
        a.available,
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
        // \dump($user);
        return $user;
    }

    /**
     * 自动识别
     * 我们已经看到，模型的新增和更新方法都是save方法，系统有一套默认的规则来识别当前的数据需要更新还是新增。
     * 实例化模型后调用save方法表示新增；
     * 查询数据后调用save方法表示更新；
     * 不要在一个模型实例里面做多次更新，会导致部分重复数据不再更新，正确的方式应该是先查询后更新或者使用模型类的update方法更新。
     */
    public function addOrUpdateSysUser($userParam)
    {
        $userParam['update_time'] = date("Y-m-d H:i:s");
        $sysUser = new SysUserModel;
        if (empty($userParam['id'])) {
            $userParam['create_time'] = date("Y-m-d H:i:s");
            $salt = AuthService::getSalt($userParam['user_name']);
            $pass = AuthService::encryption($userParam['user_name'], $userParam['password']);
            $userParam['password'] = $pass;
            $userParam['salt'] = $salt;

            // 保存sys_user表
            $sysUser->save([
                'user_code' => $userParam['user_code'],
                'user_name' => $userParam['user_name'],
                'password' => $userParam['password'],
                'salt' => $userParam['salt'],
                'create_time' => $userParam['create_time'],
                'update_time' => $userParam['update_time'],
            ]);
        } else {
            $userDetail = SysUserModel::find($userParam['id']);
            $salt = $userDetail['salt'];
            if ($userParam['password'] != $userDetail['password']) {
                $userParam['password'] = md5($userParam['password'], $salt);
            }
            $userDetail->save($userParam);
        }
        // \dump($user);
        // \dump($sysUser->getLastSql());
        // 获取自增ID,获取参数传递过来的ID
        $user_id = empty($userParam['id']) ? $sysUser->id : $userParam['id'];
        $sysUserRole = new SysUserRoleModel();
        // 删除用户角色表数据
        $sysUserRole->where('sys_user_id', $user_id)->delete();
        $sysUserRole->sys_user_id =  $user_id;
        $sysUserRole->sys_role_id =  $userParam['role'];
        $sysUserRole->save();
        return true;
    }
}
