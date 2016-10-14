<?php

define("MYSQL_SQL_GETDATA", 1);
define("MYSQL_SQL_EXECUTE", 2);

class mysql_ht_db
{
    var $_server;               //数据库服务器地址
    var $_user;                 //数据库连接帐号
    var $_password;             //数据库连接密码
    var $_dbname;               //数据库名称
    var $_persistency=false;    //是否使用持久连接
    var $_isConnect = false;    //是否已经建立数据库连接
    var $_charset="utf8";       //数据库连接字符集

    var $_isDebug = false;      //是否Debug模式
    
    var $_sql=array();          //执行sql语句数组

    var $_db_connect_id;        //数据库连接对象标识
    var $_result;                //执行查询返回的值
   
    var $_record;
    var $_rowset;
    var $_errno = 0;
    var $_error = "connection error";
    var $_checkDB = false;
	var $total_record=0;
	function getRecord(){
		return $this->_result; 
	}
	function getTotal(){
		return $this->total_record;
	}

    function mysql_ht_db($id,$dbserver="127.0.0.1", $dbuser="root", $dbpassword="ting828",$database="db_sys",
        $persistency = true,$autoConnect=true,$checkdb = false)
    {
//        global $g_dbserver;
//        global $g_dbuser;
//        global $g_dbpassword;
//        global $g_database; 
               
        if($id===1){
            $this->_server = "192.168.0.11";//$g_dbserver;
            $this->_user = "user_art_teach";//$g_dbuser;
            $this->_password = "art2016";//$g_dbpassword;
            $this->_dbname = "db_art_teach";//$g_database;            
        }

		//echo "</p>".$this->_server." ------".$this->_user." ".$this->_password." ". $this->_dbname."</p>";
        $this->_persistency = $persistency;
        $this->_autoConnect = $autoConnect;
        $this->_checkDB = $checkdb;

        if($autoConnect){
            $this->connection();
        }
    }
   
    function connection($newLink = false)
    {
        if (!$newLink){
            if($this->_isConnect && isset($this->_db_connect_id)){
                @mysql_close($this->_db_connect_id);
            }
        }
        $this->_db_connect_id = ($this->_persistency) ? @mysql_pconnect($this->_server, $this->_user, $this->_password):@mysql_connect($this->_server, $this->_user, $this->_password,$newLink);
	   if ($this->_db_connect_id)
        {
            if ($this->version() > '4.1')
            {
                if ($this->_charset != "")
                {
                    @mysql_query("SET NAMES '".str_replace('-', '', $this->_charset)."'", $this->_db_connect_id);
                }
            }

            if ($this->version() > '5.0')
            {
                @mysql_query("SET sql_mode=''", $this->_db_connect_id);
            }

                if (!@mysql_select_db($this->_dbname, $this->_db_connect_id))
                {
                    @mysql_close($this->_db_connect_id);
					//header("HTTP/1.1 503 connect db error");
					//die();
                    $this->_halt("cannot use database " . $this->_dbname);
                }
            return true;
        }
        else
        {
            $this->_halt('111connect failed.',false);
        }
    }
   
   
    function setCharset($charset){
        //$charset = str_replace('-', '', $charset);
        $this->_charset = $charset;
    }

   
    function setDebug($isDebug=true){
        $this->_isDebug = $isDebug;
    }

   
    function query($sql,$type='')
    {   
      //  msg_debug($sql);
	//	print $sql;
        return $this->_runSQL($sql,MYSQL_SQL_GETDATA,$type);
    }
    function queryByPage($select,$table,$where,$pageNo,$pageSize,$order_str='',$type='')
    {
		$sql=sprintf("select count(*) as total from (select %s from %s where %s) temp",$select,$table,$where);
		$this->_runSQL($sql,MYSQL_SQL_GETDATA,$type);
		$rec=$this->fetchRow();
		
		$this->total_record=$rec["total"];
		if (strlen($order_str)==0){
			$sql=sprintf("select %s from %s where %s limit %s,%s",
				$select,$table,$where,$pageNo*$pageSize,$pageSize);
		}
		else{
			$sql=sprintf("select %s from %s where %s %s limit %s,%s",
				$select,$table,$where,$order_str,$pageNo*$pageSize,$pageSize);
		}
        msg_debug("sql...".$sql);
        return $this->_runSQL($sql,MYSQL_SQL_GETDATA,$type);
    }
   	function queryCount($f,$table,$where)
	{
		$sql=sprintf("select count(".$f.") as total from %s where %s",$table,$where);
		$this->_runSQL($sql,MYSQL_SQL_GETDATA,$type);
		$rec=$this->fetchRow();
		return $rec["total"];
	}
	function queryOneRecord($sql)
	{
		$this->_runSQL($sql,MYSQL_SQL_GETDATA,$type);
		return $this->fetchRow();	
	}
	function queryMax($f,$table)
	{
		$sql=sprintf("select max(%s) as total from %s",$f,$table);
		$this->_runSQL($sql,MYSQL_SQL_GETDATA,$type);
		$rec=$this->fetchRow();
		if ($rec==null)
			return 1;
		return $rec["total"]+1;
	}
    function execute($sql)
    {
        return $this->_runSQL($sql,MYSQL_SQL_EXECUTE,"UNBUFFERED");
    }
	function executeInsert($t,$arr)
	{
	
	//	mylog("execute sql.....begin");
		$sql="insert into ".$t."(";
		$n=0;
		foreach($arr as $k=>$v){ 
			if ($n==count($arr)-1)
				$sql=$sql.$k.")";
			else
				$sql=$sql.$k.",";
			$n++;
		}
		$sql=$sql." values(";
		$n=0;
		foreach($arr as $k=>$v){ 
			if ($n==count($arr)-1)
				$sql=$sql."'".$v."')";
			else
				$sql=$sql."'".$v."'".",";
			$n++;
		}
		//echo $sql;
		//echo "</p>";
		//msg_debug("executeInsert-----".$sql);
		
	
		return $this->_runSQL($sql,MYSQL_SQL_EXECUTE,"UNBUFFERED");
    }
    function executeUpdate($t,$arr,$where)
    {
        $sql="update ".$t." set ";
        $n=0;
        foreach($arr as $k=>$v){
            if ($n==count($arr)-1)
                $sql=$sql.$k."='".$v."' ";
            else
                $sql=$sql.$k."='".$v."',";
            $n++;
        }
        if ($this->_isDebug){
            echo $sql."</br>";
        }
        $sql=$sql." ".$where;
        //echo $sql;
        return $this->_runSQL($sql,MYSQL_SQL_EXECUTE,"UNBUFFERED");
    }  
   
    function _runSQL($sql,$sqlType=MYSQL_SQL_GETDATA,$type = '')
    {
        if ($type =="UNBUFFERED"){
            $this->_result = @mysql_unbuffered_query($sql,$this->_db_connect_id);
        }else{
            $this->_result = @mysql_query($sql,$this->_db_connect_id);
        }
       
        //测试模式下保存执行的sql语句
        if($this->_isDebug){
            $this->_sql[]=$sql;
        }

        if ($this->_result)
        {
            return $sqlType==MYSQL_SQL_GETDATA?$this->getNumRows():$this->getAffectedRows();
        }else{
			msg_debug("execute sql..error=".$sql);
            $this->_halt("Invalid SQL: ".$sql);
            return false;
        }
    }
    function executeDdl($sql,$sqlType=MYSQL_SQL_GETDATA,$type = '')
    {
        if ($type =="UNBUFFERED"){
            $this->_result = @mysql_unbuffered_query($sql,$this->_db_connect_id);
        }else{
            $this->_result = @mysql_query($sql,$this->_db_connect_id);
        }
       
        //测试模式下保存执行的sql语句
        if($this->_isDebug){
            $this->_sql[]=$sql;
        }

        if ($this->_result)
        {
			return true;
          //  return $sqlType==MYSQL_SQL_GETDATA?$this->getNumRows():$this->getAffectedRows();
        }else{
           // $this->_halt("Invalid SQL: ".$sql);
            return false;
        }
    }
   
    function next($result_type=MYSQL_ASSOC) {
        $this->fetchRow($result_type); 
        return is_array($this->_record);
    }
   
   
    function f($name) {
        if(is_array($this->_record)){
            return $this->_record[$name];
        }else{
            return false;
        }
    }
   
   
    function fetchRow($result_type=MYSQL_ASSOC)
    {
        if( $this->_result )
        {
            $this->_record = @mysql_fetch_array($this->_result,$result_type);
            return $this->_record;
        }else{
            return false;
        }
    }
   
   
    function getAll($sql,$primaryKey="",$result_type=MYSQL_ASSOC)
    {
        if ($this->_runSQL($sql,MYSQL_SQL_GETDATA)>=0){

            return $this->fetchAll($primaryKey,$result_type);
        }else{
            return false;
        }
    }

   
    function getOne($sql,$result_type=MYSQL_ASSOC)
    {
        if ($this->_runSQL($sql,MYSQL_SQL_GETDATA)>0){
            $arr = $this->fetchAll("",$result_type);
            if(is_array($arr)){
                return $arr[0];
            }
        }else{
            return false;
        }
    }
   
    function fetchAll($primaryKey = "",$result_type=MYSQL_ASSOC)
    {
        if ($this->_result)
        {
            $i = 0;
            $this->_rowset = array();

            if ($primaryKey=="")
            {
                while($this->next($result_type))
                {
                    $this->_rowset[$i] = $this->_record;
                    $i++;
                }
            }else{
                while($this->next($result_type))
                {
                    $this->_rowset[$this->f($primaryKey)] = $this->_record;
                    $i++;
                }
            }

            return $this->_rowset;
        }else{
            //$this->_halt("Invalid Result");
            return false;
        }
    }
   
     
    function checkExist($sql)
    {
        return $this->query($sql)>0?true:false;
    }

   
    function getValue($sql, $colset = 0)
    {
        if ($this->query($sql)>0){
            $this->next(MYSQL_BOTH);
            return $this->f($colset);
        }else{
            return false;
        }
    }
   
   
    function getNumRows()
    {
        return @mysql_num_rows($this->_result);
    }
   
   
    function getNumFields()
    {
        return @mysql_num_fields($this->_result);
    }

   
    function getFiledName($offset)
    {
        return @mysql_field_name($this->_result, $offset);
    }

   
    function getFiledType($offset)
    {
        return @mysql_field_type($this->_result, $offset);
    }

   
    function getFiledLen($offset)
    {
        return @mysql_field_len($this->_result, $offset);
    }

   
    function getInsertId()
    {
        return @mysql_insert_id($this->_db_connect_id);
    }

   
    function getAffectedRows()
    {
        return @mysql_affected_rows($this->_db_connect_id);
    }

   
    function free_result()
    {
        $ret = @mysql_free_result($this->_result);
        $this->_result = 0;
        return $ret;
    }

   
    function version() {
        return @mysql_get_server_info($this->_db_connect_id);
    }

   
    function close() {
        return @mysql_close($this->_db_connect_id);
    }
   
   
    function sqlOutput($isOut = true, $all = true){
        if($all){
            $ret = implode("<br>",$this->_sql);
        }else{
            $ret = $this->_sql[count($this->_sql)-1];
        }
        if ($isOut){
            echo $ret;
        }else{
            return $ret;
        }
    }

   
    function _halt($msg="Session halted.",$getErr=true) {
        if($this->_isDebug){
            if($getErr){
                $this->_errno = @mysql_errno($this->_db_connect_id);
                $this->_error = @mysql_error($this->_db_connect_id);
                printf("<b>MySQL _error</b>: %s (%s)<br></font>\n",$this->_errno,$this->_error);
            }
            die($msg);
        }else{
			printf("<b>MySQL _error</b>: %s (%s)<br></font>\n",$this->_errno,$this->_error);
            die("Session halted.");
        }
    }
}

function test()
{
$db = new mysql_ht_db(1);
if ($db == null) echo "null";
echo $db->queryOneRecord("select * from SYS_USER where USER_ID=1000");
$db->close();
}

//test();

?>
