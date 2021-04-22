<?php
session_start();
loginCheck();
$pdo = db_connect();
$gid;
$gid = $_SESSION["gid"];
if(isset($gid)){
  //２．データ登録SQL作成
  $stmt = $pdo->prepare("SELECT * FROM chat_$gid");
  $status = $stmt->execute();
  
  //３．データ表示
  $chat_view="";
  if($status==false) {
    $error = $stmt->errorInfo();
    exit("ErrorQuery:".$error[2]);
  } else {
    while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
      $ustmt = $pdo->prepare("SELECT * FROM user_data WHERE uid=:uid");
      $ustmt->bindValue(':uid',    $result["uid"],     PDO::PARAM_INT);
      $ustatus = $ustmt->execute();
      if($ustatus==false){
        $error =$ustmt->errorInfo();
        exit("QueryError:".$error[2]); 
      }else{
        $udata = $ustmt->fetch();

        $chat_view .= '<div class="chat_block">';
        $chat_view .= '<div class="chat_profimg_area"><img class="chat_profimg" src="./prof_img/'.$udata["fname"].'""></div>';
        $chat_view .= '<div class="chat_content_area">';
        $chat_view .= '<div class="chat_names">';
        $chat_view .= '<p class="chat_name">'.$udata["name"].'</p>';
        $chat_view .= '<p class="chat_indate">'.$result["indate"].'</p>';
        $chat_view .= '</div>';//names
        if(!$result["message"] == ""){
          $chat_view .= '<p class="chat_text">'.$result["message"].'</p>';
        }
        if(!$result["fname"] == ""){
          $chat_view .= '<img class="chat_img" src="./chat_img/'.$result["fname"].'" width="50px" height="50px"></div>';
        }
        $chat_view .= '</div>';//chat_content_area
        $chat_view .= '</div>';//chat_block
      }
    }
  }
}//if(isset($gid))
  ?>