<?php

namespace app\admin\service;

use \think\facade\Db;
use app\model\SysUserModel;

class AuthService
{

    /**
     * 检测用户是否存在
     */
    public function checkLoginSysUser(string $usercode, string $password)
    {
        // 查询数据不存在的时候返回空数组
        $sysUser = SysUserModel::where('user_code', $usercode)->findOrEmpty();
        if ($sysUser->isEmpty()) {
            throw new \think\exception\ValidateException("登录名不存在");
        }

        $tmpPass = md5($password . $sysUser['salt']);
        if ($tmpPass == $sysUser['password']) {
            $userDetail = self::getUserDetail($sysUser);
            // halt($userDetail);
            return $userDetail;
        } else {
            throw new \think\exception\ValidateException("密码错误");
        }
    }


    /**
     * 加密密码
     */
    public static function encryption($username, $password)
    {
        $salt =  self::getSalt($username);
        return \md5($password . $salt);
    }

    /**
     * 得到盐值,盐值是根据用户名MD5得来的,以后不会更改,验证密码是通过密码+盐值做MD5来验证的
     */
    public static function getSalt($username)
    {
        return \md5($username);
    }

    /**
     * 查询用户明细数据
     */
    public static function getUserDetail($user)
    {


        // 使用thinkPHP的关联查询 https://www.suibianlu.com/c/p/3180.html 
        // https://blog.csdn.net/sinat_29326171/article/details/108924171
        $role = Db::name('sys_user_role')->alias('a')
            ->join('sys_role b', 'a.sys_role_id=b.id')
            ->field('b.role_name')
            ->where('a.sys_user_id', $user['id'])
            ->select()
            ->toArray();
        // halt($role);

        // 使用原生查询

        $permission = Db::query("SELECT c.* FROM  
            sys_user_role AS A , sys_role_permission AS B, sys_permission AS C 
            WHERE A.sys_role_id = B.sys_role_id AND B.sys_permission_id = C.id AND A.sys_user_id= :id", ['id' => $user['id']]);

        // halt($permission);
        $userDetail = [
            'user_id' => $user['id'],
            'user_name' => $user['user_name'],
            'role' => $role,
            'permission' => $permission,
        ];

        return $userDetail;
    }
}
