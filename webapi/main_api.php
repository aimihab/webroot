<?php include "../include/comm.php"?>
<?php
	function initmenu_action(){
		session_start();
		$db=new mysql_ht_db(1);

		$sql = 'select a.MENU_ID as id,a.PARENT_MENU_ID as pid,
			a.MENU_ICON as icon,a.MENU_URL as url,a.MENU_NAME as menuname 
			from SYS_MENU a where find_in_set(a.MENU_ID,
			(select ro.ROLE_MENU_ID from SYS_USER us
			left join SYS_ROLE ro 
			on us.ROLE_ID = ro.ROLE_ID where USER_ID = '.$_SESSION['ART_ID'].')
			)';

		$result=$db->query($sql);
		$allData=$db->fetchAll();

		$arr=array();

		$arr["flag"]="1000";
		$arr["menus"]=$allData;
		echo json_encode($arr);
		$db->close();
	}


	if ( $_GET['action'] != null && $_GET['action'] == "initmenu" )
	{
		initmenu_action();
	}
?>
