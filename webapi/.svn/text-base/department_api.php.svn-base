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

		$order_string=" ORDER by a.DEP_ID desc";
		
		if ($_POST["page"]!=null&&$_POST["page"]>1){
			$page=$_POST['page']-1;
		}
		if ($_POST["rows"]!=null){
			$pageSize=$_POST['rows'];
		}
		if (isset($_POST["DEP_ID"])) {
//		if ($_POST["DEP_ID"]!=null){
			$where=$where." and (a.DEP_ID=".$_POST['DEP_ID']." or a.PARENT_DEP_ID=".$_POST['DEP_ID'].")";
		}	
		$result=$db->queryByPage("a.*,b.DEP_NAME as parent_name,a1.USERNAME as cUser,a2.USERNAME as uUser",
			"SYS_DEPARTMENT a left join SYS_DEPARTMENT b on a.PARENT_DEP_ID=b.DEP_ID
			left join SYS_USER a1 on a.CREATE_USERNAME=a1.USER_ID
			left join SYS_USER a2 on a.UPDATE_USERNAE=a2.USER_ID",$where,$page,$pageSize,$order_string);
		$allData=$db->fetchAll();

		$arr=array();
		$arr["total"]=(int)$db->getTotal();
		$arr["rows"]=$allData;
		$arr["pageSize"]=$pageSize;
		msg_debug(json_encode($arr));
		echo json_encode($arr);
		$db->close();
	}

	function loadTree_action()
	{
		$db=new mysql_ht_db(1);
		$result=$db->query("select a.DEP_ID as id,a.PARENT_DEP_ID as fid,
			a.DEP_NAME as text from SYS_DEPARTMENT a ");
		$allData=$db->fetchAll();
//		msg_debug("before department loadtree = ".json_encode($allData));
		$bta=new BuildTreeArray($allData,'id','fid',0);
		$data=$bta->getTreeArray();
		echo json_encode($data);
		msg_debug("department loadtree = ".json_encode($data));
		$db->close();
	}

	function add_action()
	{
		$sql = "select * from SYS_DEPARTMENT where DEP_NAME='".$_POST['DEP_NAME']."' and PARENT_DEP_ID='".$_POST['PARENT_DEP_ID']."'";
		if(queryIsExitLoginID($sql)){
			$arr=array();
			$arr["flag"]="1001";
			echo json_encode($arr);
		}else{
			$db = new mysql_ht_db(1);
			$arr = array();
			if($_POST['PARENT_DEP_ID']!=null){
				$arr["PARENT_DEP_ID"] = $_POST['PARENT_DEP_ID'];
			}else{
		   		$arr["PARENT_DEP_ID"]=0;		   		
		    }
			session_start();
			$arr["CREATE_USERNAME"] = $_SESSION['ART_ID'];
			$arr["CREATE_TIME"] = date( "Y-m-d H:i:s" );
			$arr["DEP_NAME"] = $_POST['DEP_NAME'];
			$arr["COMMENT"] = $_POST['COMMENT'];
			$arr["ENABLED"] = $_POST['ENABLED'];
			$db->executeInsert( "SYS_DEPARTMENT", $arr );
			$db->close();
			$arr=array();
			$arr["flag"]="1000";
			echo json_encode($arr);
		}
		
	}

	function delete_action()
	{
		
		$db = new mysql_ht_db(1);
		
		$files = split ( ';', $_POST['del_list'] );
		foreach( $files as $k => $v ) {
			if ( strlen( $v ) > 0 ) {
				$db->execute("delete from SYS_DEPARTMENT where DEP_ID=".$v );
			}
		}
		$db->close();
	}

	function edit_action()
	{	
		$temp;
		if($_POST['PARENT_DEP_ID']!=null){
				$temp = $_POST['PARENT_DEP_ID'];
			}else{
		   		$temp=0;		   		
		    }
		$sql = "select * from SYS_DEPARTMENT where DEP_NAME='".$_POST['DEP_NAME']."' and PARENT_DEP_ID=".$temp." and DEP_ID!=".$_POST['DEP_ID'];
		if(queryIsExitLoginID($sql)){
			$arr=array();
			$arr["flag"]="1001";
			echo json_encode($arr);
		}else{
			$db = new mysql_ht_db(1);
			$arr = array();
			session_start();
			$arr["UPDATE_USERNAE"] = $_SESSION['ART_ID'];
			$arr["UPDATE_TIME"] = date( "Y-m-d H:i:s" );
			$arr["PARENT_DEP_ID"] = $temp;
			$arr["DEP_NAME"] = $_POST['DEP_NAME'];
			$arr["COMMENT"] = $_POST['COMMENT'];
			$arr["ENABLED"] = $_POST['ENABLED'];
			$db->executeUpdate( "SYS_DEPARTMENT", $arr, "where DEP_ID=".$_POST['DEP_ID'] );
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
	//加载部门树
	if ( $_GET['action'] != null && $_GET['action'] == "loadtree" )
	{
		loadTree_action();
	}
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

?>
