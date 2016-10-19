<?php require 'teach_auth.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head id="Head1">
    <title>乐学派教学系统教师管理运营平台</title>
    <link href="css/default.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="js/themes/default/easyui.css" />
    <link rel="stylesheet" type="text/css" href="js/themes/icon.css" />
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.easyui.min.js"></script>
    <script type="text/javascript" src='js/outlook2.js'> </script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript">

        //设置登录窗口
        function openPwd() {
            $('#w').window({
                title: '修改密码',
                width: 300,
                modal: true,
                shadow: true,
                closed: true,
                height: 200,
                resizable:false
            });
        }
        //关闭登录窗口
        function close() {
            $('#w').window('close');
        }
        //修改密码
        function serverLogin() {
            var $newpass = $('#txtNewPass');
            var $rePass = $('#txtRePass');
            var $txtOldPass= $("#txtOldPass");
            if ($txtOldPass.val() == '') {
                msgShow('系统提示', '请输入旧密码！', 'warning');
                return false;
            }
            if ($newpass.val() == '') {
                msgShow('系统提示', '请输入密码！', 'warning');
                return false;
            }
            if ($rePass.val() == '') {
                msgShow('系统提示', '请在一次输入密码！', 'warning');
                return false;
            }

            if ($newpass.val() != $rePass.val()) {
                msgShow('系统提示', '两次密码不一至！请重新输入', 'warning');
                return false;
            }
            $.ajax({
                 type: "POST",
                 url: "webapi/teach_login_api.php?action=modifyPass",
                 data: {
                    newpass : $newpass.val(),
                    txtOldPass:$txtOldPass.val()
                 },
                 dataType: "json",
                 success: function(data){
                     if (data.flag==1) {
                        $newpass.val('');
                        $rePass.val('');
                        $txtOldPass.val('');
                        msgShow('系统提示', '密码修改成功','info');
                        close();
                     }else{
                        msgShow('系统提示', '密码错误，请重新输入', 'warning');
                     }
                 }
            });
        }

        $(function() {

            openPwd();
            //
            $('#editpass').click(function() {
                $('#w').window('open');
            });

            $('#btnEp').click(function() {
                serverLogin();
            });
            $('#closeW').click(function() {
                close();
            });
            
            $('#loginOut').click(function() {
                $.messager.confirm('系统提示', '您确定要退出本次登录吗?', function(r) {

                    if (r) {
                        $.ajax({
                             type: "POST",
                             url: "webapi/teach_login_api.php?action=loginout",
                             dataType: "text",
                             success: function(data){
                                 location.reload();
                             }
                        });
                    }
                });
            })
        });
    </script>

</head>
<body class="easyui-layout" >
<noscript>
<div style=" position:absolute; z-index:100000; height:90%;top:0px;left:0px; width:90%; background:white; text-align:center;">
    <img src="images/noscript.gif" alt='抱歉，请开启脚本支持！' />
</div></noscript>
    <div data-options="region:'north'" split="true" border="false" style="overflow: hidden; height: 60px;
        background: url(images/art-top_bg.png);
        line-height: 20px;color: #fff; font-family: Verdana, 微软雅黑,黑体">
        <span style="float:right; padding-right:20px;" class="head"><label id="bgclock"></label>&nbsp;欢迎
        <?php
	    if (!isset($_SESSION)) {
            	session_start();
            	echo $_SESSION['USERNAME'];
	    }
        ?>
        <a href="#" id="editpass">修改密码</a> <a href="#" id="loginOut">安全退出</a></span>
        <span style="padding-left:10px; font-size: 16px; "></span>
    </div>
    <div data-options="region:'south'" split="true" style="height: 30px; background: #D2E0F2; ">
        <div class="footer">深圳市纬科联通讯有限公司 版权所有(2015-2020)</div>
    </div>
    <div data-options="region:'west'" split="true" title="导航菜单" style="width:180px;" id="west">
    <div id="accordion" data-options="border:false">
        <!--  导航内容 -->             
    </div>

    </div>
    <div id="mainPanle" data-options="region:'center'" style="background: #eee; overflow-y:hidden">
        <div id="tabs" class="easyui-tabs"  fit="true" border="false" >
            <div title="欢迎使用" style="overflow:hidden;background:url(images/art-welcome.png) repeat-x center 50% ;" id="home" >
            </div>
        </div>
    </div>
    <!--修改密码窗口-->
    <div id="w" class="easyui-window" title="修改密码" collapsible="false" minimizable="false"
        maximizable="false" icon="icon-save"  style="width: 300px; height: 250px; padding: 5px;
        background: #fafafa;">
        <div class="easyui-layout" fit="true">
            <div region="center" border="false" style="padding: 10px; background: #fff; border: 1px solid #ccc;">
                <table cellpadding=3>
                    <tr>
                        <td>旧密码：</td>
                        <td><input id="txtOldPass" type="Password" class="txt01" /></td>
                    </tr>
                    <tr>
                        <td>新密码：</td>
                        <td><input id="txtNewPass" type="Password" class="txt01" /></td>
                    </tr>
                    <tr>
                        <td>确认密码：</td>
                        <td><input id="txtRePass" type="Password" class="txt01" /></td>
                    </tr>
                </table>
            </div>
            <div region="south" border="false" style="text-align: right; height: 30px; line-height: 30px;">
                <a id="btnEp" class="easyui-linkbutton" icon="icon-ok" href="javascript:void(0)" >
                    确定</a> <a class="easyui-linkbutton" icon="icon-cancel" href="javascript:void(0)"
                        id="closeW">取消</a>
            </div>
        </div>
    </div>

    <div id="mm" class="easyui-menu" style="width:150px;">
        <div id="mm-tabclose">关闭</div>
        <div id="mm-tabcloseall">全部关闭</div>
        <div id="mm-tabcloseother">除此之外全部关闭</div>
        <div class="menu-sep"></div>
        <div id="mm-tabcloseright">当前页右侧全部关闭</div>
        <div id="mm-tabcloseleft">当前页左侧全部关闭</div>
        <div class="menu-sep"></div>
        <div id="mm-exit">退出</div>
    </div>


</body>
</html>
