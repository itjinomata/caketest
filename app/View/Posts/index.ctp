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
    	<div style="text-align: right"><a href="logout.php">ログアウト</a></div>
      <form action="" method="post">
        <dl>
          <dt><?php //echo htmlspecialchars($member['name']); ?>さん、メッセージをどうぞ</dt>
          <dd>
            <textarea name="message" cols="50" rows="5"><?php //echo htmlspecialchars($message); ?></textarea>
            <input type="hidden" name="reply_post_id" value="<?php //echo htmlspecialchars($_REQUEST['res']); ?>" />
          </dd>
        </dl>
        <div>
          <p>
            <input type="submit" value="投稿する" />
          </p>
        </div>
      </form>
      
  <?php
  //while($post = $posts->fetch(PDO::FETCH_ASSOC)):
  ?>
      <div class="msg">

      <img src="./join/member_picture/<?php //echo htmlspecialchars($post['picture']); ?>" width="48" height="48" alt="<?php //echo htmlspecialchars($post['name']); ?>" />

      <!-- 表示メッセージ（URLがあれば、リンク作成の仕様） -->
      <p><?php //echo makeLink(htmlspecialchars($post['message'])); ?>

      <span class="name">（<?php //echo htmlspecialchars($post['name']); ?>）</span>[<a href="index.php?res=<?php //echo htmlspecialchars($post['id']); ?>">Re</a>]</p>
      
      <p class="day"><a href="view.php?id=<?php //echo htmlspecialchars($post['id']); ?>"><?php //echo htmlspecialchars($post['created']); ?></a>

          <?php
          //if ($post['reply_post_id'] > 0):
          ?>
              <a href="view.php?id=<?php //echo htmlspecialchars($post['reply_post_id']); ?>">返信元のメッセージ</a>
          <?php
          //endif;
          ?>

          <?php
          //if ($_SESSION['id'] == $post['member_id']):
          ?>
          	[<a href="delete.php?id=<?php //echo htmlspecialchars($post['id']); ?>" style="color: #F33;">削除</a>]
          <?php
          //endif;
          ?>

      </p>
      </div>
  <?php
  //endwhile;
  ?>

  <ul class="paging">
  <?php
  //if ($page > 1) {
  ?>
  <li><a href="index.php?page=<?php //print($page - 1); ?>">前のページへ</a></li>
  <?php
  //} else {
  ?>
  <li>前のページへ</li>
  <?php
  //}
  ?>
  <?php
  //if ($page < $maxPage) {
  ?>
  <li><a href="index.php?page=<?php //print($page + 1); ?>">次のページへ</a></li>
  <?php
  //} else {
  ?>
  <li>次のページへ</li>
  <?php
  //}
  ?>
  </ul>
    </div>
    <div id="foot">
      <p><img src="images/txt_copyright.png" width="136" height="15" alt="(C) H2O Space. MYCOM" /></p>
    </div>
  </div>

</body>
</html>
