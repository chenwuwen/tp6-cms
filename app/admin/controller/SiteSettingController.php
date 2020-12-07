<?php

namespace app\admin\controller;

use app\admin\service\SiteSettingService;
use app\BaseController;
use app\lib\ResponseResult;
use app\model\SiteSettingModel;
use think\facade\View;
use app\model\SysUserModel;

/**
 * 网站设置Controller
 */
class SiteSettingController extends BaseController
{
    public function index()
    {
        $siteSettingService = new SiteSettingService;
        $siteSettingInfo = $siteSettingService->getSiteSettingInfo();
        return view('/site_setting', ['siteSettingInfo' => $siteSettingInfo]);
    }


    /**
     * 修改网站配置信息
     */
    public function save()
    {
        $params = request()->param();
        // 从请求的参数中获取key,及key对应的value,将其插入数据库
        $keys = array_keys($params);
        foreach ($params as $key=>$val) {
            SiteSettingModel::update(['value' => $val], ['type' => $key]);
        }
        return ResponseResult::Success();
    }
}
