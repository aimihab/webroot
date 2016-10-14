$(document).ready(function () 
{
	var g_dev_id = -1;
//	var g_rows_obj;
	var g_type_name;

	$('#search').click(function(event) {
		var uuid = g_dev_id;
		var type = $('#type');
		var start = $('#start').datebox('getValue');
		var end = $('#end').datebox('getValue');
	
		var url = '../../api/getchhistdata';
		if($.trim(uuid).length <= 0 ){
			alert('设备号不能为空');
			return;
		}else{
			url = url + '?uuid=' + uuid;
		}
		if(type.val().length <= 0){
			alert('数据类型不能为空');
			return;
		}else{
			url = url + '&type=' + type.val();
		}
		
		url = url + '&begin=' + start + '&end=' + end;
//		alert('url=' + url);
		g_type_name = type.val()=='el'?'电位':(type.val()=='ac'?'交流电压':'恒电位仪');

		if (type.val() == 'el') {
			g_type_name = '电位';
			show_el_chart(url);
		} else if (type.val() == 'ac') {
			g_type_name = '交流电压';
			show_ac_chart(url);
		} else {
			g_type_name = '恒电位仪';
			show_pt_chart(url);
		}
	});
	
	function show_el_chart(url)
	{
		var myChart = echarts.init(document.getElementById('histCurve'));
		myChart.showLoading();
		$.post(url,"json").done(function (data) {
			myChart.hideLoading();
			var _ID=new Array();
			var _MAX = new Array(),_MIN = new Array(),_TIME = new Array();
//			var _temp1 = new Array(),_temp2 = new Array();
			var dataObj = eval("("+data+")");
			$.each(dataObj.data, function(i,value){
				_ID[i] = this.ID;
				_MAX[i] = this.MAX;
				_MIN[i] = this.MIN;
				_TIME[i] = this.TIME;
//				_temp1[i] = 0.85;
//				_temp2[i] = 1.25;
			});
			myChart.setOption({
				title: {
			        text: g_type_name
			    },
			    tooltip : {
			        trigger: 'axis'
			    },
			    legend: {
			        data:['最大值','最小值']
			    },
			    toolbox: {
			        feature: {
			            saveAsImage: {}
			        }
			    },
			    grid: {
			        left: '3%',
			        right: '4%',
			        bottom: '50px',
			        containLabel: true
			    },
			    xAxis : [
			        {
			            type : 'category',
			            boundaryGap : false,
			            data : _TIME
			        }
			    ],
			    yAxis : [
			        {
			            type : 'value'
			        }
			    ],
			    dataZoom: [
		            {
		                type: 'slider',
		                show: true,
		                start: 0,
		                end: 100,
		                handleSize: 10
		            }
	        	],
			    series : [
			        {
			            name:'最大值',
			            type:'line',
			            label: {
			                normal: {
			                    show: true,
			                    position: 'top'
			                }
			            },
			            areaStyle: {normal: {color:'transparent'}},
			            data:_MAX
			        },
			        {
			            name:'最小值',
			            type:'line',
			            label: {
			                normal: {
			                    show: true,
			                    position: 'top'
			                }
			            },
			            areaStyle: {normal: {color:'transparent'}},
			            data:_MIN
			        },
/*			        {
			            name:'欠保护',
			            type:'line',
			            label: {
			                normal: {
			                    show: true,
			                    position: 'top',
			                    type:'dashed'
			                }
			            },
			            areaStyle: {normal: {color:'transparent'}},
			            data:_temp1
			        },
			        {
			            name:'过保护',
			            type:'line',
			            label: {
			                normal: {
			                    show: true,
			                    position: 'top',
			                    type:'dashed'
			                }
			            },
			            areaStyle: {normal: {color:'transparent'}},
			            data:_temp2
			        }
*/
			    ]
			});
		});			
	}
	
	function show_ac_chart(url)
	{
		var myChart = echarts.init(document.getElementById('histCurve'));
		myChart.showLoading();
		$.post(url,"json").done(function (data) {
			myChart.hideLoading();
			var _ID=new Array();
			var _MAX = new Array(),_MIN = new Array(), _AVG = new Array(), _TIME = new Array();
			var dataObj = eval("("+data+")");
			$.each(dataObj.data, function(i,value){
				_ID[i] = this.ID;
				_MAX[i] = this.MAX;
				_MIN[i] = this.MIN;
				_AVG[i] = this.AVG;
				_TIME[i] = this.TIME;
			});
			myChart.setOption({
				title: {
			        text: g_type_name
			    },
			    tooltip : {
			        trigger: 'axis'
			    },
			    legend: {
			        data:['最大值','最小值','平均值']
			    },
			    toolbox: {
			        feature: {
			            saveAsImage: {}
			        }
			    },
			    grid: {
			        left: '3%',
			        right: '4%',
			        bottom: '50px',
			        containLabel: true
			    },
			    xAxis : [
			        {
			            type : 'category',
			            boundaryGap : false,
			            data : _TIME
			        }
			    ],
			    yAxis : [
			        {
			            type : 'value'
			        }
			    ],
			    dataZoom: [
		            {
		                type: 'slider',
		                show: true,
		                start: 0,
		                end: 100,
		                handleSize: 10
		            }
	        	],
			    series : [
			        {
			            name:'最大值',
			            type:'line',
			            label: {
			                normal: {
			                    show: true,
			                    position: 'top'
			                }
			            },
			            areaStyle: {normal: {color:'transparent'}},
			            data:_MAX
			        },
			        {
			            name:'最小值',
			            type:'line',
			            label: {
			                normal: {
			                    show: true,
			                    position: 'top'
			                }
			            },
			            areaStyle: {normal: {color:'transparent'}},
			            data:_MIN
			        },
			        {
			            name:'平均值',
			            type:'line',
			            label: {
			                normal: {
			                    show: true,
			                    position: 'top',
			                    type:'dashed'
			                }
			            },
			            areaStyle: {normal: {color:'transparent'}},
			            data:_AVG
			        }
			    ]
			});
		});			
	}
	
	function show_pt_chart(url)
	{
		var myChart = echarts.init(document.getElementById('histCurve'));
		myChart.showLoading();
		$.post(url,"json").done(function (data) {
			myChart.hideLoading();
			var _ID=new Array();
			var _PT = new Array(), _TIME = new Array();
			var dataObj = eval("("+data+")");
			$.each(dataObj.data, function(i,value){
				_ID[i] = this.ID;
				_PT[i] = this.PT;
				_TIME[i] = this.TIME;
			});
			myChart.setOption({
				title: {
			        text: g_type_name
			    },
			    tooltip : {
			        trigger: 'axis'
			    },
			    legend: {
			        data:['恒电']
			    },
			    toolbox: {
			        feature: {
			            saveAsImage: {}
			        }
			    },
			    grid: {
			        left: '3%',
			        right: '4%',
			        bottom: '50px',
			        containLabel: true
			    },
			    xAxis : [
			        {
			            type : 'category',
			            boundaryGap : false,
			            data : _TIME
			        }
			    ],
			    yAxis : [
			        {
			            type : 'value'
			        }
			    ],
			    dataZoom: [
		            {
		                type: 'slider',
		                show: true,
		                start: 0,
		                end: 100,
		                handleSize: 10
		            }
	        	],
			    series : [
			        {
			            name:'恒电值',
			            type:'line',
			            label: {
			                normal: {
			                    show: true,
			                    position: 'top'
			                }
			            },
			            areaStyle: {normal: {color:'transparent'}},
			            data:_PT
			        },
			    ]
			});
		});			
	}

	function show_operate_action_window()
	{
		var rows = $('#_dataGrid').datagrid('getSelected');
		if (rows) {
			g_dev_id = rows.DEV_ID;
//			g_rows_obj = rows;
			$('#optAction').dialog('open').dialog({
				title: TEST,
				width: 350,
				height: 250,
				modal: true
			});
		} else {
			alert("请选中一行进行操作!");
		}
	}

	$('#sendCmd').click(function(){
		var upTimeStr = '';
		for (var i = 1; i <= fieldCount; i++) {
			var subUpTimeStr = $('#upTime_' + i).val();
			if (subUpTimeStr.indexOf("Input") > -1) {
				alert("请输入正确的时间格式!");
				return ;
			}
			var dh = (i != fieldCount ? ',' : '');
			upTimeStr += '{"time":"' + subUpTimeStr + '"}' + dh;
		}
		var onOffTimeStr = '"onoff":{"startup":"' + $('#startupTime').val() + '","shutdown":"' + $('#shutdownTime').val() + '"}';
		var jsonStr = '{"uploadtime":[' + upTimeStr + '],' + onOffTimeStr + '}';

//		alert(jsonStr);
		$.ajax({
			type: "POST",
			url:  '../../api/setchparams',
			async: false,
			data: 'uuid=' + g_dev_id + '&setup=' + jsonStr,
			success: function () {
				$.messager.alert("Send success.");
			}
		})
	})
	
	function show_hist_action_window()
	{
		var rows = $('#_dataGrid').datagrid('getSelected');
		if (rows) {
			g_dev_id = rows.DEV_ID;
			document.getElementById('uuid').innerText = g_dev_id;
		
			var curDate = new Date();
			
			$('#start').datebox('setValue', curDate.getFullYear()+'-'+(curDate.getMonth()+1)+'-'+curDate.getDate());
			$('#end').datebox('setValue', curDate.getFullYear()+'-'+(curDate.getMonth()+1)+'-'+curDate.getDate());
//			$("#uuid").val(g_dev_id);
//			g_rows_obj = rows;
			$('#histAction').dialog('open').dialog({
				title: TEST,
				width: 350,
				height: 250,
				modal: true
			});
		} else {
			alert("请选中一行进行操作!");
		}
	}

	function show_operate_dialog()
	{
		g_dev_id = -1;
//		g_rows_obj = 0;
		show_operate_action_window();
	}
	
	function show_hist_dialog()
	{
		g_dev_id = -1;
		show_hist_action_window();
	}

	// show data
	$("#_dataGrid").datagrid({
		title:"设备列表",
		rownumbers : false,
		nowrap : true,
		pagination : true,
		fit:true,
		border : false,
		nowrap : true,
		striped : true,

		border : false,
		singleSelect : false,
		selectOnCheck : true,
		checkOnSelect : true,
		sortOrder : 'desc',
		remoteSort : true,

		url:'../../api/getdeviceinfo.php',  
		toolbar : ["-", {
			text : '设置参数',
			iconCls : 'icon-add',
				handler : function () {
					show_operate_dialog();
				}
			},
			{
			text : '历史记录',
			iconCls : 'icon-add',
				handler : function () {
					show_hist_dialog();
				}
			}
		],

		columns:[[ 
	    	{field :'ck', checkbox : true},
			{field:'ID', title:'id', align:'left'},
			{field:'DEV_ID', title:'设备号', align:'center'},
			{field:'LOCATION_NUMBER', title:'位置编号'},
			{
				field:'DEV_STATUS', title:'设备状态',
				formatter: function(value,row,index){
					if (value==0){
						return '正常';
					} else if(value==1){
						return '报警';
					}
				},
				styler: function(value,row,index){
					if (value == 0){
						return 'color:green;';		
					} else if (value==1) {
						return 'color:red;';
					}
				},
				align:'center'
			},
			{
				field:'RUNNING_STATUS', title:'运行状态',
				formatter: function(value,row,index){
					if (value==0){
						return '正常';
					} else if(value==1){
						return '报警';
					}
				},
				styler: function(value,row,index){
					if (value == 0){
						return 'color:green;';		
					} else if (value==1) {
						return 'color:red;';
					}
				},
				align:'center'
			},
			{field:'ELEC_POT', title:'电位'},
			{field:'ALTE_VOL', title:'交流电压'},
			{field:'POTENT', title:'恒电位仪'},
			{field:'RECV_TIME', title:'接收时间'},
			{field:'UPLOAD_TIME', title:'上传时间'},
			{field:'LOCATION_DETAIL', title:'具体位置'}
			]]
	});

	var maxInputs       = 3;
	var inputsWrapper   = $("#inputsWrapper");
	var addButton       = $("#AddMoreInput");
	var inputIdx = inputsWrapper.length;
	var fieldCount=1;
	$(addButton).click(function (e) {  
		if(inputIdx <= maxInputs) {
			fieldCount++; //text box added increment
			//var tmpstr = 'onchange="javascript:if(!/^[0-5]{1}[0-9]{1}:[0-5]{1}[0-5]{1}$/.test(this.value)){alert("Input valid format like 00:00");this.value=''};"';
			$(inputsWrapper).append('<div><input type="text" name="mytext[]" id="upTime_'+ fieldCount +'" value="Input time '+ fieldCount +'"/><a href="#" class="removeclass" style="color: #FF0000">&nbsp;x</a></div>');  
			inputIdx++; //text box increment  
		}
		return false;  
	});
  
	$("body").on("click",".removeclass", function(e){
		if( inputIdx > 1 ) {  
			$(this).parent('div').remove();
			inputIdx--;
		}
		return false;  
	});
});
