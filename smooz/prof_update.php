<?php
if(
  !isset($_POST["name"]) || $_POST["name"]==""   ||
  !isset($_POST["lpw"]) || $_POST["lpw"]==""   ||
  !isset($_POST["mail"]) || $_POST["mail"]==""   
){
  header("Location: main.php"); 
  exit;
}
session_start();
//1.  DB接続します
include("funcs.php");
loginCheck();

//1.POSTデータ取得
$uid           = $_SESSION["uid"];
$name = $_POST["name"];
$mail = $_POST["mail"];
$lpw = $_POST["lpw"];
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
$sql = "UPDATE `user_data` SET `name`=[:name],`mail`=[:mail],`fname`=[:fname],`lpw`=[:lpw] WHERE id=:uid"; 

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':uid',$uid,         PDO::PARAM_INT); 
$stmt->bindValue(':mail',$mail,       PDO::PARAM_STR); 
$stmt->bindValue(':lpw',$lpw,         PDO::PARAM_STR); 
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