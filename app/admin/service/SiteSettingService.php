<?php

namespace app\admin\service;

use app\model\SiteSettingModel;
use \think\facade\Db;
use app\model\SysUserModel;

/**
 * 网站设置Service
 */
class SiteSettingService
{

    public function getSiteSettingInfo()
    {
        $siteInfoArray =  SiteSettingModel::select()->toArray();
        // dump($siteInfoArray);
        $siteInfoList = [];
        foreach($siteInfoArray as $siteInfo){
            $siteInfoList[$siteInfo['type']] = $siteInfo['value'];
        }
        // dump($siteInfoList);
        return $siteInfoList;
    }

}
