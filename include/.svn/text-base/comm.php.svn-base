<?php include 'define.php'?>
<?php include 'mysql_ht_class.php'?>
<?php include 'BuildTreeArray.php'?>
<?php
date_default_timezone_set("Asia/Shanghai");
function get($key)
{
	if ($_GET[$key]==null){
		return $_POST[$key];
	}
	else
		return $_GET[$key];
}
function get_memcache($n)
{
	global $mem_server;
	if (PHP_OS=="Linux"){
		$mem = new Memcached();
		$mem->addServer($mem_server[$n]["ip"], $mem_server[$n]["port"], 1);	
		return $mem;
	}
	else{
		$mem = new Memcache;  
		$mem->connect($mem_server[$n]["ip"], $mem_server[$n]["port"])  or die ("Could not connect");	
		return $mem;
	}
}

function create_db_group()
{
	//new mysql_db(0),new mysql_db(1);
	return $db=array(new mysql_db(0),new mysql_db(1));
}
function get_group_id($n)
{
	return $n/50;
}
function get_group_db($db,$n)
{
	return $db[get_group_id($n)];
}

function free_db_group($db)
{
	$db[0]->close();
	$db[1]->close();
	return 0;
}

function db_group_query($db,$n,$sql)
{
	
}
function get_max_user_id($db)
{
	$db[0]->query("insert into USER_ID(USER_NAME) value('11')");
	$max=$db[0]->getInsertId();
	$db[0]->query("delete from  USER_ID");
	
	return $max;
}
function get_db_id($user_id)
{
	return floor(($user_id%100)/50);
}
function get_user_table($user_id)
{
	return "SNS_USER".$user_id%100;
}
function check_vsapi_data()
{
	return true;
	$headers = apache_request_headers();
	if (get("token")==null){
		$arr=array();
		$arr["error_text"]="check signature error! token is null";
		$arr["error_code"]=1001;
		echo json_encode($arr);
		die("");
	}
	if (get("token")!="passbymovnow"){
		if ($headers["session-key"]==null){
			$arr=array();
			$arr["error_text"]="check signature error! signature is null";
			$arr["error_code"]=1001;
			echo json_encode($arr);
			die("");
		}
		$md5=md5("movnow".get("token")."sns");
			
		if ($headers["session-key"]!=$md5){
			$arr=array();
			$arr["error_text"]="check signature error! signature is error,".$md5;
			$arr["error_code"]=1001;
			echo json_encode($arr);
			die("");
		}
	}
}
function send_pack_to_imud($cmd_type,$str)
{
	global $g_imud_server;
	global $g_imud_port;
	$socket = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP); 
    //连接服务器端socket 
	$connection = @socket_connect($socket, $g_imud_server, $g_imud_port); 
	if ($connection){
		//return ;
	}
	else	
		return ;
	//print_r($connection);
	$h=pack('N4',0x416e4574,$cmd_type,0,strlen($str));
	@socket_write($socket,$h);
	@socket_write($socket,$str);
	@socket_close($socket);
	return ;
	$header=@socket_read($socket,16);
	$arr= unpack("N4",$header);
	$body=@socket_read($sock,100);

	@socket_close($socket);
}

function send_pack_to_push($cmd_type,$chId,$str)
{
	global $g_push_server;
	global $g_push_port;
	$socket = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP); 
    //连接服务器端socket 
	$connection = @socket_connect($socket, $g_push_server, $g_push_port); 
	if ($connection){
		//return ;
	}
	else	
		return ;
	//print_r($connection);
	$h=pack('N4',0x416e4574,$cmd_type,$chId,strlen($str));
	@socket_write($socket,$h);
	@socket_write($socket,$str);
	@socket_close($socket);
	return ;
	$header=@socket_read($socket,16);
	$arr= unpack("N4",$header);
	$body=@socket_read($sock,100);

	@socket_close($socket);
}

function get_cached_object($mc,$key)
{
	$cache=$mc->get($key);
	if ($cache!=null){
		$obj=json_decode($cache,true);
		return $obj;
	}	
	$db=new mysql_db(0);
	$db->query("select * from SNS_ALL_CACHED where CACHE_KEY='".$key."'");
	if (($rec=$db->fetchRow())!=false){
		$mc->set($key,$rec["CACHE_VALUE"]);
		$c=$rec["CACHE_VALUE"];
		$db->close();
		return json_decode($c,true);
	}
	else{
		$f=array();
		$f["CACHE_KEY"]=$key;
		$f["CACHE_VALUE"]="{}";
		$db->executeInsert("SNS_ALL_CACHED",$f);
		$db->close();
		return json_decode("{}",true);
	}
}

function save_cached_object($mc,$key)
{
	$cache=$mc->get($key);
	if ($cache!=null){
		$obj=json_decode($cache,true);
		return $obj;
	}	
	$db=new mysql_db(0);
	$db->query("select * from SNS_ALL_CACHED where CACHE_KEY='".$key."'");
	if (($rec=$db->fetchRow())!=false){
		$mc->set($key,$rec["CACHE_VALUE"]);
	}
	$db->close();
}

function get_wb_object($mc,$key)
{
	$cache=$mc->get($key);
	if ($cache!=null){
		$obj=json_decode($cache,true);
		return $obj;
	}	
	$db=new mysql_db(0);
	$db->query("select * from SNS_WEIBO where WB_ID='".substr($key,2)."'");
	if (($rec=$db->fetchRow())!=false){
		$mc->set($key,$rec["JSON"]);
		$c=$rec["JSON"];
		$db->close();
		return json_decode($c,true);
	}
	$db->close();
	return null;
}

function get_user_json_object($mc,$user_id)
{
	if ($user_id==null)
		return null;
	//查询memcached，看是否已经存在，如果已经存在，则返回
	global $max_user_table;
	$user=$mc->get($user_id);
	if ($user!=null){
		$obj=json_decode($user,true);
		$obj["user_id"]=$user_id;
		return $obj;
	}
	$mail=strtolower($user_id);
	$db=create_db_group();
	$find=false;
	
	$json_res=false;
	if (strstr($mail,"@")==null){
		//通过帐号userid查询
		$rec=$db[get_db_id($user_id)]->queryOneRecord("select * from ".get_user_table($user_id)." where USER_ID='".$user_id."'");
		if ($rec!=false){
			$j=json_decode($rec["JSON"],true);
			$j["user_id"]=$user_id;
			if ($j["pwd"]==null)
				$j["pwd"]=$rec["PASSWORD"];
			$mc->set($user_id,json_encode($j));
			return $j;
		}
	}
	//查找电子邮件
	if (strstr($mail,"@")!=null){
		for($n=0;$n<$max_user_table;$n++){
		//	echo "select * from SNS_USER".$n." where EMAIL='".$user_id."'";
			if (($rec=get_group_db($db,$n)->queryOneRecord("select * from SNS_USER".$n." where EMAIL='".$user_id."'"))!=false){
				$user=$mc->get($rec["USER_ID"]);
				if ($user!=null){
					$obj=json_decode($user,true);
					$obj["user_id"]=$rec["USER_ID"];
					free_db_group($db);
					return $obj;
				}
				$mc->set($rec["USER_ID"],$rec["JSON"]);
				$json_res=json_decode($rec["JSON"],true);
				$json_res["user_id"]=$rec["USER_ID"];
				if ($json_res["pwd"]==null)
					$json_res["pwd"]=$rec["PASSWORD"];
				$find=true;
				break;
			}	
		}	
	}

	//查找手机号码
	if ($find==false){
		for($n=0;$n<$max_user_table;$n++){
			if (($rec=get_group_db($db,$n)->queryOneRecord("select * from SNS_USER".$n." where MOBILE0='".$mail."'"))!=false){
				$mc->set($rec["USER_ID"],$rec["JSON"]);
				$find=true;
				$json_res=json_decode($rec["JSON"],true);
				$json_res["user_id"]=$rec["USER_ID"];
				if ($json_res["pwd"]==null)
					$json_res["pwd"]=$rec["PASSWORD"];
				break;
			}	
		}	
	}
	free_db_group($db);
	return $json_res;
}

function save_user_info($mc,$user_id,$obj)
{
	//echo $user_id."========save to=======".json_encode($obj);
	//保存到memory cached!
	$mc->set($user_id,json_encode($obj));
	//通知imud修改数据库
	$arr=array();
    $arr["user_id"]=$user_id;
    send_pack_to_imud(10000,json_encode($arr));
}
function check_param($key,$err_code,$err_text)
{
	if (get($key)==null){
		$arr["error_code"]=$err_code;
		$arr["error_text"]=$err_text;	
		echo json_encode($arr);
		die("");	
	}
}
function reply_http_msg_die($err_code,$err_text)
{
	$arr=array();
	$arr["error_code"]=$err_code;
	$arr["error_text"]=$err_text;	
	echo json_encode($arr);
	die("");
}
function reply_http_msg($err_code,$err_text)
{
	$arr=array();
	$arr["error_code"]=$err_code;
	$arr["error_text"]=$err_text;	
	echo json_encode($arr);
}

function array_remove($arr,$del_id){
	$dst=array();
	for($n=0;$n<count($arr);$n++){
		if ($n!=$del_id)
			array_push($dst,$arr[$n]);
	}
	return $dst;
}
function get_user_nick($user_obj)
{
	if ($user_obj["config"]==null)
		return "";
	if ($user_obj["config"]["nick"]==null)
		return "";
	return $user_obj["config"]["nick"];
}
function get_user_icon($user_obj)
{
	if ($user_obj["himage"]!=null && count($user_obj["himage"])>0){
		return $user_obj["himage"][count($user_obj["himage"])-1]["url"];
	}
	return "";
}
?>
