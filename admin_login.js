$(document).ready(function () {
	var agent = navigator.userAgent.toLowerCase();
		if(agent.indexOf("chrome")>=0){
			$("#form-login").attr("autocomplete", "off");
		}


	$("#btn-login").click(function(){
		if ($("#username").val()=="") {alert("帐号不能为空");return;};
		if ($("#password").val()=="") {alert("密码不能为空");return;};

		$('#form-login').form('submit', {
			url: "webapi/admin_login_api.php?action=login",
			onSubmit: function(){

			},
			success: function(data){
				try {
					var dataobj = eval("("+data+")");
				} catch(exception) {
					alert(exception+ ' > ' + data);
				}

				if (dataobj.flag == "1000"){
					window.location.href='admin_main.php';
				} else if(dataobj.flag == "1001"){
					alert("帐号或密码错误！");
				} else if(dataobj.flag == "1002"){
			//		 alert("帐号未授权，请联系管理员！");
					window.location.href='admin_main.php';
				}
			},
			error: function(){
				alert("error");
			}
		});


	});

});
