<?php
session_start();
setcookie(session_name(), '', 100);
unset($_SESSION['admin_name']);
unset($_SESSION['admin_id']);
session_unset();
session_destroy();
$_SESSION = array();
header("Location: ../");
?>