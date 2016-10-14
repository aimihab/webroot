<?php include '../include/mysql_ht_class.php'?>
<?php include '../include/DebugLog.php'?>
<?php include './include/EchoError.php'?>

<?php
date_default_timezone_set("Asia/Shanghai");

if ($_GET) EchoError::dieError(10);

if (!isset($_POST['name'])  || 
    !isset($_POST['truename']) || 
    !isset($_POST['pwd'])   || 
    !isset($_POST['email']) || 
    !isset($_POST['phone']) || 
    !isset($_POST['mac'])) 
{
    msg_debug('params is not complete');
    EchoError::dieError(3);
}

$name  = $_POST['name'];
$truename  = $_POST['truename'];
$pwd   = $_POST['pwd'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$mac = $_POST['mac'];
if ($name==null || $truename==null || $pwd==null || $email==null || $phone==null || $mac==null) {
    msg_debug('params is invalid');
    EchoError::dieError(2);
}

/*
$name = '111';
$truename = '111';
$pwd = '111';
$email = '111';
$phone = '111';
$mac = '111';
*/

//$sql = "SELECT USERNAME as dbname,EMAIL as dbemail,PHONE as dbphone FROM ART_SCHOOL_USER WHERE USERNAME='$name' OR EMAIL='$email' OR PHONE='$phone'";
$db = new mysql_ht_db(1);
$sql = "SELECT count(*) as total FROM ART_SCHOOL_USER WHERE USERNAME='$name' OR EMAIL='$email' OR PHONE='$phone'";
msg_debug("sql : $sql");
$result = $db->queryCountBySql($sql);
$sqlData = $db->fetchAll();

if ($sqlData) {
    $db->close();
    msg_debug("same name : $name");
    EchoError::dieError(4);
/*
    if ($sqlData['dbname'] == $name) {
        msg_debug("same name : $name");
        EchoError::dieError(4);
    }
    if ($sqlData['dbemail'] == $email) {
        msg_debug("same email : $email");
        EchoError::dieError(5);
    }
    if ($sqlData['dbphone'] == $phone) {
        msg_debug("same phone : $phone");
        EchoError::dieError(6);
    }
*/
}

$md5pwd = md5($pwd);
$create_time = time(0);
//$sql = "INSERT INTO ART_SCHOOL_USER (SCHOOL_ID,USERNAME,PASSWORD,CREATE_TIME,NAME,PHONE,EMAIL) VALUES ((SELECT SCHOOL_ID FROM ART_DEVICE_LIST WHERE MAC='$mac'), '$name', '$md5pwd', '$create_time', '$truename', '$phone', '$email')";

$sql = "SELECT SCHOOL_ID FROM ART_DEVICE_LIST WHERE MAC='$mac'";
$result = $db->query($sql);
$allData = $db->fetchAll();
msg_debug(json_encode($allData));
if (!$allData) {
    msg_debug("node school id find...");
    EchoError::dieError(11);
}

$schid= $allData[0]['SCHOOL_ID'];
$sql = "INSERT INTO ART_SCHOOL_USER (SCHOOL_ID,USERNAME,PASSWORD,CREATE_TIME,NAME,PHONE,EMAIL) VALUES ('$schid', '$name', '$md5pwd', '$create_time', '$truename', '$phone', '$email')";
$bRet = $db->insertBySql($sql);
$db->close();
if ($bRet == false) {
    msg_debug("register failed");
    EchoError::dieError(6);
}

EchoError::dieError(0);

?>
