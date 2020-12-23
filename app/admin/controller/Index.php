<?php

namespace app\admin\controller;

use app\admin\service\SiteSettingService;
use app\BaseController;
use app\model\SiteSettingModel;
use think\facade\View;

class Index extends BaseController
{
    /**
     * 登陆完成的首页,主要负责菜单生成
     * @return string
     */
    public function index()
    {
        // Session信息中保存了,用户ID/用户名/用户角色/用户所有权限
        $userDetail = session(ADMIN_SESSION_KEY);

        $siteSettingService = new SiteSettingService();
        $siteSettingInfo =  $siteSettingService->getSiteSettingInfo();

        // dump($userDetail);
        // 设置模板变量
        View::assign('permissionList', $userDetail['permission']);
        View::assign('siteSettingInfo', $siteSettingInfo);

        // 不带任何参数 自动定位当前操作的模板文件
        return View::fetch();
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
}
