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
		$result=$db->queryByPage("a.*,a1.SCHOOL_NAME",
			"ART_SCHOOL_USER a left join ART_SCHOOL a1 on a.SCHOOL_ID=a1.SCHOOL_ID",$where,$page,$pageSize,$order_string);
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

		// session_start();
		//	$arr["CREATE_USERNAME"] = $_SESSION['ART_ID'];
		$arr["NAME"] = $_POST['NAME'];
		$arr["USERNAME"] = $_POST['USERNAME'];
		$arr["SCHOOL_ID"] = $_POST['SCHOOL_ID'];
		$arr["PHONE"] = $_POST['PHONE'];
		$arr["EMAIL"] = $_POST['EMAIL'];
		$arr["COMMENTS"] = $_POST['COMMENTS'];
		$arr["STATUS"] = $_POST['STATUS'];
		$arr["CREATE_TIME"] = date( "Y-m-d H:i:s" );
		
		$db->executeInsert( "ART_SCHOOL_USER", $arr );
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
				$db->execute("delete from ART_SCHOOL_USER where USER_ID=".$v );
			}
		}
		$db->close();
	}

	function edit_action()
	{	
		$db = new mysql_ht_db(1);
		$arr = array();

		//session_start();
		//$arr["UPDATE_USERNAME"] = $_SESSION['ART_ID'];
		
		$arr["NAME"] = $_POST['NAME'];
		$arr["USERNAME"] = $_POST['USERNAME'];
		$arr["SCHOOL_ID"] = $_POST['SCHOOL_ID'];
		$arr["PHONE"] = $_POST['PHONE'];
		$arr["EMAIL"] = $_POST['EMAIL'];
		$arr["COMMENTS"] = $_POST['COMMENTS'];
		$arr["STATUS"] = $_POST['STATUS'];
		$db->executeUpdate( "ART_SCHOOL_USER", $arr, "where USER_ID=".$_POST['USER_ID'] );
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

	//查询所有学校管理员信息
	if ( $_GET['action'] != null && $_GET['action'] == "query" )
	{
		query_action();
	}
	//修改管理员信息
	if ( $_GET['action'] != null && $_GET['action'] == "edit" )
	{
		edit_action();
	}
	//新增管理员
	if ( $_GET['action'] != null && $_GET['action'] == "add" )
	{
		add_action();
	}
	//删除管理员
	if ( $_GET['action'] != null && $_GET['action'] == "delete" )
	{
		delete_action();
	}

?>
