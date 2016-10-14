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

		$order_string=" ORDER by a.FILE_ID desc";
		
		if ($_POST["page"]!=null&&$_POST["page"]>1){
			$page=$_POST['page']-1;
		}
		if ($_POST["rows"]!=null){
			$pageSize=$_POST['rows'];
		}	
//		if ($_POST["DEP_ID"]!=null){
//			$where=$where." and (a3.DEP_ID=".$_POST['DEP_ID']." or a3.PARENT_DEP_ID=".$_POST['DEP_ID'].")";
//		}	
		$result=$db->queryByPage("a.*,a1.SCHOOL_NAME as SNAME,a2.COLUMN_NAME",
			"ART_UPLOAD_FILES a left join ART_SCHOOL a1 on a.SCHOOL_ID=a1.SCHOOL_ID
			left join ART_MENU a2 on a.COLUMN_ID=a2.COLUMN_ID",$where,$page,$pageSize,$order_string);
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
		$result=$db->query("select a.FILE_ID as id,a.FILE_NAME as text from ART_UPLOAD_FILES a ".$where);
		$allData=$db->fetchAll();

		echo json_encode($allData);
		$db->close();		
	}
	
	function loadTree_action()
	{
		$db=new mysql_ht_db(1);
		$result=$db->query("select a.COLUMN_ID as id,a.PARENT_COLUMN_ID as fid,
			a.COLUMN_NAME as text from ART_MENU a ");
		$allData=$db->fetchAll();
//		msg_debug("before department loadtree = ".json_encode($allData));
		$bta=new BuildTreeArray($allData,'id','fid',0);
		$data=$bta->getTreeArray();
		echo json_encode($data);
		msg_debug("column loadtree = ".json_encode($data));
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
		//	session_start();
		//	$arr["CREATE_USERNAME"] = $_SESSION['ART_ID'];
			$arr["UPDATE_TIME"] = date( "Y-m-d H:i:s" );
			$arr["FILE_NAME"] = $_POST['FILE_NAME'];
			$arr["SCHOOL_ID"] = $_POST['SCHOOL_ID'];
			//$arr["ROLE_MENU_ID"] = arrayToString();
			$arr["COLUMN_ID"] = $_POST['COLUMN_ID'];
			$arr["COMMENTS"] = $_POST['COMMENTS'];
			$arr["STATUS"] = $_POST['STATUS'];
			$db->executeInsert( "ART_UPLOAD_FILES", $arr );
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
				$db->execute("delete from ART_UPLOAD_FILES where FILE_ID=".$v );
			}
		}
		$db->close();
	}
	/*
	function arrayToString(){
		$temp="";
		foreach ($_POST['ROLE_MENU_ID'] as $s)
		{
		    $temp=$temp.$s.",";
		}
		$temp = substr($temp,0,strlen($temp)-1); 
		return $temp;
	}
	*/
	function edit_action()
	{	
		$db = new mysql_ht_db(1);
		$arr = array();
		//session_start();
		//$arr["UPDATE_USERNAME"] = $_SESSION['ART_ID'];
		$arr["UPDATE_TIME"] = date( "Y-m-d H:i:s" );
		$arr["FILE_NAME"] = $_POST['FILE_NAME'];
		//$arr["ROLE_MENU_ID"] = arrayToString();
		$arr["COLUMN_ID"] = $_POST['COLUMN_ID'];
		$arr["SCHOOL_ID"] = $_POST['SCHOOL_ID'];
		$arr["COMMENT"] = $_POST['COMMENT'];
		$arr["ENABLED"] = $_POST['ENABLED'];
		$db->executeUpdate( "ART_UPLOAD_FILES", $arr, "where FILE_ID=".$_POST['FILE_ID'] );
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
	//查询文件列表
	if ( $_GET['action'] != null && $_GET['action'] == "query" )
	{
		query_action();
	}
	//修改文件信息
	if ( $_GET['action'] != null && $_GET['action'] == "edit" )
	{
		edit_action();
	}
	//新增文件
	if ( $_GET['action'] != null && $_GET['action'] == "add" )
	{
		add_action();
	}
	//删除文件
	if ( $_GET['action'] != null && $_GET['action'] == "delete" )
	{
		delete_action();
	}
	//加载文件类型菜单树
	if ( $_GET['action'] != null && $_GET['action'] == "loadtree" )
	{
		loadTree_action();
	}
	//查询角色下拉框
	if ( $_GET['action'] != null && $_GET['action'] == "querycombox" )
	{
		querycombox_action();
	}
?>
