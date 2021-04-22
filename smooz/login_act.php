<?php
session_start();
$mail = $_POST["mail"];
$lpw = $_POST["lpw"];

//2. DB接続します（エラー処理追加）
include("funcs.php");
$pdo = db_connect();

//3. データ表示SQL作成
$sql = "SELECT*FROM user_data WHERE mail=:mail AND lpw=:lpw"; 

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':mail',$mail, PDO::PARAM_STR); //Integer(数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lpw',$lpw, PDO::PARAM_STR); //Integer(数値の場合)PDO::PARAM_INT)
$status = $stmt->execute();

if($status==false){
  $error =$stmt->errorInfo();
  exit("QueryError:".$error[2]); 
}else{
  $result = $stmt->fetch();
  //GETデータ送信リンク作成
  if($result["uid"] != ""){
    $_SESSION["chk_ssid"]  = session_id();
    $_SESSION["kanri"]  = $result['kanri'];
    $_SESSION["name"]  = $result['name'];
    $_SESSION["uid"]  = $result['uid'];
    header("Location: ./main.php");
  }else{
    header("Location: index.php");
  }
  
}
?>