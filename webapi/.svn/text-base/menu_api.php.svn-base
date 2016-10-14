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

		$order_string=" ORDER by a.MENU_ID desc";
		
		if ($_POST["page"]!=null&&$_POST["page"]>1){
			$page=$_POST['page']-1;
		}
		if ($_POST["rows"]!=null){
			$pageSize=$_POST['rows'];
		}	
//		if ($_POST["MENU_ID"]!=null){
//			$where=$where." and (a.MENU_ID=".$_POST['MENU_ID']." or a.PARENT_MENU_ID=".$_POST['MENU_ID'].")";
//		}
		$result=$db->queryByPage("a.*,b.MENU_NAME as parent_menu",
			"SYS_MENU a left join SYS_MENU b on a.PARENT_MENU_ID=b.MENU_ID",$where,$page,$pageSize,$order_string);
		$allData=$db->fetchAll();

		$arr=array();
		$arr["total"]=(int)$db->getTotal();
		$arr["rows"]=$allData;
		$arr["pageSize"]=$pageSize;
		echo json_encode($arr);
		$db->close();
	}

	function loadTree_action()
	{
		$db=new mysql_ht_db(1);
		$result=$db->query("select a.MENU_ID as id,a.PARENT_MENU_ID as fid,
			a.MENU_ICON as iconCls,a.MENU_URL as url,a.MENU_NAME as text from SYS_MENU a ");
		$allData=$db->fetchAll();
		$bta=new BuildTreeArray($allData,'id','fid',0);
		$data=$bta->getTreeArray();
		echo json_encode($data);
		$db->close();
	}

	function add_action()
	{
		$sql = "select * from SYS_MENU where MENU_NAME='".$_POST['MENU_NAME']."' and PARENT_MENU_ID='".$_POST['PARENT_MENU_ID']."'";
		if(queryIsExitLoginID($sql)){
			$arr=array();
			$arr["flag"]="1001";
			echo json_encode($arr);
		}else{
			$db = new mysql_ht_db(1);
			$arr = array();
			if($_POST['PARENT_MENU_ID']!=null){
				$arr["PARENT_MENU_ID"] = $_POST['PARENT_MENU_ID'];
			}else{
		   		$arr["PARENT_MENU_ID"]=0;		   		
		    }

			$arr["MENU_NAME"] = $_POST['MENU_NAME'];
			
			$arr["MENU_ICON"] = $_POST['MENU_ICON'];
			$arr["MENU_URL"] = $_POST['MENU_URL'];
			$arr["COMMENT"] = $_POST['COMMENT'];
			$arr["ENABLED"] = $_POST['ENABLED'];
			$db->executeInsert( "SYS_MENU", $arr );
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
				$db->execute("delete from SYS_MENU where MENU_ID=".$v );
			}
		}
		$db->close();
	}

	function edit_action()
	{	
		$temp;
		if($_POST['PARENT_MENU_ID']!=null){
				$temp = $_POST['PARENT_MENU_ID'];
			}else{
		   		$temp=0;		   		
		    }
		$sql = "select * from SYS_MENU where MENU_NAME='".$_POST['MENU_NAME']."' and PARENT_MENU_ID=".$temp." and MENU_ID!=".$_POST['MENU_ID'];
		if(queryIsExitLoginID($sql)){
			$arr=array();
			$arr["flag"]="1001";
			echo json_encode($arr);
		}else{
			$db = new mysql_ht_db(1);
			$arr = array();

			$arr["PARENT_MENU_ID"] = $temp;
			$arr["MENU_NAME"] = $_POST['MENU_NAME'];
			$arr["MENU_ICON"] = $_POST['MENU_ICON'];
			$arr["MENU_URL"] = $_POST['MENU_URL'];
			$arr["COMMENT"] = $_POST['COMMENT'];
			$arr["ENABLED"] = $_POST['ENABLED'];
			$db->executeUpdate( "SYS_MENU", $arr, "where MENU_ID=".$_POST['MENU_ID'] );
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
	msg_debug("------------begin-----------------".$_GET['action']);
	//加载菜单树
	if ( $_GET['action'] != null && $_GET['action'] == "loadtree" )
	{
		loadTree_action();
	}
	//查询菜单列表
	if ( $_GET['action'] != null && $_GET['action'] == "query" )
	{
		query_action();
	}
	//修改菜单信息
	if ( $_GET['action'] != null && $_GET['action'] == "edit" )
	{
		edit_action();
	}
	//新增菜单
	if ( $_GET['action'] != null && $_GET['action'] == "add" )
	{
		add_action();
	}
	//删除菜单
	if ( $_GET['action'] != null && $_GET['action'] == "delete" )
	{
		delete_action();
	}

?>
