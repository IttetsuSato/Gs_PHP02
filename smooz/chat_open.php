<?php
session_start();
include("funcs.php");
loginCheck();
$_SESSION["gid"] = $_GET["id"];
header("Location: main.php");
?>
