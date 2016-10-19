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

		$order_string=" ORDER by a.DEVICE_ID desc";
		
		if ($_POST["page"]!=null&&$_POST["page"]>1){
			$page=$_POST['page']-1;
		}
		if ($_POST["rows"]!=null){
			$pageSize=$_POST['rows'];
		}
		
		$result=$db->queryByPage("a.*,a1.SCHOOL_NAME",
		"ART_DEVICE_LIST a left join ART_SCHOOL a1 on a.SCHOOL_ID=a1.SCHOOL_ID",$where,$page,$pageSize,$order_string);
		$allData=$db->fetchAll();

		$arr=array();
		$arr["total"]=(int)$db->getTotal();
		$arr["rows"]=$allData;
		$arr["pageSize"]=$pageSize;
		msg_debug(json_encode($arr));
		echo json_encode($arr);
	//	console_log($arr);
		echo("console.log(".json_encode($arr).");");
		$db->close();
	}
	/*
	function loadTree_action()
	{
		$db=new mysql_ht_db(1);
		$result=$db->query("select a.DEVICE_ID as id,a.PARENT_DEP_ID as fid,
			a.DEP_NAME as text from SYS_DEPARTMENT a ");
		$allData=$db->fetchAll();
//		msg_debug("before department loadtree = ".json_encode($allData));
		$bta=new BuildTreeArray($allData,'id','fid',0);
		$data=$bta->getTreeArray();
		echo json_encode($data);
		msg_debug("department loadtree = ".json_encode($data));
		$db->close();
	}
	*/

	function add_action()
	{
		
			$db = new mysql_ht_db(1);
			$arr = array();
			$arr["STAUTS"] = $_POST['STAUTS'];
		//	$arr["CREATE_TIME"] = date( "Y-m-d H:i:s" );
			$arr["SCHOOL_ID"] = $_POST['SCHOOL_ID'];
			$arr["STUDENT_NAME"] = $_POST['STUDENT_NAME'];
			$arr["STUDENT_PHONE"] = $_POST['STUDENT_PHONE'];
			$arr["STUDENT_EMAIL"] = $_POST['STUDENT_EMAIL'];
			$arr["ENTRY_YEAR"] = $_POST['ENTRY_YEAR'];
			$arr["EMERGENCY_CONTACT"] = $_POST['EMERGENCY_CONTACT'];
			$arr["EMERGENCY_PHONE"] = $_POST['EMERGENCY_PHONE'];
			$arr["COMMENTS"] = $_POST['COMMENTS'];
			
			$db->executeInsert( "ART_DEVICE_LIST", $arr );
			$db->close();
			$arr=array();
			$arr["flag"]="1000";
			echo json_encode($arr);
		
	}

	function delete_action()
	{
		
		$db = new mysql_ht_db(1);
		
		$files = split ( ';', $_POST['del_list'] );
		foreach( $files as $k => $v ) {
			if ( strlen( $v ) > 0 ) {
				$db->execute("delete from ART_DEVICE_LIST where DEVICE_ID=".$v );
			}
		}
		$db->close();
	}

	function edit_action()
	{	
		
		if(queryIsExitLoginID($sql)){
			$arr=array();
			$arr["flag"]="1001";
			echo json_encode($arr);
		}else{
			$db = new mysql_ht_db(1);
			$arr = array();

			$arr["STAUTS"] = $_POST['STAUTS'];
		//	$arr["CREATE_TIME"] = date( "Y-m-d H:i:s" );
			$arr["SCHOOL_ID"] = $_POST['SCHOOL_ID'];
			$arr["STUDENT_NAME"] = $_POST['STUDENT_NAME'];
			$arr["STUDENT_PHONE"] = $_POST['STUDENT_PHONE'];
			$arr["STUDENT_EMAIL"] = $_POST['STUDENT_EMAIL'];
			$arr["ENTRY_YEAR"] = $_POST['ENTRY_YEAR'];
			$arr["EMERGENCY_CONTACT"] = $_POST['EMERGENCY_CONTACT'];
			$arr["EMERGENCY_PHONE"] = $_POST['EMERGENCY_PHONE'];
			$arr["COMMENTS"] = $_POST['COMMENTS'];
			
			$db->executeUpdate( "ART_DEVICE_LIST", $arr, "where DEVICE_ID=".$_POST['DEVICE_ID'] );
			$db->close();

			$arr["flag"]="1000";
			echo json_encode($arr);
		}
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
	msg_debug("-------department_api-----begin-----------------".$_GET['action']);
	//加载设备树
//	if ( $_GET['action'] != null && $_GET['action'] == "loadtree" )
//	{
//	}

	//查询设备列表
	if ( $_GET['action'] != null && $_GET['action'] == "query" )
	{
		query_action();
	}
	//修改设备信息
	if ( $_GET['action'] != null && $_GET['action'] == "edit" )
	{
		edit_action();
	}
	//新增设备
	if ( $_GET['action'] != null && $_GET['action'] == "add" )
	{
		add_action();
	}
	//删除设备
	if ( $_GET['action'] != null && $_GET['action'] == "delete" )
	{
		delete_action();
	}
	
	function console_log($data) {
    if (is_array($data) || is_object($data)) {
        echo("<script>console.log('".json_encode($data)."');</script>");
    } else {
        echo("<script>console.log('".$data."');</script>");
    }
}
	
	
	
	

?>
