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


  //sakura
  // try {
  //   $dsn = 'mysql:dbname=makeyouhappy_smooz;host=mysql57.makeyouhappy.sakura.ne.jp;charset=utf8;unix_socket=/tmp/mysql.sock';
  //   $user = 'makeyouhappy';
  //   $password = 'D4e74a2ue-cQ';
  //   $pdo = new PDO($dsn, $user, $password);
  // } catch (PDOException $e) {
  //   exit('DbConnectError:'.$e->getMessage());
  // }
  // return $pdo;
}
?>
