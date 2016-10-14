<?php include "../include/comm.php"?>
<?php include "../include/DebugLog.php" ?>
<?php
function login_action()
{
		$db=new mysql_ht_db(1);
		$where="where 1=1 ";

		if ($_POST['USERNAME']!=null) {
			$where=$where." and USER_LOGIN_ID='".$_POST['USERNAME']."'";
		}else{
			$arr=array();
			$arr["flag"]="1001";
			echo json_encode($arr);
			return;
		}

		if ($_POST['PASSWORD']!=null) {
			$where=$where." and PASSWORD='".md5($_POST['PASSWORD'])."'";
		}else{
			$arr=array();
			$arr["flag"]="1001";
			echo json_encode($arr);
			return;
		}
		msg_debug($where);

		$result=$db->query("select * from SYS_USER ".$where);
		
		if($result){
			$allData=$db->fetchRow();
			session_start();
			$_SESSION['ART_USER']=$allData["USERNAME"];
			$_SESSION['ART_ID']=$allData["USER_ID"];
			$arr=array();
			$arr["flag"]="1002";
			echo json_encode($arr);
		}else{
			$arr=array();
			$arr["flag"]="1001";
			echo json_encode($arr);
		}
		
		$db->close();
	}
	function loginout_action(){
		session_start();
		session_destroy();
	}
	function modifyPass_action(){
				  foreach ($_POST as $key => $value)
		 {
		    msg_debug($key."---------".$value);
		}
		$db = new mysql_ht_db(1);
		$arr = array();
		session_start();
		$arr["PASSWORD"] = md5($_POST['newpass']);
		$result=$db->executeUpdate( "SYS_USER", $arr, "where USER_ID=".$_SESSION["ART_ID"]." and PASSWORD='".md5($_POST['txtOldPass'])."'" );
		$arr1 = array();
		$arr1["flag"]=$result;
		echo json_encode($arr1);
		$db->close();		
	}	
	if ( $_GET['action'] != null && $_GET['action'] == "login" )
	{
		login_action();
	}
	if ( $_GET['action'] != null && $_GET['action'] == "loginout" )
	{
		loginout_action();
	}
	if ( $_GET['action'] != null && $_GET['action'] == "modifyPass" )
	{
		modifyPass_action();
	}
?>
