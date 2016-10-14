function save_data() {
	if ($('#MENU_NAME').val().length <= 0) {
		alert("菜单名不能为空!");
		return;
	}

	if (g_day_id != -1) {
		$.post("../webapi/menu_api.php?action=edit",
			$("#cj_from").serialize(),
			function (data) {
			var data=eval("("+data+")");
			// alert(data.PARENT_MENU_ID);
			if(data.flag=="1000"){
				alert("保存数据成功");
				$('#AandEwin').window('close');
				$("#dataGrid").datagrid('reload');
			}else{
				alert("保存数据失败，菜单名重复！");
			}
		});
	} else {
		$.post("../webapi/menu_api.php?action=add", $("#cj_from").serialize(),
			function (data) {
			var data=eval("("+data+")");
			// alert(data.PARENT_MENU_ID);
			if(data.flag=="1000"){
				alert("保存数据成功");
				$('#AandEwin').window('close');
				$("#dataGrid").datagrid('reload');
			}else{
				alert("保存数据失败，菜单名重复！");
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
		title:'菜单管理',
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
	g_day_id = rows[0].MENU_ID;
	show_window();

	$('#MENU_ID').val(rows[0].MENU_ID);
	$('#MENU_NAME').val(rows[0].MENU_NAME);
	$('#PARENT_MENU_ID').combotree('setValue',rows[0].PARENT_MENU_ID);

	// $('#PARENT_ROLE_NAME').val(rows[0].parent_name);
	$('#MENU_ICON').val(rows[0].MENU_ICON);
	$('#MENU_URL').val(rows[0].MENU_URL);
	$('#COMMENT').val(rows[0].COMMENT);
	$('#ENABLED').val(rows[0].ENABLED);
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
		listMatId = listMatId + rows[n].MENU_ID + ";";
	}
	$.messager.confirm("操作提示", "是否删除选中的项目？", function (data) {
		if (data) {
			$.post("../webapi/menu_api.php?action=delete", {
				del_list : listMatId
			}, function (data) {
				$("#dataGrid").datagrid('reload');
			});
		}
	});
}
$(document).ready(function(){
	
	$("#p").panel({
		fit:true
	});
	$("#dataGrid").datagrid({   
		title:"菜单管理",
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
	    url:'../webapi/menu_api.php?action=query',  
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
	        {field:'MENU_NAME',title:'菜单名称'},    
	        {field:'parent_menu',title:'上级菜单名称'},    
	        {field:'MENU_ICON',title:'菜单图标'},    
	        {field:'MENU_URL',title:'菜单路径'},    
	        {field:'COMMENT',title:'备注'},    
	        {field:'ENABLED',title:'可用标志',
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
		title:"系统菜单",
		fit:true
	});

	$('#tt').tree({   
		// checkbox:true,
	    url:'../webapi/menu_api.php?action=loadtree',
	    onClick: function(node){
	    	$("#dataGrid").datagrid({
	    		queryParams: {
					MENU_ID : node.id
				}
	    	});
		}
	});

	$('#PARENT_MENU_ID').combotree({    

	    url: '../webapi/menu_api.php?action=loadtree'
	});
});

