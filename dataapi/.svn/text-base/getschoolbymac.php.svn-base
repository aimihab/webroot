<?php include '../include/comm.php'?>
<?php include '../include/DebugLog.php'?>
<?php include './include/EchoError.php'?>

<?php
if (!isset($_GET['mac'])) {
    msg_debug('mac is null');
    EchoError::dieError(1);
}

$mac = $_GET['mac'];
if ($mac == null) {
    msg_debug('mac is null');
    EchoError::dieError(1);
}

$db = new mysql_ht_db(1);
$sql = "SELECT scl.SCHOOL_ID AS id,scl.SCHOOL_NAME AS name,scl.ADDR AS addr,scl.EMAIL AS email,scl.PHONE AS phone FROM ART_SCHOOL scl, ART_DEVICE_LIST dl WHERE scl.SCHOOL_ID=dl.SCHOOL_ID AND dl.MAC='$mac'";
$sqlData = $db->queryOneRecord($sql);
if ($sqlData == null) {
    msg_debug('no data');
    $db->close();
    EchoError::dieError(2);
}

$retArr = array();
$retArr['error'] = 0;
$retArr['info'] = 'ok';
$retArr['data'] = $sqlData;

$db->close();
echo json_encode($retArr);

?>
