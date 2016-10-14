function save_data() {
	// if ($('#DEP_NAME').val().length <= 0) {
	// 	alert("部门名不能为空!");
	// 	return;
	// }

	if (g_day_id != -1) {
		$.post("../webapi/sys_user_api.php?action=edit",
			$("#cj_from").serialize(),
			function (data) {
			var data=eval("("+data+")");
			// alert(data.PARENT_USER_ID);
			if(data.flag=="1000"){
				alert("保存数据成功");
				$('#AandEwin').window('close');
				$("#dataGrid").datagrid('reload');
			}else{
				alert("保存数据失败，部门名重复！");
			}
		});
	} else {
		$.post("../webapi/sys_user_api.php?action=add", $("#cj_from").serialize(),
			function (data) {
			var data=eval("("+data+")");
			// alert(data.PARENT_USER_ID);
			if(data.flag=="1000"){
				alert("保存数据成功");
				$('#AandEwin').window('close');
				$("#dataGrid").datagrid('reload');
			}else{
				alert("保存数据失败，部门名重复！");
			}
		});
	}
	return;
}
function close_win() {
	$('#AandEwin').window('close');
}
function show_window() {
	$('#AandEwin').window({
		title:'员工管理',		
		center:true,
		//left:(document.body.clientWidth-$('#AandEwin').width())/2,
		//top:(document.body.clientHeight-$('#AandEwin').height())/2,
		resizable : false,
		modal : true,
		shadow : false,
		closed : false,
		onBeforeClose : function () {}
	});

	$('#AandEwin').window('open');

}
function add_action() {
	g_day_id = -1;
	show_window();
}

var g_day_id = -1;

function edit_action() {

	var rows = $("#dataGrid").datagrid('getSelections');
	if (rows == null || rows.length != 1) {
		$.messager.alert("系统提示", "请选择一个要修改的内容!", "error");
		return;
	}
	g_day_id = rows[0].USER_ID;
	show_window();
	$('#USERNAME').val(rows[0].USERNAME);
	$('#USER_ID').val(rows[0].USER_ID);
	$('#USER_LOGIN_ID').val(rows[0].USER_LOGIN_ID);
	$('#EMAIL').val(rows[0].EMAIL);
	$('#PHONE').val(rows[0].PHONE);
	$('#DEPARTMENT_ID').combotree('setValue',rows[0].DEP_ID);
	$('#ROLE_ID').combobox('setValue',rows[0].ROLE_ID)   
	$('#COMMENT').val(rows[0].COMMENT);
	$('#FLAG').val(rows[0].FLAG);
}

function delete_action() {

	var rows = $("#dataGrid").datagrid('getSelections');
	if (rows == null || rows.length <= 0) {
		$.messager.alert("系统提示", "请选择要删除的内容!", "error");
		return;
	}
	listMatId = "";
	for (n = 0; n < rows.length; n++) {
		// alert(rows[n]);
		listMatId = listMatId + rows[n].USER_ID + ";";
	}
	$.messager.confirm("操作提示", "是否删除选中的项目？", function (data) {
		if (data) {
			$.post("../webapi/sys_user_api.php?action=delete", {
				del_list : listMatId
			}, function (data) {
				$("#dataGrid").datagrid('reload');
			});
		}
	});
}
$(document).ready(function(){
	
	$("#dataGrid").datagrid({   
		title:"用户管理",
		rownumbers : false,
		//显示行号
		nowrap : true,
		//显示条纹
		pagination : true,
		//显示分页工具条
		//充满整个datagrid
		fit:true,
		border : false,
		//singleSelect:false,
		nowrap : true,
		striped : true,

		border : false,
		singleSelect : false,
		selectOnCheck : true,
		checkOnSelect : true,
		sortOrder : 'desc',
		remoteSort : true, 
	    url:'../webapi/sys_user_api.php?action=query',  
		toolbar : ["-", {
				text : '增加',
				iconCls : 'icon-add',
				handler : function () {
					add_action();
				}
			}, {
				text : '修改',
				iconCls : 'icon-edit',
				handler : function () {
					edit_action();
				}
			}, {
				text : '删除',
				iconCls : 'icon-remove',
				handler : function () {
					delete_action();
				}
			}
		],  
	    columns:[[ 
	    	{field : 'ck',checkbox : true},   
	        {field:'USER_LOGIN_ID',title:'登录名'},    
	        {field:'USERNAME',title:'用户名'},    
	        {field:'EMAIL',title:'邮箱地址'},    
	        {field:'PHONE',title:'手机号码'},    
	        {field:'ROLE_NAME',title:'员工角色'},  
	        {field:'DEP_NAME',title:'所属部门'},     
	        {field:'CREATE_TIME',title:'建立时间'},    
	        {field:'COMMENT',title:'备注'},    
	        {field:'FLAG',title:'可用标志',
					formatter: function(value,row,index){
						if (value==1){
							return '启用';
						}else if(value==2){
							return '停用';
						}
					},
					styler: function(value,row,index){
						if (value == 1){
							return 'color:green;';
							
						}else if (value==2) {
							return 'color:red;';
						}
					}}    
	    ]]    
	});  
	$("#p").panel({
		title:"组织机构",
		fit:true
	});

	$('#tt').tree({   
		// checkbox:true,
	    url:'../webapi/department_api.php?action=loadtree',
	    onClick: function(node){
	    	$("#dataGrid").datagrid({
	    		queryParams: {
					DEP_ID : node.id
				}
	    	});
		}     
	});
	$('#DEPARTMENT_ID').combotree({    
		valueField: 'id',    
        textField: 'text',
	    url: '../webapi/department_api.php?action=loadtree',
	    onSelect: function(rec){    
            var url = '../webapi/role_api.php?action=querycombox&comboxid='+rec.id;   
            $('#ROLE_ID').combobox('reload', url);    
        }
	});	
	$('#ROLE_ID').combobox({    
		valueField: 'id',    
        textField: 'text',
	    url: '../webapi/role_api.php?action=querycombox'
	});
});

