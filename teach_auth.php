<?php
session_start();
if(!isset($_SESSION['ART_ID'])) {
echo "<script>window.location.href='teach_login.php';</script>";
}
?>
