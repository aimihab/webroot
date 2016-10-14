<?php
session_start();
if(!isset($_SESSION['ART_ID'])) {
echo "<script>window.location.href='admin_login.php';</script>";
}
?>
