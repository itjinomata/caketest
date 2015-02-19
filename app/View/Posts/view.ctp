<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>ひとこと掲示板</title>
</head>

<body>
    <?php //var_dump($prev);exit; ?>
    
    
    <div id="wrap">
  <div id="head">
    <h1>ひとこと掲示板</h1>
  </div>
  <div id="content">
  <p><?php echo $this->Html->link('一覧にもどる','./index/'); ?></p>

<?php

    if($post[0]['Post']['reply_post_id'] > 0){

?>

    <div class="msg">
    <p><?php echo $this->Html->image('member_picture' . DS . $prev[0]['Member']['picture'],
        array('alt' => $prev[0]['Member']['name'] , 'width' => '48' , 'height' => '48' )
      ); ?>
    <?php echo h($prev[0]['Post']['message'], ENT_QUOTES, 'UTF-8'); ?><span class="name">（<?php echo h($prev[0]['Member']['name'], ENT_QUOTES, 'UTF-8'); ?>）</span></p>
    <p class="day"><?php echo h($prev[0]['Post']['created'], ENT_QUOTES, 'UTF-8'); ?></p>
    </div>

    <div class="msg">
    <p><?php echo $this->Html->image('member_picture' . DS . $post[0]['Member']['picture'],
        array('alt' => $post[0]['Member']['name'] , 'width' => '48' , 'height' => '48' )
      ); ?>
    <?php echo h($post[0]['Post']['message'], ENT_QUOTES, 'UTF-8'); ?><span class="name">（<?php echo h($post[0]['Member']['name'], ENT_QUOTES, 'UTF-8'); ?>）</span></p>
    <p class="day"><?php echo h($post[0]['Post']['created'], ENT_QUOTES, 'UTF-8'); ?></p>
    </div>

<?php
    }else{
?>

    <div class="msg">
    <p><?php echo $this->Html->image('member_picture' . DS . $post[0]['Member']['picture'],
        array('alt' => $post[0]['Member']['name'] , 'width' => '48' , 'height' => '48' )
      ); ?>
    <?php echo h($post[0]['Post']['message'], ENT_QUOTES, 'UTF-8'); ?><span class="name">（<?php echo h($post[0]['Member']['name'], ENT_QUOTES, 'UTF-8'); ?>）</span></p>
    <p class="day"><?php echo h($post[0]['Post']['created'], ENT_QUOTES, 'UTF-8'); ?></p>
    </div>

<?php
    }
?>

<p>この投稿への返信</p>

<?php
 foreach ($nexts as $next) {
?>

    <?php //var_dump($next);exit; ?>    
    <div class="msg">
    <p><?php echo $this->Html->image('member_picture' . DS . $next['Member']['picture'],
        array('alt' => $next['Member']['name'] , 'width' => '48' , 'height' => '48' )
      ); ?>
    <?php echo h($next['Post']['message'], ENT_QUOTES, 'UTF-8'); ?><span class="name">（<?php echo h($next['Member']['name'], ENT_QUOTES, 'UTF-8'); ?>）</span></p>
    <p class="day"><?php echo h($next['Post']['created'], ENT_QUOTES, 'UTF-8'); ?></p>
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
