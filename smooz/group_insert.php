<?php
//入力チェック
if(
  !isset($_POST["name"])           || $_POST["name"]==""       ||
  !isset($_FILES["fname"]["name"]) || $_FILES["fname"]["name"]=="" 
){
  header("Location: main.php"); 
  exit();
}
session_start();
include("./funcs.php");
loginCheck();

//1.POSTデータ取得
$name          = $_POST["name"];
$fname         = $_FILES["fname"]["name"]; 
$uid = $_SESSION["uid"];

//1-2. FileUpload処理
if(isset($fname)){
  $upload = "./group_img/";
  if(move_uploaded_file($_FILES['fname']['tmp_name'], $upload.$fname)){
    //FileUpload:OK
  } else {
    //FileUpload:NG
    echo "Upload failed";
    echo $_FILES['fname']['error'];
  }
}

//2. DB接続（エラー処理追加）
$pdo = db_connect();
//3. データ登録SQL作成
$sql = "INSERT INTO group_list(id, name, fname, indate, live)VALUES(NULL,:name,:fname,sysdate(),0)"; 
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name',$name,       PDO::PARAM_STR); 
$stmt->bindValue(':fname',$fname,     PDO::PARAM_STR); 
$status = $stmt->execute();

//作成したテーブルのid取得
$stmt = $pdo->prepare("SELECT * FROM group_list ORDER BY indate DESC LIMIT 1 ");
$status = $stmt->execute();
if($status==false) {
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
} else {
  $res = $stmt->fetch();
  $gid = $res["id"];
}
//メンバー登録用テーブル作成
$stmt = $pdo->prepare("CREATE TABLE member_$gid (member INT(16))");
$status = $stmt->execute();
if($status==false) {
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}
//メンバー登録テーブルに自分のidを登録
$sql = "INSERT INTO member_$gid(member)VALUES(:member)"; 
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':member',$uid,       PDO::PARAM_STR); 
$status = $stmt->execute();
//グループチャット用テーブル作成
$stmt = $pdo->prepare("CREATE TABLE chat_$gid (
  uid INT(16),
  message text NULL,
  fname VARCHAR(128) NULL,
  indate DATETIME,
  id INT(16) AUTO_INCREMENT,
  PRIMARY KEY (id));
  )");
$status = $stmt->execute();
if($status==false) {
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
} else {
  header("Location: main.php");
}

?>