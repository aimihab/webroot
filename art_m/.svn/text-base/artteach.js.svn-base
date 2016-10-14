function save_data() {
	if ($('#FILE_TITLE').val().length <= 0) {
		alert("文件名不能为空!");
		return;
	}

	if (g_day_id != -1) {
		var SCHOOL_ID=$('#SCHOOL_ID').combotree('getValues');
		$.post("../webapi/artteach_api.php?action=edit",
			{
				FILE_ID:$("#FILE_ID").val(),
				FILE_NAME:$("#FILE_NAME").val(),
				SCHOOL_ID:SCHOOL_ID,
				COLUMN_ID:$('#COLUMN_ID').combotree('getValue'),
				COMMENTS:$("#COMMENTS").val(),
				STATUS:$("#STATUS").val()
				// $("#cj_from").serialize()
			},
			function (data) {
			var data=eval("("+data+")");
			// alert(data.DEP_ID);
			if(data.flag=="1000"){
				alert("保存数据成功");
				$('#AandEwin').window('close');
				$("#dataGrid").datagrid('reload');
			}else{
				alert("保存数据失败，文件名重复！");
			}
		});
	} else {
		var SCHOOL_ID=$('#SCHOOL_ID').combotree('getValues');
		$.post("../webapi/artteach_api.php?action=add", 
			{
				FILE_NAME:$("#FILE_NAME").val(),
				SCHOOL_ID:SCHOOL_ID,
				COLUMN_ID:$('#COLUMN_ID').combotree('getValue'),
				COMMENTS:$("#COMMENTS").val(),
				STATUS:$("#ENABLED").val()
				// $("#cj_from").serialize()
			},
			function (data) {
			var data=eval("("+data+")");
			// alert(data.DEP_ID);
			if(data.flag=="1000"){
				alert("保存数据成功");
				$('#AandEwin').window('close');
				$("#dataGrid").datagrid('reload');
			}else{
				alert("保存数据失败，文件名重复！");
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
		title:'文件管理',		
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
	g_day_id = rows[0].FILE_ID;
	show_window();
	$('#FILE_ID').val(rows[0].FILE_ID);
	$('#FILE_NAME').val(rows[0].FILE_NAME);
	$('#COLUMN_ID').combotree('setValue',rows[0].COLUMN_ID);
	$('#SHCOOL_ID').combotree('setValues',rows[0].SCHOOL_ID);

	$('#COMMENTS').val(rows[0].COMMENTS);
	$('#STATUS').val(rows[0].STATUS);
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
		listMatId = listMatId + rows[n].ROLE_ID + ";";
	}
	$.messager.confirm("操作提示", "是否删除选中的项目？", function (data) {
		if (data) {
			$.post("../webapi/artteach_api.php?action=delete", {
				del_list : listMatId
			}, function (data) {
				$("#dataGrid").datagrid('reload');
			});
		}
	});
}
$(document).ready(function(){
	
	$("#dataGrid").datagrid({   
		title:"艺术教学",
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
	    url:'../webapi/artteach_api.php?action=query',  
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
	        {field:'FILE_NAME',title:'文件名称'},    
	        {field:'COLUMN_ID',title:'文件类型',width:100},    
	        {field:'LOCAL_PATH',title:'文件本地路径'},
			{field:'DOWNLOAD_URL',title:'文件下载地址'},
			{field:'FILE_SIZE',title:'文件大小'}, 
			{field:'MD5',title:'文件md5sum值'},
			{field:'SNAME',title:'所在学校'},   
	        {field:'UPDATE_TIME',title:'更新时间'},    
			{field:'COMMENTS',title:'备注'},    
	        {field:'STATUS',title:'可用标志',
					formatter: function(value,row,index){
						if (value==0){
							return '启用';
						}else if(value==1){
							return '停用';
						}
					},
					styler: function(value,row,index){
						if (value == 0){
							return 'color:green;';
							
						}else if (value==1) {
							return 'color:red;';
						}
					}}    
	    ]]    
	});  
	$("#p").panel({
		title:"数据结构",
		fit:true
	});

	$('#tt').tree({   
		// checkbox:true,
	    url:'../webapi/artteach_api.php?action=loadtree',
	    onClick: function(node){
	    	$("#dataGrid").datagrid({
	    		queryParams: {
					COLUMN_ID : node.id
				}
	    	});
		}     
	});
	
	
	$('#COLUMN_ID').combotree({ 
		cascadeCheck:false,
		// multiple:true,  
		// checkbox:true,
	    url: '../webapi/artteach_api.php?action=loadtree',
	    onClick:function(node){

	    }
	});
	
	$('#SCHOOL_ID').combotree({ 
		cascadeCheck:false,
		// multiple:true,  
		// checkbox:true,
	    url: '../webapi/artSchool_api.php?action=loadtree',
	    onClick:function(node){

	    }
	});
	
});

