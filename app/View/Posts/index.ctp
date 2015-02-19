<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>ひとこと掲示板</title>
</head>

<body>

    <?php //echo $this->element('sql_dump');exit; ?>
    
    <?php //var_dump($count);exit; ?>
    <?php //var_dump($posts); ?>  
    <!-- array(7) { ["member_id"]=> string(2) "34" 
    ["name"]=> string(3) "abc" ["email"]=> string(7) "def@ghi" ["photo"]=> string(0) "" 
    ["picture"]=> string(0) "" ["created"]=> string(19) "2015-02-16 10:59:30" 
    ["modified"]=> string(19) "2015-02-16 10:59:30" } -->
    <?php //echo $count; ?>
    
  <div id="wrap">
    <div id="head">
      <h1>ひとこと掲示板</h1>
    </div>
    <div id="content">
    	<div style="text-align: right"><a href="logout.php">ログアウト</a></div>
      <form action="" method="post">
        <dl>
          <dt><?php echo h($user['name']); ?>さん、メッセージをどうぞ</dt>
          <dd>
            <textarea name="message" cols="50" rows="5"><?php //echo h($message); ?></textarea>
            <input type="hidden" name="reply_post_id" value="<?php //echo h($_REQUEST['res']); ?>" />
          </dd>
        </dl>
        <div>
          <p>
            <input type="submit" value="投稿する" />
          </p>
        </div>
      </form>
        
  <?php
  foreach ($pgn as $post) {
  ?>
      <div class="msg">

      <?php echo $this->Html->image('member_picture' . DS . $post['Member']['picture'],
        array('alt' => $post['Member']['name'] , 'width' => '48' , 'height' => '48' )
      ); ?>

      <!-- 表示メッセージ（URLがあれば、リンク作成の仕様） -->
     <?php 
        //echo makeLink(htmlspecialchars($post['message']));
        echo h($post['Post']['message']);     
     ?>

      <span class="name">（<?php echo h($post['Member']['name']); ?>）</span>[<a href="index.php?res=<?php echo h($post['Post']['post_id']); ?>">Re</a>]</p>
      
      <p class="day"><a href="view.php?id=<?php echo h($post['Post']['post_id']); ?>"><?php echo h($post['Post']['created']); ?></a>

          <?php
          if ($post['Post']['reply_post_id'] > 0):
          ?>
              <a href="view.php?id=<?php echo h($post['Post']['reply_post_id']); ?>">返信元のメッセージ</a>
          <?php
          endif;
          ?>

          <?php
          if ($user['member_id'] == $post['Post']['member_id']):
          ?>
          	[<a href="delete.php?id=<?php echo h($post['Post']['member_id']); ?>" style="color: #F33;">削除</a>]
          <?php
          endif;
          ?>

      </p>
      </div>
  <?php
  }
  ?>

  <ul class="paging">
      <?php echo $this->Paginator->prev('<< 前へ'); ?>　<?php echo $this->Paginator->numbers(); ?>　<?php echo $this->Paginator->next('次へ >>'); ?>
  </ul>
    </div>
    <div id="foot">
      <p><img src="images/txt_copyright.png" width="136" height="15" alt="(C) H2O Space. MYCOM" /></p>
    </div>
  </div>

</body>
</html>
