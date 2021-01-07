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
        // 删除表中所有数据
        SiteSettingModel::where('1=1')->delete();
        // 从请求的参数中获取key,及key对应的value,将其插入数据库
        $keys = array_keys($params);
        foreach ($params as $key=>$val) {
            // 模型直接静态调用create方法创建并写入
            SiteSettingModel::create(['value' => $val, 'type' => $key]);
        }
        return ResponseResult::Success();
    }
}
