<?php if(!defined('1cms')) {exit();}?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{$title}</title>
    <meta name="robots" content="noindex">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    {layui:css()}
    {layui:js()}
    {this:css()}
    <script>layui.config({base: '{template}static/'}).extend({index: 'lib/index'}).use(['index','form'],function(){});</script>
    <style>
    .install_step table tr td:nth-child(2){color:#1E9FFF;text-align:center}
    </style>
</head>
<body>

<div class="Cms_install layui-form" lay-filter="install_form"{if $auto && $allow}style="display:none"{/if}>
        <input type="hidden" id="step" name="step" value="">
        <h2>{$title}</h2>
        <div class="layui-row">
            <div class="layui-card">
                <div class="layui-tab layui-tab-brief" lay-filter="user">
                    <ul class="layui-tab-title">
                        <li class="layui-this">系统信息</li>
                        <li>应用信息</li>
                    </ul>
                    <div class="layui-tab-content " style="padding-top:0px">
                        <div class="layui-tab-item layui-show">
                            <table class="layui-table">
                                {loop $infos as $info}
                                    <tr>
                                        <td class="title">{$info.name}</td>
                                        <td{if isset($info.error)} class="error"{/if}>{$info.value}</td>
                                    </tr>
                                {/loop}
                                <tr>
                                    <td class="title">伪静态</td>
                                    <td id="rewrite">
                                        {if $rewrite===1}
                                            开启
                                        {elseif  $rewrite===0}
                                            关闭
                                            {if $nginx}<br>[nginx服务器必须开启,请检查配置]{/if}
                                        {else}
                                            <i class="layui-icon layui-anim layui-anim-rotate layui-anim-loop layui-icon-loading-1"></i>测试中
                                        {/if}
                                    </td>
                                    <input type="hidden" name="rewrite" value="{if $rewrite===1}1{else}0{/if}">
                                </tr>
                            </table>
                        </div>
                        <div class="layui-tab-item">
                            <table class="layui-table" id="classlist">
                                {loop $classlist as $key=>$classtitle}
                                <tr rel="{$key}">
                                <td><input type="checkbox" checked lay-skin="primary" {if $key=='admin' || $key=='layui'}style="visibility:hidden" disabled lay-ignore{/if}></td>
                                <td>{$classtitle}</td>
                                </tr>
                                {/loop}
                            </table>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="layui-card">
                <div class="layui-tab layui-tab-brief" lay-filter="database">
                    <ul class="layui-tab-title">
                        <li{if $database=='sqlite'} class="layui-this"{/if}>Sqlite数据库</li>
                        <li{if $database!='sqlite'} class="layui-this"{/if}>Mysql数据库</li>
                        <input type="hidden" name="database" value="{if $database=='sqlite'}0{else}1{/if}">
                    </ul>
                    <div class="layui-tab-content layadmin-user-login-body">
                        <div class="layui-tab-item{if $database=='sqlite'}  layui-show{/if}">
                            <div>{$sqlitefile} {$sqliteinfo}</div>
                            <input type="hidden" name="sqlitefile" value="{$sqlitefilename}">
                        </div>
                        <div class="layui-tab-item{if $database!='sqlite'}  layui-show{/if}">
                            {if $pdo_mysql || $mysql}
                                <div class="layui-form-item">
                                    <label class="layadmin-user-login-icon layui-icon layui-icon-website"></label>
                                    <input type="text" name="mysql_host" value="{$mysql_host}" placeholder="数据库地址,如:127.0.0.1或者localhost:3306" class="layui-input">
                                </div>
                                <div class="layui-form-item">
                                    <label class="layadmin-user-login-icon layui-icon layui-icon-template-1"></label>
                                    <input type="text" name="mysql_dbname" value="{$mysql_dbname}" placeholder="数据库名" class="layui-input">
                                </div>
                                <div class="layui-form-item">
                                    <label class="layadmin-user-login-icon layui-icon layui-icon-align-left"></label>
                                    <input type="text"  name="prefix" value="{$mysql_prefix}"  placeholder="表名前缀,如1cms_,不要与其他网站冲突" class="layui-input">
                                </div>
                                <div class="layui-form-item">
                                    <label class="layadmin-user-login-icon layui-icon layui-icon-username"></label>
                                    <input type="text" name="mysql_user" value="{$mysql_user}" placeholder="数据库账号" class="layui-input">
                                </div>
                                <div class="layui-form-item">
                                    <label class="layadmin-user-login-icon layui-icon layui-icon-password"></label>
                                    <input type="password" name="mysql_password" value="{$mysql_password}" placeholder="数据库密码" class="layui-input">
                                </div>
                                <div class="layui-form-item">
                                    <input type="checkbox" name="mysql_utf8mb4" lay-skin="primary" title="使用utf8mb4字符集,支持Emoji表情"{if $mysql_charset=='utf8mb4'}checked{/if}>
                                </div>
                            {else}
                                服务器未开启pdo_mysql或Mysql组件,无法使用Mysql数据库
                            {/if}
                        </div>
                    </div>
                </div> 
            </div>

            <div class="layui-card">
                <div class="layui-tab layui-tab-brief" lay-filter="user">
                    <ul class="layui-tab-title">
                        <li class="layui-this">管理信息</li>
                    </ul>
                    <div class="layui-tab-content layadmin-user-login-body">
                        <div class="layui-tab-item layui-show">
                            <div class="layui-form-item">
                                <label class="layadmin-user-login-icon layui-icon layui-icon-dir"></label>
                                <input type="text" name="admindir" value="{$admindir}" class="layui-input" lay-verify="hash" placeholder="自定义后台路径,如:admin">
                            </div>
                            <div class="layui-form-item">
                                <label class="layadmin-user-login-icon layui-icon layui-icon-username"></label>
                                <input type="text" name="userhash" value="{$userhash}" placeholder="管理员账号" class="layui-input" lay-verify="hash" value="">
                            </div>
                            <div class="layui-form-item">
                                <label class="layadmin-user-login-icon layui-icon layui-icon-password"></label>
                                <input type="password" name="passwd" value="{$passwd}" placeholder="管理员密码" class="layui-input" value="">
                            </div>
                            <div class="layui-form-item">
                                <label class="layadmin-user-login-icon layui-icon layui-icon-password"></label>
                                <input type="password" name="passwd2" value="{$passwd}" placeholder="确认密码" class="layui-input" value="">
                            </div>
                            <div class="layui-form-item">
                                <input type="checkbox" name="debug"{if $debug} checked{/if} lay-skin="primary" title="显示报错信息,方便本地调试">
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="layui-form-item" style="margin-top: 20px;">
                {if $allow}
                    <button class="layui-btn layui-btn-fluid cms-btn" lay-submit lay-filter="install_submit">安  装</button>
                {else}
                    <button class="layui-btn layui-btn-fluid layui-btn-disabled" style="color:red">配置错误,无法安装</button>
                {/if}
            </div>
        <div class="install_copyright"><p>© <a href="//1cms.com" target="_blank">1CMS.com</a></p></div>
    </div>
</div> 
<div id="install_step" style="display:none">
    <div class="install_step" style="padding:10px">
        <table lay-size="sm" class="layui-table">
            <tr rel="_database">
                <td>安装数据库</td>
                <td><i class="layui-icon layui-icon-more"></i></td>
            </tr>
            {loop $classlist as $key=>$classtitle}
            <tr rel="{$key}">
                <td>安装 {$classtitle}</td>
                <td><i class="layui-icon layui-icon-more"></i></td>
            </tr>
            {/loop}
            <tr id="trconfig" rel="_config">
                <td>写入配置文件</td>
                <td><i class="layui-icon layui-icon-more"></i></td>
            </tr>
        </table>
        <div style="text-align:center;margin-top:20px"><a class="layui-btn layui-btn-normal">安装中,请稍等</a></div>
    </div> 
</div>
    <script>
    layui.use(['index','form','element'],function(){
        layui.element.on('tab(database)', function(data){
          layui.$('input[name=database]').val(data.index);
        });
        function install_step(step){
            layui.$('.layui-layer-content .install_step table tr[rel='+step+'] td').eq(1).html('<i class="layui-icon layui-icon-loading-1 layui-icon layui-anim layui-anim-rotate layui-anim-loop"></i>');
            layui.$('#step').val(step);
            layui.admin.req({ifdebug:0,type:'post',url:"",data:layui.form.val('install_form'),async:true,beforeSend:function(){
            },done: function(res){
                if (res.installerror)
                {
                    layui.$('.layui-layer-content .install_step table tr[rel='+step+'] td').eq(1).html('<i class="layui-icon layui-icon-close-fill"></i>');
                    if(res.msg){
                        layui.$('.layui-layer-content .install_step table tr[rel='+step+'] td').eq(0).append(' <span style="color:red">'+res.msg+'</span>');
                    }
                    layui.$('.layui-layer-content a.layui-btn').text('安装失败').attr('href','javascript:;');
                }else{
                    layui.$('.layui-layer-content .install_step table tr[rel='+step+'] td').eq(1).html('<i class="layui-icon layui-icon-ok-circle"></i>');
                    if (layui.$('.layui-layer-content .install_step table i.layui-icon-more').length>0)
                    {
                        install_step(layui.$('.layui-layer-content .install_step table i.layui-icon-more').eq(0).parents('tr').attr('rel'));
                    }else{
                        layui.$('.layui-layer-content a.layui-btn').text('安装成功,访问后台').attr('href',res.msg{if $auto}+'?u='+layui.$('input[name=userhash]').val()+'&p='+layui.$('input[name=passwd]').val(){/if});
                        layui.$('.cms-btn[lay-filter=install_submit]').text('已安装').addClass('layui-btn-disabled').removeClass('cms-btn').attr('lay-filter','');
                    }
                }
            }});
        }
        function start_install() {
            layui.$('#install_step tr').each(function(){
                    if (layui.$(this).attr('rel')!='_database' && layui.$(this).attr('rel')!='_config')
                    {
                        layui.$(this).remove();
                    }
                });
                installclasscount=0;
                layui.$('#classlist tr').each(function(){
                    if (layui.$(this).find('input').prop("checked"))
                    {
                        installclasscount++;
                        layui.$('#trconfig').before('<tr rel="'+layui.$(this).attr('rel')+'"><td>安装 '+layui.$(this).find('td').eq(1).text()+'</td><td><i class="layui-icon layui-icon-more"></i></td></tr>');
                    }
                });
                if (layui.$(window).width()<550 || layui.$(window).height()<(installclasscount*30+200))
                {
                    layerarea='auto';
                }else{
                    layerarea=['450px'];
                }
                layer.open({
                  type: 1,
                  move:false,
                  title:'{if $auto}{$title}{else}安装{/if}',
                  closeBtn: {if $auto}0{else}1{/if},
                  shadeClose: false,
                  shade: {if $auto}[1, '#fff']{else}0.8{/if},
                  area: layerarea,
                  content: layui.$('#install_step').html(),
                  success: function(layero, index){
                      layer.close(window.installconfirm);
                      install_step('_database');
                  }
                });
        }
        layui.form.on('submit(install_submit)', function(data){
            if (layui.$('input[name=database]').val()=='0' && layui.$('input[name=sqlitefile]').val()=='')
            {
                layui.view.error('Sqlite配置错误,无法安装');
                return;
            }
            if (layui.$('input[name=database]').val()=='1')
            {
                if (layui.$('input[name=mysql_host]').val()=='')
                {
                    layui.view.error('请填写Mysql数据库连接地址');
                    return;
                }
                if (layui.$('input[name=mysql_dbname]').val()=='')
                {
                    layui.view.error('请填写Mysql数据库名');
                    return;
                }
                if (layui.$('input[name=mysql_user]').val()=='')
                {
                    layui.view.error('请填写Mysql数据库用户名');
                    return;
                }
                if (layui.$('input[name=mysql_password]').val()=='')
                {
                    
                }
            }
            if (layui.$('input[name=userhash]').val()=='')
            {
                layui.view.error('请填写后台用户名');
                return;
            }
            if (layui.$('input[name=passwd]').val()=='')
            {
                layui.view.error('请填写后台密码');
                return;
            }
            if (layui.$('input[name=passwd]').val()!=layui.$('input[name=passwd2]').val())
            {
                layui.view.error('两次密码输入不一致,请重新输入');
                return;
            }
            msg='';
            if (layui.$('input[name=rewrite]').val()=='0')
            {
                msg=msg+"伪静态:关闭<br>";
            }else{
                msg=msg+"伪静态:开启<br>";
            }
            if (layui.$('input[name=database]').val()=='0')
            {
                msg=msg+"数据库:Sqlite<br>";
            }else{
                msg=msg+"数据库:Mysql<br>";
                msg=msg+"数据库地址:"+layui.$('input[name=mysql_host]').val()+"<br>";
                msg=msg+"数据库名:"+layui.$('input[name=mysql_dbname]').val()+"<br>";
            }
            msg=msg+"后台目录:"+layui.$('input[name=admindir]').val()+"<br>";
            window.installconfirm = layui.layer.confirm(msg, {
              btn: ['安装','取消'],title:'是否安装',shadeClose:false}, function(){
                start_install();
            });
          return false;
        });
        device = layui.device();
        if(device.ie && device.ie < 10){
            alert('IE'+ device.ie + '下浏览效果可能不佳，推荐使用：Chrome / Firefox / Edge 等浏览器');
        }
        {if $rewrite!==1 && $rewrite!==0}
            {if $auto && $allow}
                rewritecheck=layui.layer.msg('页面加载中,请稍等', { icon: 16 ,shade: 0.01 });
            {/if}
            layui.admin.req({ifdebug:0,type:'post',url:"class_cms_rewrite_test.html",data:{ test: 1},timeout: 10000,async:true,done: function(res){
                {if $auto && $allow} layer.close(rewritecheck); {/if}
                if (res.test)
                {
                    layui.$('#rewrite').text('正常');
                    layui.$('input[name=rewrite]').val(1);
                }else{
                    layui.$('#rewrite').text('错误');
                }
                {if $auto && $allow}start_install();{/if}
            },error: function(){
                    {if $auto && $allow} layer.close(rewritecheck); {/if}
                    {if $nginx}
                        layui.$('div.Cms_install').show();
                        layui.$('#rewrite').html('未开启,Nginx服务器必须开启伪静态,否则无法正常访问. [<a target="_blank" href="//1cms.com/doc/rewrite.html" style="color:#1E9FFF">查看帮助</a>]');
                        layui.$('button[lay-filter=install_submit]').text('请先配置伪静态规则').addClass('layui-btn-disabled').removeClass('cms-btn').css('color','red').removeAttr('lay-filter');
                    {else}
                        {if $auto && $allow}start_install();{/if}
                        layui.$('#rewrite').html('未开启 [<a target="_blank" href="//1cms.com/doc/rewrite.html" style="color:#1E9FFF">查看帮助</a>]');
                    {/if}
                }
            });
        {else}
            {if $auto && $allow}start_install();{/if}
        {/if}
    });
    </script>
</body>
</html>