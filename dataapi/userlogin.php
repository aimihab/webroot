<?php include '../include/comm.php'?>
<?php include '../include/DebugLog.php'?>
<?php include './include/EchoError.php'?>
<?php include './include/XxteaHandler.php'?>

<?php

if ($_GET) EchoError::dieError(10);

if (!isset($_POST['name'])  ||  !isset($_POST['pwd']) || !isset($_POST['mac'])) {
    msg_debug('params is not complete');
    EchoError::dieError(3);
}

$name  = $_POST['name'];
$pwd   = $_POST['pwd'];
$mac   = $_POST['mac'];
if ($name==null || $pwd==null || $mac==null) {
    msg_debug('params is invalid');
    EchoError::dieError(2);
}

$md5pwd = md5($pwd);
$sql = "SELECT USERNAME FROM ART_SCHOOL_USER WHERE USERNAME='$name' AND PASSWORD='$pwd'";
$db = new mysql_ht_db(1);
$sqlData = $db->queryOneRecord($sql);
if ($sqlData == null) {
    msg_debug('invalid name or password');
    $db->close();
    EchoError::dieError(8);
}

$db->close();

$xh = new XxteaHandler();

$retArr = array();
$retArr['error'] = 0;
$retArr['info'] = 'ok';
$retArr['token'] = $xh->getToken($mac);
echo json_encode($retArr);

?>
