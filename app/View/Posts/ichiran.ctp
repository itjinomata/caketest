<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>ひとこと掲示板</title>
</head>

<body>

  <div id="wrap">
    <div id="head">
      <h1>ひとこと掲示板</h1>
    </div>
    <div id="content">
      
  <?php
  
  //echo "<pre>";var_dump($posts);
  //exit; 
  
  foreach($posts as $post){
  ?>
      <div class="msg">
          
      <img src="./join/member_picture/<?php
      // echo htmlspecialchars($post['Post']['picture']);
      ?>" width="48" height="48" alt="<?php
      // echo htmlspecialchars($post['Post']['name']); 
      ?>" />

      <p><?php echo htmlspecialchars($post['Post']['message']); ?>
      
      <span class="name">（<?php
      // echo htmlspecialchars($post['Post']['name']);
      ?>）</span>[<a href="index.php?res=<?php echo htmlspecialchars($post['Post']['post_id']); ?>">Re</a>]</p>
      
      <p class="day"><a href="view.php?id=<?php echo htmlspecialchars($post['Post']['post_id']); ?>">
          <?php echo htmlspecialchars($post['Post']['created']); ?></a>

          <?php
          if ($post['Post']['reply_post_id'] > 0):
          ?>
              <a href="view.php?id=<?php echo htmlspecialchars($post['Post']['reply_post_id']); ?>">返信元のメッセージ</a>
          <?php
          endif;
          ?>

          [<a href="delete.php?id=<?php echo htmlspecialchars($post['Post']['post_id']); ?>" style="color: #F33;">削除</a>]

      </p>
      </div>
  <?php
  }
  ?>

    <div id="foot">
      <p><img src="images/txt_copyright.png" width="136" height="15" alt="(C) H2O Space. MYCOM" /></p>
    </div>
  </div>

</body>
</html>