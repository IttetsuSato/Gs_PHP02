<?php
//メッセージか画像のどちらかがないとリダイレクト
if(
  !isset($_POST["message"]) || $_POST["message"]=="" and
  !isset($_FILES["fname"]["name"]) || $_FILES["fname"]["name"]=="" 
){
  header("Location: main.php"); 
  exit;
}
session_start();
//1.  DB接続します
include("funcs.php");
loginCheck();

//1.POSTデータ取得
$gid           = $_SESSION["gid"];
$uid           = $_SESSION["uid"];
$message       = $_POST["message"];
$fname         = $_FILES["fname"]["name"]; 


//1-2. FileUpload処理
if(isset($fname)){
  $upload = "./images/";
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
$sql = "INSERT INTO chat_$gid(uid, message, fname, indate, id)VALUES(:uid,:message,:fname,sysdate(),NULL)"; 

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':uid',$uid,         PDO::PARAM_INT); 
$stmt->bindValue(':message',$message, PDO::PARAM_STR); 
$stmt->bindValue(':fname',$fname,     PDO::PARAM_STR); 
$status = $stmt->execute();

//4.データ登録処理後
if($status==false){
  $error =$stmt->errorInfo();
  exit("QueryError:".$error[2]); //エラー文
}else{
  //5. index.phpへリダイレクト
  header("Location: main.php"); 
  exit;
}



?>