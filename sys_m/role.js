function save_data() {
	if ($('#ROLE_NAME').val().length <= 0) {
		alert("角色名不能为空!");
		return;
	}

	if (g_day_id != -1) {
		var ROLE_MENU_ID=$('#ROLE_MENU_ID').combotree('getValues');
		$.post("../webapi/role_api.php?action=edit",
			{
				ROLE_ID:$("#ROLE_ID").val(),
				ROLE_NAME:$("#ROLE_NAME").val(),
				ROLE_MENU_ID:ROLE_MENU_ID,
				DEP_ID:$('#DEP_ID').combotree('getValue'),
				COMMENT:$("#COMMENT").val(),
				ENABLED:$("#ENABLED").val()
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
				alert("保存数据失败，部门名重复！");
			}
		});
	} else {
		var ROLE_MENU_ID=$('#ROLE_MENU_ID').combotree('getValues');
		$.post("../webapi/role_api.php?action=add", 
			{
				ROLE_NAME:$("#ROLE_NAME").val(),
				ROLE_MENU_ID:ROLE_MENU_ID,
				DEP_ID:$('#DEP_ID').combotree('getValue'),
				COMMENT:$("#COMMENT").val(),
				ENABLED:$("#ENABLED").val()
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
		title:'角色管理',		
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
	g_day_id = rows[0].ROLE_ID;
	show_window();
	$('#ROLE_ID').val(rows[0].ROLE_ID);
	$('#ROLE_NAME').val(rows[0].ROLE_NAME);
	$('#DEP_ID').combotree('setValue',rows[0].DEP_ID);
	$('#ROLE_MENU_ID').combotree('setValues',rows[0].ROLE_MENU_ID);

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
		listMatId = listMatId + rows[n].ROLE_ID + ";";
	}
	$.messager.confirm("操作提示", "是否删除选中的项目？", function (data) {
		if (data) {
			$.post("../webapi/role_api.php?action=delete", {
				del_list : listMatId
			}, function (data) {
				$("#dataGrid").datagrid('reload');
			});
		}
	});
}
$(document).ready(function(){
	
	$("#dataGrid").datagrid({   
		title:"角色管理",
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
	    url:'../webapi/role_api.php?action=query',  
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
	        {field:'ROLE_NAME',title:'角色名称'},    
	        {field:'ROLE_MENU_ID',title:'角色权限列表',width:100},    
	        {field:'DEP_NAME',title:'角色所属部门'},  
	        {field:'CREATE_TIME',title:'建立时间'},    
	        {field:'CUSER',title:'建立人'},    
	        {field:'UPDATE_TIME',title:'更新时间'},  
	        {field:'UUSER',title:'更新人'},     
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
	$('#ROLE_MENU_ID').combotree({ 
		cascadeCheck:false,
		multiple:true,  
		checkbox:true,
	    url: '../webapi/menu_api.php?action=loadtree',
	    onCheck:function (node, checked){
	    	// var nodes = $('#ROLE_MENU_ID').tree('getChecked');	
	    	// var temp;
	    	// // for (var i = nodes.length - 1; i >= 0; i--) {
	    	// // 	temp+=nodes[i].text;
	    	// // };
	    	// alert(nodes.length);
	    	// alert($('#ROLE_MENU_ID').combotree('getParent'),node.target);
	    	var t = $('#ROLE_MENU_ID').combotree('tree');	// get the tree object
			// var n = t.tree('getChecked');		// get selected node
			// alert(n.length);
					if (checked) {
                        var parentNode = t.tree('getParent', node.target);
                        if (parentNode != null) {
                            t.tree('check', parentNode.target);
                        }
                    } else {
                        var childNode = t.tree('getChildren', node.target);
                        if (childNode.length > 0) {
                            for (var i = 0; i < childNode.length; i++) {
                                t.tree('uncheck', childNode[i].target);
                            }
                        }
                    }


	    }
	});
	$('#DEP_ID').combotree({ 
		cascadeCheck:false,
		// multiple:true,  
		// checkbox:true,
	    url: '../webapi/department_api.php?action=loadtree',
	    onClick:function(node){

	    }
	});
});

