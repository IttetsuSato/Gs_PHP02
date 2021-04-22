<?php
session_start();

//SESSIONを空っぽにする
$_SESSION = array();

//Cookieに保存してあるSessionIDの保存期間を過去にして破棄
if(isset($_COOKIE[session_name()])){
  setcookie(session_name(), '', time()-42000, '/');
}

//サーバー側での、セッションIDの破棄
session_destroy();

header("Location: index.php");
exit();
?>