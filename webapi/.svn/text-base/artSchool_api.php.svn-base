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

		$order_string=" ORDER by a.SCHOOL_ID desc";
		
		if ($_POST["page"]!=null&&$_POST["page"]>1){
			$page=$_POST['page']-1;
		}
		if ($_POST["rows"]!=null){
			$pageSize=$_POST['rows'];
		}	
//		if ($_POST["DEP_ID"]!=null){
//			$where=$where." and (a3.DEP_ID=".$_POST['DEP_ID']." or a3.PARENT_DEP_ID=".$_POST['DEP_ID'].")";
//		}	
		$result=$db->queryByPage("a.*,b.SCHOOL_NAME as s_name",
			"ART_SCHOOL a left join ART_SCHOOL b on a.SCHOOL_ID=b.SCHOOL_ID",$where,$page,$pageSize,$order_string);
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
		$result=$db->query("select a.SCHOOL_ID as id,a.SCHOOL_NAME as text from ART_SCHOOL a ".$where);
		$allData=$db->fetchAll();

		echo json_encode($allData);
		$db->close();		
	}
	
	function loadTree_action()
	{
		$db=new mysql_ht_db(1);
		$result=$db->query("select a.SCHOOL_ID as id,
			a.SCHOOL_NAME as text from ART_SCHOOL a ");
		$allData=$db->fetchAll();
//		msg_debug("before department loadtree = ".json_encode($allData));
		$bta=new BuildTreeArray($allData,'id',0);
		$data=$bta->getTreeArray();
		echo json_encode($data);
		msg_debug("SCHOOL loadtree = ".json_encode($data));
		$db->close();
	}

	function add_action()
	{
			$db = new mysql_ht_db(1);
			$arr = array();
	
			$arr["CREATE_TIME"] = date( "Y-m-d H:i:s" );
			$arr["SCHOOL_NAME"] = $_POST['SCHOOL_NAME'];
			$arr["ADDR"] = $_POST['ADDR'];
			$arr["CONTACTS"] = $_POST['CONTACTS'];
			$arr["PHONE"] = $_POST['PHONE'];
			$arr["EMAIL"] = $_POST['EMAIL'];
			$arr["COMMENT"] = $_POST['COMMENT'];
			$arr["ENABLED"] = $_POST['ENABLED'];
			$db->executeInsert( "ART_SCHOOL", $arr );
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
				$db->execute("delete from ART_SCHOOL where SCHOOL_ID=".$v );
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
	
		$arr["CRTARE_TIME"] = date( "Y-m-d H:i:s" );
		$arr["SCHOOL_NAME"] = $_POST['SCHOOL_NAME'];
		$arr["ADDR"] = $_POST['ADDR'];
		$arr["CONTACTS"] = $_POST['CONTACTS'];
		$arr["PHONE"] = $_POST['PHONE'];
		$arr["EMAIL"] = $_POST['EMAIL'];
		$arr["COMMENT"] = $_POST['COMMENT'];
		$arr["ENABLED"] = $_POST['ENABLED'];
		$db->executeUpdate( "ART_SCHOOL", $arr, "where SCHOOL_ID=".$_POST['SCHOOL_ID'] );
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
	
	
	//查询所有学校信息
	if ( $_GET['action'] != null && $_GET['action'] == "query" )
	{
		query_action();
	}
	//修改学校信息
	if ( $_GET['action'] != null && $_GET['action'] == "edit" )
	{
		edit_action();
	}
	//新增学校
	if ( $_GET['action'] != null && $_GET['action'] == "add" )
	{
		add_action();
	}
	//删除学校
	if ( $_GET['action'] != null && $_GET['action'] == "delete" )
	{
		delete_action();
	}
	//加载学校树
	if ( $_GET['action'] != null && $_GET['action'] == "loadtree" )
	{
		loadTree_action();
	}	
	//查询学校下拉框
	if ( $_GET['action'] != null && $_GET['action'] == "querycombox" )
	{
		querycombox_action();
	}
?>
