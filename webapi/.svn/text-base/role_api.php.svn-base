<?php include '../include/comm.php'?>
<?php include '../include/DebugLog.php'?>
<?php
	function query_action()
	{
		session_start();
		$db=new mysql_ht_db(1);
		$where="1=1 ";
		$page=0;
		$pageSize=10;

		$order_string=" ORDER by a.ROLE_ID desc";
		
		if ($_POST["page"]!=null&&$_POST["page"]>1){
			$page=$_POST['page']-1;
		}
		if ($_POST["rows"]!=null){
			$pageSize=$_POST['rows'];
		}	
//		if ($_POST["DEP_ID"]!=null){
//			$where=$where." and (a3.DEP_ID=".$_POST['DEP_ID']." or a3.PARENT_DEP_ID=".$_POST['DEP_ID'].")";
//		}	
		$result=$db->queryByPage("a.*,a1.USERNAME as CUSER,a2.USERNAME as UUSER,a3.DEP_NAME",
			"SYS_ROLE a left join SYS_USER a1 on a.CREATE_USERNAME=a1.USER_ID
			left join SYS_USER a2 on a.UPDATE_USERNAME=a2.USER_ID
			left join SYS_DEPARTMENT a3 on a.DEP_ID=a3.DEP_ID",$where,$page,$pageSize,$order_string);
		$allData=$db->fetchAll();

		$arr=array();
		$arr["total"]=(int)$db->getTotal();
		$arr["rows"]=$allData;
		$arr["pageSize"]=$pageSize;
		echo json_encode($arr);
		$db->close();
	}
	function querycombox_action(){
		$db=new mysql_ht_db(1);
		$where="where 1=1 ";
//		if ($_GET["COMBOXID"]!=null){
//			$where=$where."and a.DEP_ID in ("."select b.DEP_ID from SYS_DEPARTMENT b where b.DEP_ID=".$_GET['COMBOXID']." or b.PARENT_DEP_ID =".$_GET['COMBOXID'].")";
//		}
//		msg_debug("post=".$_POST["COMBOXID"].",get:".$_GET["COMBOXID"]);	
		msg_debug($where);
		$result=$db->query("select a.ROLE_ID as id,a.ROLE_NAME as text from SYS_ROLE a ".$where);
		$allData=$db->fetchAll();

		echo json_encode($allData);
		$db->close();		
	}
	function add_action()
	{
		// $sql = "select * from sys_department where DEP_NAME='".$_POST['DEP_NAME']."' and PARENT_DEP_ID='".$_POST['PARENT_DEP_ID']."'";
		// if(queryIsExitLoginID($sql)){
		// 	$arr=array();
		// 	$arr["flag"]="1001";
		// 	echo json_encode($arr);
		// }else{
			$db = new mysql_ht_db(1);
			$arr = array();
			// if($_POST['PARENT_DEP_ID']!=null){
			// 	$arr["PARENT_DEP_ID"] = $_POST['PARENT_DEP_ID'];
			// }else{
		 //   		$arr["PARENT_DEP_ID"]=0;		   		
		 //    }
			session_start();
			$arr["CREATE_USERNAME"] = $_SESSION['ART_ID'];
			$arr["CREATE_TIME"] = date( "Y-m-d H:i:s" );
			$arr["ROLE_NAME"] = $_POST['ROLE_NAME'];
			$arr["ROLE_MENU_ID"] = arrayToString();
			$arr["DEP_ID"] = $_POST['DEP_ID'];
			$arr["COMMENT"] = $_POST['COMMENT'];
			$arr["ENABLED"] = $_POST['ENABLED'];
			$db->executeInsert( "SYS_ROLE", $arr );
			$db->close();
			$arr=array();
			$arr["flag"]="1000";
			echo json_encode($arr);
		// }
		
	}

	function delete_action()
	{
		
		$db = new mysql_ht_db(1);
		
		$files = split ( ';', $_POST['del_list'] );
		foreach( $files as $k => $v ) {
			if ( strlen( $v ) > 0 ) {
				$db->execute("delete from SYS_ROLE where ROLE_ID=".$v );
			}
		}
		$db->close();
	}
	function arrayToString(){
		$temp="";
		foreach ($_POST['ROLE_MENU_ID'] as $s)
		{
		    $temp=$temp.$s.",";
		}
		$temp = substr($temp,0,strlen($temp)-1); 
		return $temp;
	}
	function edit_action()
	{	
		$db = new mysql_ht_db(1);
		$arr = array();
		session_start();
		$arr["UPDATE_USERNAME"] = $_SESSION['ART_ID'];
		$arr["UPDATE_TIME"] = date( "Y-m-d H:i:s" );
		$arr["ROLE_NAME"] = $_POST['ROLE_NAME'];
		$arr["ROLE_MENU_ID"] = arrayToString();
		$arr["DEP_ID"] = $_POST['DEP_ID'];
		$arr["COMMENT"] = $_POST['COMMENT'];
		$arr["ENABLED"] = $_POST['ENABLED'];
		$db->executeUpdate( "SYS_ROLE", $arr, "where ROLE_ID=".$_POST['ROLE_ID'] );
		$db->close();

		$arr["flag"]="1000";
		echo json_encode($arr);
	}

	function queryIsExitLoginID($sql){
		$db=new mysql_ht_db(1);
		$result=$db->query($sql);
		$db->close();
		if($result){
			return true;
		}else{
			return false;
		}
	}
	msg_debug("------------begin-----------------".$_GET['action']);
	//查询部门列表
	if ( $_GET['action'] != null && $_GET['action'] == "query" )
	{
		query_action();
	}
	//修改部门信息
	if ( $_GET['action'] != null && $_GET['action'] == "edit" )
	{
		edit_action();
	}
	//新增部门
	if ( $_GET['action'] != null && $_GET['action'] == "add" )
	{
		add_action();
	}
	//删除部门
	if ( $_GET['action'] != null && $_GET['action'] == "delete" )
	{
		delete_action();
	}
	//查询角色下拉框
	if ( $_GET['action'] != null && $_GET['action'] == "querycombox" )
	{
		querycombox_action();
	}
?>
