<?php
//入力チェック
if(
  !isset($_POST["name"])       || $_POST["name"]==""       ||
  !isset($_POST["mail"])       || $_POST["mail"]==""       ||
  !isset($_POST["lpw"])        || $_POST["lpw"]==""
){
  exit('ParamError');
}

//1.POSTデータ取得
$name       = $_POST["name"];
$mail       = $_POST["mail"];
$lpw        = $_POST["lpw"];
$fname         = $_FILES["fname"]["name"]; 

//1-2. FileUpload処理
if(isset($fname)){
  $upload = "./prof_img/";
  if(move_uploaded_file($_FILES['fname']['tmp_name'], $upload.$fname)){
    //FileUpload:OK
  } else {
    //FileUpload:NG
    echo "Upload failed";
    echo $_FILES['fname']['error'];
  }
}

//2. DB接続（エラー処理追加）
include("funcs.php");
$pdo = db_connect();

//3. データ登録SQL作成
$sql = "INSERT INTO user_data(uid, name, mail, fname, lpw, indate)VALUES(NULL,:name,:mail,:fname,:lpw, sysdate())"; 

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':name',$name,       PDO::PARAM_STR); 
$stmt->bindValue(':mail',$mail,       PDO::PARAM_STR); 
$stmt->bindValue(':fname',$fname,     PDO::PARAM_STR); 
$stmt->bindValue(':lpw',$lpw,         PDO::PARAM_STR);
$status = $stmt->execute();

//4.データ登録処理後
if($status==false){
  $error =$stmt->errorInfo();
  exit("QueryError:".$error[2]); //エラー文
}else{
  //5. index.phpへリダイレクト
  header("Location: index.php"); 
  exit;
}
?>