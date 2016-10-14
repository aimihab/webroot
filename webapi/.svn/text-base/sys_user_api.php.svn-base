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

		$order_string=" ORDER by a.USER_ID desc";
		
		if ($_POST["page"]!=null&&$_POST["page"]>1){
			$page=$_POST['page']-1;
		}
		if ($_POST["rows"]!=null){
			$pageSize=$_POST['rows'];
		}	
//		if ($_POST["DEP_ID"]!=null){
//			$where=$where." and (a2.DEP_ID=".$_POST['DEP_ID']." or a2.PARENT_DEP_ID=".$_POST['DEP_ID'].")";
//		}	
		$result=$db->queryByPage("a.*,a1.ROLE_NAME,a2.DEP_NAME,a2.DEP_ID",
			"SYS_USER a left join SYS_ROLE a1 on a.ROLE_ID=a1.ROLE_ID
			left join SYS_DEPARTMENT a2 on a1.DEP_ID=a2.DEP_ID",$where,$page,$pageSize,$order_string);
		$allData=$db->fetchAll();

		$arr=array();
		$arr["total"]=(int)$db->getTotal();
		$arr["rows"]=$allData;
		$arr["pageSize"]=$pageSize;
		echo json_encode($arr);
		$db->close();
	}

	function add_action()
	{
		$db = new mysql_ht_db(1);
		$arr = array();

		$arr["USERNAME"] = $_POST['USERNAME'];
		
		$arr["USER_LOGIN_ID"] = $_POST['USER_LOGIN_ID'];
		// $arr["USERNAME"] = $_POST['USERNAME'];
		$arr["EMAIL"] = $_POST['EMAIL'];
		$arr["PHONE"] = $_POST['PHONE'];
		$arr["ROLE_ID"] = $_POST['ROLE_ID'];
		$arr["COMMENT"] = $_POST['COMMENT'];
		$arr["FLAG"] = $_POST['FLAG'];
		$arr["CREATE_TIME"] = date( "Y-m-d H:i:s" );
		
		$db->executeInsert( "SYS_USER", $arr );
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
				$db->execute("delete from SYS_USER where USER_ID=".$v );
			}
		}
		$db->close();
	}

	function edit_action()
	{	
		$db = new mysql_ht_db(1);
		$arr = array();

		$arr["USERNAME"] = $_POST['USERNAME'];
		
		$arr["USER_LOGIN_ID"] = $_POST['USER_LOGIN_ID'];
		// $arr["USERNAME"] = $_POST['USERNAME'];
		$arr["EMAIL"] = $_POST['EMAIL'];
		$arr["PHONE"] = $_POST['PHONE'];
		$arr["ROLE_ID"] = $_POST['ROLE_ID'];
		$arr["COMMENT"] = $_POST['COMMENT'];
		$arr["FLAG"] = $_POST['FLAG'];
		$db->executeUpdate( "SYS_USER", $arr, "where USER_ID=".$_POST['USER_ID'] );
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

	if ( $_GET['action'] != null && $_GET['action'] == "query" )
	{
		query_action();
	}
	//修改员工信息
	if ( $_GET['action'] != null && $_GET['action'] == "edit" )
	{
		edit_action();
	}
	//新增员工
	if ( $_GET['action'] != null && $_GET['action'] == "add" )
	{
		add_action();
	}
	//删除员工
	if ( $_GET['action'] != null && $_GET['action'] == "delete" )
	{
		delete_action();
	}

?>
