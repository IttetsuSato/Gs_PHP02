<?php
session_start();
loginCheck();
$pdo = db_connect();
$uid = $_SESSION["uid"];
//グループリスト表示
$stmt = $pdo->prepare("SELECT * FROM user_data WHERE uid=:uid");
$ustmt->bindValue(':uid',    $uid,     PDO::PARAM_INT);
$status = $stmt->execute();
$prof_view="";
if($status==false) {
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
} else {
  //自分のidが入っているグループだけを表示
  $result = $stmt->fetch();
  $prof_view .= '<div class="prof">';
  $prof_view .= '<div class="prof_img_area">';
  $prof_view .= '<img class="prof_img" src="./prof_img/'.$result["fname"].'"">';
  $prof_view .= '<label><input type="file" name="fname" class="prof_img" accept="image/*"></label><br>';
  $prof_view .= '</div>';
  $prof_view .= '<div class="prof_content_area">';
  $prof_view .= '<label><p class="label">Name:</p>        <input type="text"  name="name" value="'.$result["name"].'"></label><br>';
  $prof_view .= '<label><p class="label">ID:</p>        <p>'.$result["name"].'</p></label><br>';
  $prof_view .= '<label><p class="label">Email:</p><input type="email" name="mail" value="'.$result["mail"].'"></label><br>';
  $prof_view .= '<label><p class="label">Password:</p>    <input type="text"  name="lpw" value="'.$result["lpw"].'"></label><br>';
  $prof_view .= '</div>';//prof_content_area
  $prof_view .= '</div>';//prof
}
?>
    <!-- <label><input type="file" name="fname" class="prof_img" accept="image/*"></label><br>
    <label><p class="label">Name:</p>        <input type="text"  name="name"></label><br>
    <label><p class="label">ID:</p>        <input type="text"  name="name"></label><br>
    <label><p class="label">Email:</p><input type="email" name="mail"></label><br>
    <label><p class="label">Password:</p>    <input type="text"  name="lpw"></label><br> -->