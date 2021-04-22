<?php
//XSS対応関数
function h($val){
  return htmlspecialchars($val,ENT_QUOTES);
}
//LOGIN認証チェック関数
function loginCheck(){
  if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()){
  echo "LOGIN Error!";
  exit();
}else{
  session_regenerate_id(true); //セッションハイジャック対策
  $_SESSION["chk_ssid"] = session_id();
}
}
//データベース接続
function db_connect(){


  // localhost
  try {
    $pdo = new PDO('mysql:dbname=smooz;charset=utf8;host=localhost','root','root');//host=データベースのipアドレス
  } catch (PDOException $e) {
    exit('DbConnectError:'.$e->getMessage());
  }
  return $pdo;


}
?>
