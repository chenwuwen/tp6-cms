<?php

namespace app\admin\service;

use \think\facade\Db;
use app\model\SysUserModel;

class SysPermissionService
{




    /**
     * 无限极递归分类树
     */
    public static function buildTree($list, $pid)
    {
        $tree = array();

        foreach ($list as $k => $v) {
            $v['title'] = $v['name'];
            if ($v['parentid'] == $pid) {
                $v['children'] = self::buildTree($list, $v['id']);
                $tree[] = $v;
            }
        }
        return $tree;
    }
}
