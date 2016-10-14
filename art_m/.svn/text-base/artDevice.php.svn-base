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
<script type="text/javascript" src='artDevice.js'> </script>
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
		         设备
		       </div></td>
		       <td align="left">信息</td>
		       <td width="10"></td>
		    </tr>
			<tr height="30px">
		        <td><div align="right">
		          设备MAC地址
		        </div></td>
		        <td align="left"> 
		        	<input id="DEVICE_ID" name="DEVICE_ID" type="hidden"></input>
		        	<input id="MAC" name="MAC" style="width:160px;">  </td>
		               <td width="10"></td>
		    </tr>
            <tr height="30px">
		        <td><div align="right">
		          设备状态
		        </div></td>
		        <td align="left"> 
		        	<select id="STAUTS"  name="STAUTS" style="width:160px;">
		        		<!-- <option value="" selected>请选择</option> -->
		        		<option value="0">首次登录</option>
		        		<option value="1">未注册</option>
                        <option value="2">正常状态</option>
		        	</select> 
		        </td>
		       <td width="10"></td>
		    </tr>
            <tr height="30px">
		        <td><div align="right">
		          设备所属学校
		        </div></td>
		        <td align="left">
		        	<input name="SCHOOL_ID" id="SCHOOL_ID" style="width:160px;">
		        </td>
		       <td width="10"></td>
		    </tr>
            <tr height="30px">
		        <td><div align="right">
		          关联学生姓名
		        </div></td>
		        <td align="left">
		        	<input name="STUDENT_NAME" id="STUDENT_NAME" style="width:160px;">
		        </td>
		       <td width="10"></td>
		    </tr>
            <tr height="30px">
		        <td><div align="right">
		          关联学生电话
		        </div></td>
		        <td align="left">
		        	<input name="STUDENT_PHONE" id="STUDENT_PHONE" style="width:160px;">
		        </td>
		       <td width="10"></td>
		    </tr>
            <tr height="30px">
		        <td><div align="right">
		          关联学生邮箱
		        </div></td>
		        <td align="left">
		        	<input name="STUDENT_EMAIL" id="STUDENT_EMAIL" style="width:160px;">
		        </td>
		       <td width="10"></td>
		    </tr>
            <tr height="30px">
		        <td><div align="right">
		          入学年份
		        </div></td>
		        <td align="left">
		        	<input name="ENTRY_YEAR" id="ENTRY_YEAR" style="width:160px;">
		        </td>
		       <td width="10"></td>
		    </tr>
            <tr height="30px">
		        <td><div align="right">
		          紧急联系人
		        </div></td>
		        <td align="left">
		        	<input name="EMERGENCY_CONTACT" id="EMERGENCY_CONTACT" style="width:160px;">
		        </td>
		       <td width="10"></td>
		    </tr>
            <tr height="30px">
		        <td><div align="right">
		          紧急联系人电话
		        </div></td>
		        <td align="left">
		        	<input name="EMERGENCY_PHONE" id="EMERGENCY_PHONE" style="width:160px;">
		        </td>
		       <td width="10"></td>
		    </tr>
		    <tr height="30px">
		        <td><div align="right">
		          备注
		        </div></td>
		        <td align="left">
		        	<input name="COMMENTS" id="COMMENTS" style="width:160px;">
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