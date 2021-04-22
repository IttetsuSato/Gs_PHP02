<?php
include("funcs.php");
include("group.php");
include("chat.php");
?>














<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://kit.fontawesome.com/f5097be879.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<header>
  <a href="./logout.php" class="logout">ログアウト</a>
  <div class="uid">あなたのID：<?=$_SESSION["uid"]?></div>
  <!-- プロフィール
  <div class="form_area prof_form">
  <div class="batsu">×</div>
  <form action="prof_update.php" method="post" enctype="multipart/form-data">
      <input class="btn_sakusei" type="submit" value="更新する">
  </form>
</div> -->
</header>
<main>


<section class="group_section">
  <div class="group_list">
    <!-- グループ表示 -->
    <div class="output"><?=$group_view?></div>
    <!-- グループ作成フォーム -->
    <div id="make_group" class="group">
      <div class="group_img_area">
        <p class="group_plus">+</p>
      </div>
      <div class="group_content_area">
        <p class="group_name">グループ作成</p>
      </div>
    </div>
    <div class="form_area group_form">
      <div class="form_title">グループ作成</div>
      <form action="group_insert.php" method="post" enctype="multipart/form-data">
      <label><p class="label">グループ名:</p>        <input type="text"  name="name"></label><br>
      <label><p class="label">トップ画像:</p>          <input type="file" name="fname" accept="image/*"></label><br>
      <input class="btn_sakusei" type="submit" value="作成する">
      </form>
    </div>
  
  </div>
</section>


<section class="chat_section">
  <!-- 招待フォーム -->
  <div class="invite_form">
    <form action="invite.php" method="post">
      <label><p class="label">招待する人のID:</p><input type="text"  name="member"></label>
        <input class="btn_invite" type="submit" value="招待する">
    </form>
  </div>
  <!-- チャット表示エリア -->
  <div class="output chat_output"><?=$chat_view?></div>
  
  <!-- 書き込みエリア -->
  <form action="chat_insert.php" method="post" enctype="multipart/form-data">
    <input type="text"  name="message" style="width: 300px; margin-left: 12px;outline: none; border-radius: 300px; border: solid 1px #aaa;">
    <label class="fileInput">
        <i class="fas fa-images"></i><input id="fileInput" type="file" accept="image/*" value="" name="fname">
    </label>
    <label class="submit_btn">
    <i class="fa fa-paper-plane" aria-hidden="true"></i><input class="submit_btn" type="submit" value="送信">
    </label>
    </form>
</section>


<section class="video_section">
  <div class="room">
    <div>
      <video id="js_local_stream"></video>
      <input type="text" placeholder="Room Name" id="js_room_id" value="<?=$gid?>">
      <div class="remote_streams" id="js_remote_streams"></div>
      <button id="js_join_trigger">参加</button>
      <button id="js_leave_trigger">退出</button>
    </div>


    <div>
      <pre class="messages" id="js_messages"></pre>
      <!-- <input type="text" id="js_local_text">
      <button id="js_send_trigger">Send</button> -->
    </div>
  </div>
  </section>
</main>

</body>

<script src="//cdn.webrtc.ecl.ntt.com/skyway-4.2.0.js"></script>
<script src="js/room.js"></script>
<script src="js/main.js"></script>
</html>