<html>
<head>
<link href="../css/default.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../js/themes/default/easyui.css" />
<link rel="stylesheet" type="text/css" href="../js/themes/icon.css" />
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery.easyui.min.js"></script>
<script type="text/javascript" src="../js/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="../js/echarts.js"></script>
<script type="text/javascript" src='oildevice.js'> </script>
</head>
<!--head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="keywords" content="jquery,ui,easy,easyui,web">
	<meta name="description" content="easyui help you build your web page easily!">
	<title>jQuery EasyUI Demo</title>
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.net/Public/js/easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.net/Public/js/easyui/themes/icon.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="http://www.jeasyui.net/Public/js/easyui/jquery.easyui.min.js"></script>
</head-->

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<body>
	<!--div id="query" style="width:100%;height:80px;line-height: 80px;background: #FFF;padding: 10px;">
		设备编号<input type="text" id="uuid" placeholder="请输入设备IMEI号"/>
		数据类型<select id="type">
		        	<option value="el">el</option>
		        	<option value="ac">ac</option>
		        	<option value="pt">pt</option>
		        </select> 
		开始时间<input type="date" id="start"/>
		结束时间<input type="date" id="end"/>
		<button id="search">查询</button>
	</div-->
	
	<!--div id="DeviceWin" data-options="region:'center'" class="easyui-window" split="false"-->
    	<table id="_dataGrid" class="easyui-datagrid" style="width:100%;height:400px;"></table> 
    <!--/div-->

	<!-- operate view -->
    <div id="optAction" class="easyui-dialog" closed="true" 
			style="padding:5px;width:450px;height:220px;" title="设置参数" iconCls="icon-ok" buttons="#opt-buttons">
		<table border="1" width=100% height=100%>
			<tr>
				<td width=50%>
					<a href="#" id="AddMoreInput" class="btn btn-info"><b>增加上传时间+</b></a></span></p>  
					<div id="inputsWrapper">  
						<div>
							<input type="text" name="mytext[]" id="upTime_1" value="Input time 1" onchange="javascript:if(!/^[0-5]{1}[0-9]{1}:[0-5]{1}[0-5]{1}$/.test(this.value)){alert('正确的时间格式: 00:00');this.value=''};" />
							<a href="#" class="removeclass" style="color: #FF0000">x</a>
						</div>
					</div> 
				</td>
				<td width=50%>
					<b>(正确的时间格式: 00:00)</b></span></p>
					<table>
					<tr>
							<td>开机时间: </td>
							<td><input type="text" id="startupTime" style="width:60px" onchange="javascript:if(!/^[0-5]{1}[0-9]{1}:[0-5]{1}[0-5]{1}$/.test(this.value)){alert('正确的时间格式: 00:00');this.value=''};" /></td>
					</tr>
					<tr>
							<td>关机时间: </td>
							<td><input type="text" id="shutdownTime" style="width:60px" onchange="javascript:if(!/^[0-5]{1}[0-9]{1}:[0-5]{1}[0-5]{1}$/.test(this.value)){alert('正确的时间格式: 00:00');this.value=''};" /></td>
					</tr>
					</table>
				</td>
			</tr>
		</table>
    </div>
	<div id="opt-buttons">
		<!--a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="javascript:alert('Ok')">Ok</a-->
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" id="sendCmd">提交</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#optAction').dialog('close')">取消</a>
	</div>
	
	<!-- history view -->
	<div id="histAction" class="easyui-dialog" closed="true" 
			style="padding:5px;width:1000px;height:500px;" title="历史记录" iconCls="icon-ok" toolbar="#hist-toolbar" buttons="#hist-buttons">
		<div id="histCurve" style="width: 100%;height:100%;">
		</div>
	</div>
	<div id="hist-buttons">
		<!--a href="#" class="easyui-linkbutton" iconCls="icon-ok" id="">确定</a-->
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#histAction').dialog('close')">返回</a>
	</div>
	<div id="hist-toolbar">
		<table cellpadding="0" cellspacing="0" style="width:100%">
			<tr>
				<!--td>
					<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Edit</a>
					<a href="#" class="easyui-linkbutton" iconCls="icon-help" plain="true">Help</a>
				</td>
				<td style="text-align:right">
					<input></input><a href="#" class="easyui-linkbutton" iconCls="icon-search" plain="true"></a>
				</td-->
				<td>
					数据类型:&nbsp;<select id="type">
							<option value="el">电位</option>
							<option value="ac">交流电压</option>
							<option value="pt">恒电位仪</option>
						</select> 
					&nbsp;&nbsp;开始时间:&nbsp;<input id="start" type="text" class="easyui-datebox" required="required" />
					&nbsp;&nbsp;结束时间:&nbsp;<input id="end" type="text" class="easyui-datebox" required="required" />
					&nbsp;&nbsp;<a href="#" id="search" class="easyui-linkbutton" iconCls="icon-search" plain="true"><b>查询</b></a>
					<!--button id="search">查询</button-->
				</td>
				<td style="text-align:right">
					设备号:&nbsp;<b><label id="uuid" class="easyui-label"></label></b>
					<!--设备号:&nbsp;<input type="text" name="uuid" id="uuid" style="width: 60"
                      maxlength="50" class="easyui-validatebox" data-options="required:true" /-->
				</td>
			</tr>
		</table>
	</div>


	<!--div data-options="region:'center'" split="false">
		<table id="dataGrid" class="easyui-datagrid" style="width:100%;height:500px;"
        		url="../../api/getdeviceinfo.php"
        		title="Device Data" iconCls="icon-save"
        		rownumbers="true" pagination="true">
			<thead>
        		<tr>
            		<th field="ID" width="80">ID</th>
            		<th field="DEV_ID" width="80">DeviceID</th>
            		<th field="LOCATION_NUMBER" width="80" align="right">LocationNumber</th>
            		<th field="DEV_STATUS" width="80" align="right">DeviceStatus</th>
            		<th field="RUNNING_STATUS" width="90">RunningStatus</th>
            		<th field="ELEC_POT" width="60" align="center">POT</th>
            		<th field="ALTE_VOL" width="60" align="center">VOL</th>
            		<th field="POTENT" width="60" align="center">PNT</th>
            		<th field="RECV_TIME" width="80" align="center">ReciveTime</th>
            		<th field="UPLOAD_TIME" width="80" align="center">UploadTime</th>
            		<th field="LOCATION_DETAIL" width="160" align="center">Detail</th>
        		</tr>
    		</thead>
		</table>   
	</div-->
</body>
</html>
