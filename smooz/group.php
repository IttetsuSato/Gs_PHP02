<?php
session_start();
loginCheck();
$pdo = db_connect();
$uid = $_SESSION["uid"];
//グループリスト表示
$stmt = $pdo->prepare("SELECT * FROM group_list");
$status = $stmt->execute();
$group_view="";
if($status==false) {
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
} else {
  //自分のidが入っているグループだけを表示
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $gid = $result["id"];
    $ustmt = $pdo->prepare("SELECT * FROM member_$gid WHERE member=:uid");
    $ustmt->bindValue(':uid',    $uid,     PDO::PARAM_INT);
    $ustatus = $ustmt->execute();
    $res = $ustmt->fetch();
    if($res){
      $group_view .= '<a href="./chat_open.php?id='.$gid.'">';
      $group_view .= '<div class="group">';
      $group_view .= '<div class="group_img_area">';
      $group_view .= '<img class="group_img" src="./group_img/'.$result["fname"].'"">';
      $group_view .= '</div>';
      $group_view .= '<div class="group_content_area">';
      $group_view .= '<p class="group_name">'.$result["name"].'</p>';
      $group_view .= '</div>';//group_content_area
      $group_view .= '</div>';//group
      $group_view .= '</a>';
    }
  }
}
?>