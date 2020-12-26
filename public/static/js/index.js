/**

 @Name：layuiAdmin iframe版主入口
 @Author：贤心
 @Site：http://www.layui.com/admin/
 @License：LPPL
    
 */

layui.extend({
  setter: 'js/admin/config' //配置模块
  , admin: 'js/admin/admin' //核心模块
  , view: 'js/admin/view' //视图渲染模块
}).define(['setter', 'admin'], function (exports) {
  var setter = layui.setter
    , element = layui.element
    , admin = layui.admin
    , tabsPage = admin.tabsPage
    , view = layui.view

    //打开标签页
    , openTabsPage = function (url, text) {
      // console.log("打开标签页")
      //遍历页签选项卡
      var matchTo
        , tabs = $('#LAY_app_tabsheader>li')
        , path = url.replace(/(^http(s*):)|(\?[\s\S]*$)/g, '');

      tabs.each(function (index) {
        var li = $(this)
          , layid = li.attr('lay-id');

        if (layid === url) {
          matchTo = true;
          tabsPage.index = index;
        }
      });

      text = text || '新标签页';

      if (setter.pageTabs) {
        //如果未在选项卡中匹配到，则追加选项卡
        if (!matchTo) {
          $(APP_BODY).append([
            '<div class="layadmin-tabsbody-item layui-show">'
            , '<iframe src="' + url + '" frameborder="0" class="layadmin-iframe"></iframe>'
            , '</div>'
          ].join(''));
          tabsPage.index = tabs.length;
          element.tabAdd(FILTER_TAB_TBAS, {
            title: '<span>' + text + '</span>'
            , id: url
            , attr: path
          });
        }
      } else {
        var iframe = admin.tabsBody(admin.tabsPage.index).find('.layadmin-iframe');
        iframe[0].contentWindow.location.href = url;
      }

      //定位当前tabs
      element.tabChange(FILTER_TAB_TBAS, url);
      admin.tabsBodyChange(tabsPage.index, {
        url: url
        , text: text
      });
    }

    , APP_BODY = '#LAY_app_body', FILTER_TAB_TBAS = 'layadmin-layout-tabs'
    , $ = layui.$, $win = $(window);

  //初始
  if (admin.screen() < 2) admin.sideFlexible();

  //将模块根路径设置为 controller 目录
  layui.config({
    base: setter.base + 'js/admin/modules/'
  });

  //扩展 lib 目录下的其它模块(插件)  {/}的意思即代表采用自有路径，即不跟随 base 路径
  // 配置方法：
  // 1.先在 ./admin/config.js 中添加配置扩展的插件
  // 2.修改被添加的插件源码,在源码的最后 添加export()代码,参照 echarts.js 。修改完成后，将插件放到 ./admin/lib/extend目录下
  layui.each(setter.extend, function (index, item) {
    var mods = {};
    // console.log('setter.base:', setter.base)
    // console.log('item:', item)
    mods[item] =  setter.base + 'js/admin/lib/extend/' + item;
    // console.log(mods)
    layui.extend(mods);
  });


  view().autoRender();

  //加载公共模块
  layui.use('common');

  //对外输出
  exports('index', {
    openTabsPage: openTabsPage
  });
});
