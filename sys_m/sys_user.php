<?php require '../auth.php';?>
<html>
<head>
 
<link href="../css/default.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../js/themes/default/easyui.css" />
<link rel="stylesheet" type="text/css" href="../js/themes/icon.css" />
<link href="../css/zTreeStyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery.easyui.min.js"></script>
<script type="text/javascript" src="../js/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src='sys_user.js'> </script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body class="easyui-layout">
    <div data-options="region:'west'" split="false"  style="width:280px;height:600px;" data-options="border:false;">
    	<div id="p" class="easyui-panel" style="background:#fafafa;">   
	    	<ul id="tt"></ul>
		</div> 
    </div>
    <div data-options="region:'center'" split="false">
    	<table id="dataGrid"></table> 
    </div>

    <div id="AandEwin" class="easyui-window" collapsible="false" minimizable="false" maximizable="false" closed="true" style="width:400px;height:350px;padding-left:30px">
		<form id="cj_from" name="cj_from">
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
			
			<tr height="30px">
		       <td><div align="right">
		         员工
		       </div></td>
		       <td align="left">信息</td>
		       <td width="10"></td>
		    </tr>
			<tr height="30px">
		        <td><div align="right">
		          员工名称
		        </div></td>
		        <td align="left"> 
		        	<input id="USER_ID" name="USER_ID" type="hidden"></input>
		        	<input id="USERNAME" name="USERNAME" style="width:160px;">  </td>
		               <td width="10"></td>
		    </tr>
		    <tr height="30px">
		        <td><div align="right">
		          登录号
		        </div></td>
		        <td align="left">
		        	<input name="USER_LOGIN_ID" id="USER_LOGIN_ID" style="width:160px;">
		        </td>
		       <td width="10"></td>
		    </tr>
		    <tr height="30px">
		        <td><div align="right">
		          邮箱地址
		        </div></td>
		        <td align="left">
		        	<input name="EMAIL" id="EMAIL" style="width:160px;">
		        </td>
		       <td width="10"></td>
		    </tr>
		    <tr height="30px">
		        <td><div align="right">
		          电话号码
		        </div></td>
		        <td align="left">
		        	<input name="PHONE" id="PHONE" style="width:160px;">
		        </td>
		       <td width="10"></td>
		    </tr>
		    <tr height="30px">
		        <td><div align="right">
		          部门
		        </div></td>
		        <td align="left">
		        	<input name="DEPARTMENT_ID" id="DEPARTMENT_ID" style="width:160px;">
		        </td>
		       <td width="10"></td>
		    </tr>
		    <tr height="30px">
		        <td><div align="right">
		          角色类型
		        </div></td>
		        <td align="left">
		        	<input name="ROLE_ID" id="ROLE_ID" style="width:160px;">
		        </td>
		       <td width="10"></td>
		    </tr>
		    <tr height="30px">
		        <td><div align="right">
		          备注
		        </div></td>
		        <td align="left">
		        	<input name="COMMENT" id="COMMENT" style="width:160px;">
		        </td>
		       <td width="10"></td>
		    </tr>
		    <tr height="30px">
		        <td><div align="right">
		          启用标志
		        </div></td>
		        <td align="left"> 
		        	<select id="FLAG"  name="FLAG" style="width:160px;">
		        		<!-- <option value="" selected>请选择</option> -->
		        		<option value="1">启用</option>
		        		<option value="2">停用</option>
		        	</select> 
		        </td>
		       <td width="10"></td>
		    </tr>
		   	<tr>
		    	<td colspan="3" align="center">
		        <div id="dlg-buttons"> 
		        <a href="javascript:void(0)" class="easyui-linkbutton" onClick="save_data()" iconcls="icon-save">保存</a> 
		        <a href="javascript:void(0)" class="easyui-linkbutton" onClick="close_win()"
		            iconcls="icon-cancel">取消</a> 
		    		</div> 
		        </td>
		    </tr>
		    <div id="menuContent" class="menuContent" style="display:none; position: absolute;z-index:100000;">
				<ul id="treeDemo" class="ztree Combo" style="margin-top:0; width:200px;"></ul>
			</div>
		</table>
		</form>
	</div> 
</body>