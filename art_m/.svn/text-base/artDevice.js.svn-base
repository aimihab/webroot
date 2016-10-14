function save_data() {
	/*
	if ($('#MAC').val().length <= 0) {
		alert("设备标识不能为空!");
		return;
	}
	*/
	if (g_day_id != -1) {	
		
		$.post("../webapi/artDevice_api.php?action=edit",
			{
				
				DEVICE_ID:$("#DEVICE_ID").val(),
				MAC:$("#MAC").val(),
				STAUTS:$("#STAUTS").val(),
				SCHOOL_ID:$('#SCHOOL_ID').combotree('getValue'),
				STUDENT_NAME:$("#STUDENT_NAME").val(),
				STUDENT_PHONE:$("#STUDENT_PHONE").val(),
				STUDENT_EMAIL:$("#STUDENT_EMAIL").val(),
				ENTRY_YEAR:$("#ENTRY_YEAR").val(),
				EMERGENCY_CONTACT:$("#EMERGENCY_CONTACT").val(),
				EMERGENCY_PHONE:$("#EMERGENCY_PHONE").val(),
				COMMENTS:$("#COMMENTS").val()
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
				alert("保存数据失败，MAC地址重复！");
			}
		});
	} else {
		
		$.post("../webapi/artDevice_api.php?action=add", 
			{
				MAC:$("#MAC").val(),
				STAUTS:$("#STAUTS").val(),
				SCHOOL_ID:$('#SCHOOL_ID').combotree('getValue'),
				STUDENT_NAME:$("#STUDENT_NAME").val(),
				STUDENT_PHONE:$("#STUDENT_PHONE").val(),
				STUDENT_EMAIL:$("#STUDENT_EMAIL").val(),
				ENTRY_YEAR:$("#ENTRY_YEAR").val(),
				EMERGENCY_CONTACT:$("#EMERGENCY_CONTACT").val(),
				EMERGENCY_PHONE:$("#EMERGENCY_PHONE").val(),
				COMMENTS:$("#COMMENTS").val()
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
				alert("保存数据失败，MAC地址重复！");
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
		title:'设备管理',		
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
	g_day_id = rows[0].DEVICE_ID;
	show_window();
	$('#DEVICE_ID').val(rows[0].DEVICE_ID);
	$('#REGISTER_CODE').val(rows[0].REGISTER_CODE);
	$('#STUDENT_NAME').val(rows[0].STUDENT_NAME);
	$('#STUDENT_PHONE').val(rows[0].STUDENT_PHONE);
	$('#STUDENT_EMAIL').val(rows[0].STUDENT_EMAIL);
	$('#SCHOOL_ID').combotree('setValue',rows[0].SCHOOL_ID);
	$('#EMERGENCY_CONTACT').val(rows[0].EMERGENCY_CONTACT);
	$('#EMERGENCY_PHONE').val(rows[0].EMERGENCY_PHONE);
	$('#COMMENTS').val(rows[0].COMMENTS);	
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
		listMatId = listMatId + rows[n].DEVICE_ID + ";";
	}
	$.messager.confirm("操作提示", "是否删除选中的项目？", function (data) {
		if (data) {
			$.post("../webapi/artDevice_api.php?action=delete", {
				del_list : listMatId
			}, function (data) {
				$("#dataGrid").datagrid('reload');
			});
		}
	});
}
$(document).ready(function(){
	
	$("#dataGrid").datagrid({   
		title:"设备管理",
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
	    url:'../webapi/artDevice_api.php?action=query',  
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
	        {field:'MAC',title:'设备唯一标识'},    
	        {field:'REGISTER_CODE',title:'注册码'},    
	        {field:'REGISTER_TIME',title:'注册时间'},  
	        {field:'CREATE_TIME',title:'首次登录时间'},    
	        {field:'STAUTS',title:'设备状态'},    
	        {field:'SCHOOL_NAME',title:'设备所属学校'},  
	        {field:'STUDENT_NAME',title:'关联学生姓名'}, 
			{field:'STUDENT_PHONE',title:'关联学生电话'}, 
			{field:'STUDENT_EMAIL',title:'关联学生邮箱'},
			{field:'COLLEGE_ID',title:'所在院系'},
			{field:'CLASS_NAME',title:'所在班级'},
			{field:'ENTRY_YEAR',title:'入学年份'},
			{field:'EMERGENCY_CONTACT',title:'紧急联系人'},
			{field:'EMERGENCY_PHONE',title:'紧急联系人电话'},             
	        {field:'COMMENTS',title:'备注'},    
	        
	    ]]    
	});  
	$("#p").panel({
		title:"学校机构",
		fit:true
	});

	$('#tt').tree({   
		// checkbox:true,
	    url:'../webapi/artSchool_api.php?action=loadtree',
	    onClick: function(node){
	    	$("#dataGrid").datagrid({
	    		queryParams: {
					SCHOOL_ID : node.id
				}
	    	});
		}     
	});
	
	$('#cc').combo({
    	required:true,
    	multiple:false,
		url:'combobox_data.json',
		valueField:'id',
		textField:'text'
	});
	
	$('#SCHOOL_ID').combotree({ 
		//cascadeCheck:false,
	    url: '../webapi/artSchool_api.php?action=loadtree',
	  //  onClick:function(node){
			
	  //  }
	});
	
	
	/*
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
	*/
	
});

