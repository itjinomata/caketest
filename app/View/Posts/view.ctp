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
  <p>&laquo;<a href="index.php">一覧にもどる</a></p>

<?php
// 投稿を取得する
$posts = $dbh->prepare('SELECT m.name, m.picture, p.* FROM members m, posts p WHERE m.id=p.member_id AND p.id=?');
$posts->execute(array($_REQUEST['id']));

if ($post = $posts->fetch(PDO::FETCH_ASSOC)){

  $reply = $dbh->prepare('SELECT * FROM posts WHERE id=?');
  $reply->execute(array($post['reply_post_id']));

  if($prev = $reply->fetch(PDO::FETCH_ASSOC)){

    $meminfo = $dbh->prepare('SELECT name, picture FROM members WHERE id=?');
    $meminfo->execute(array($prev['member_id']));
    $output = $meminfo->fetch(PDO::FETCH_ASSOC)

?>

    <div class="msg">
    <img src="./join/member_picture/<?php echo htmlspecialchars($output['picture'], ENT_QUOTES, 'UTF-8'); ?>" width="48" height="48" alt="<?php echo htmlspecialchars($output['name'], ENT_QUOTES, 'UTF-8'); ?>" />
    <p><?php echo htmlspecialchars($prev['message'], ENT_QUOTES, 'UTF-8'); ?><span class="name">（<?php echo htmlspecialchars($output['name'], ENT_QUOTES, 'UTF-8'); ?>）</span></p>
    <p class="day"><?php echo htmlspecialchars($prev['created'], ENT_QUOTES, 'UTF-8'); ?></p>
    </div>

    <div class="msg">
    <img src="./join/member_picture/<?php echo htmlspecialchars($post['picture'], ENT_QUOTES, 'UTF-8'); ?>" width="48" height="48" alt="<?php echo htmlspecialchars($post['name'], ENT_QUOTES, 'UTF-8'); ?>" />
    <p><?php echo htmlspecialchars($post['message'], ENT_QUOTES, 'UTF-8'); ?><span class="name">（<?php echo htmlspecialchars($post['name'], ENT_QUOTES, 'UTF-8'); ?>）</span></p>
    <p class="day"><?php echo htmlspecialchars($post['created'], ENT_QUOTES, 'UTF-8'); ?></p>
    </div>

<?php
  }else{
?>

    <div class="msg">
    <img src="./join/member_picture/<?php echo htmlspecialchars($post['picture'], ENT_QUOTES, 'UTF-8'); ?>" width="48" height="48" alt="<?php echo htmlspecialchars($post['name'], ENT_QUOTES, 'UTF-8'); ?>" />
    <p><?php echo htmlspecialchars($post['message'], ENT_QUOTES, 'UTF-8'); ?><span class="name">（<?php echo htmlspecialchars($post['name'], ENT_QUOTES, 'UTF-8'); ?>）</span></p>
    <p class="day"><?php echo htmlspecialchars($post['created'], ENT_QUOTES, 'UTF-8'); ?></p>
    </div>

<?php
  }
?>

<?php
}else{
?>

	<p>その投稿は削除されたか、URLが間違えています</p>

<?php
}
?>

<p>この投稿への返信</p>

<?php
// 返信を取得する
$nexts = $dbh->prepare('SELECT m.name, m.picture, p.* FROM members m, posts p WHERE m.id=p.member_id AND p.reply_post_id=? ORDER BY p.created ASC');
$nexts->execute(array($_REQUEST['id']));

while($next = $nexts->fetch(PDO::FETCH_ASSOC)){
?>

    <div class="msg">
    <img src="./join/member_picture/<?php echo htmlspecialchars($next['picture'], ENT_QUOTES, 'UTF-8'); ?>" width="48" height="48" alt="<?php echo htmlspecialchars($next['name'], ENT_QUOTES, 'UTF-8'); ?>" />
    <p><?php echo htmlspecialchars($next['message'], ENT_QUOTES, 'UTF-8'); ?><span class="name">（<?php echo htmlspecialchars($next['name'], ENT_QUOTES, 'UTF-8'); ?>）</span></p>
    <p class="day"><?php echo htmlspecialchars($next['created'], ENT_QUOTES, 'UTF-8'); ?></p>
    </div>

<?php
}
?>

  </div>
  <div id="foot">
    <p><img src="images/txt_copyright.png" width="136" height="15" alt="(C) H2O Space. MYCOM" /></p>
  </div>
</div>
</body>
</html>
