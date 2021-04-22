<?php
//入力チェック
if(
  !isset($_POST["member"])           || $_POST["member"]==""
){
  header("Location: main.php"); 
  exit();
}
session_start();
include("./funcs.php");
loginCheck();



//1.POSTデータ取得
$member          = $_POST["member"];
$gid = $_SESSION["gid"];
echo $gid.$member;
//2. DB接続（エラー処理追加）
$pdo = db_connect();
//メンバー登録テーブルに自分のidを登録
$sql = "INSERT INTO member_$gid(member)VALUES(:member)"; 
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':member',$member, PDO::PARAM_STR); 
$status = $stmt->execute();
if($status==false) {
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
} else {
  header("Location: main.php");
}
?>