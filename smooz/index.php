<?php
session_start();
include("funcs.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/login.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
  <div id="btn_login">ログイン</div>
  <div id="btn_account">アカウント作成</div>
<!-- ログインフォーム -->
<div class="form_area login_form">
  <h1 class="form_title">ログイン</h1>
  <div class="batsu">×</div>
  <form action="login_act.php" method="post">
    <label><p class="label">Email:</p><input type="email"  name="mail"></label><br>
    <label><p class="label">Password:</p><input type="text" name="lpw"></label><br>
    <input class="btn_sakusei" type="submit" value="ログイン">
  </form>
</div>

<!-- アカウント作成フォーム -->
<div class="form_area account_form">
  <h1 class="form_title">アカウントを作成する</h1>
  <div class="batsu">×</div>
  <form action="account_insert.php" method="post" enctype="multipart/form-data">
    <label><p class="label">Name:</p>        <input type="text"  name="name"></label><br>
    <label><p class="label">Email:</p><input type="email" name="mail"></label><br>
    <label><p class="label">Password:</p>    <input type="text"  name="lpw"></label><br>
    <label><p class="label">Profile Image:</p>          <input type="file" name="fname" class="prof_img" accept="image/*"></label><br>
      <input class="btn_sakusei" type="submit" value="作成する">
  </form>
</div>

  <script src="js/login.js"></script>
</body>
</html>