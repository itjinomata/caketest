<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>ひとこと掲示板</title>
</head>

<body>

    <?php //echo $this->element('sql_dump');exit; 
    //var_dump($postAsc);exit;
    ?>
    
  <div id="wrap">
    <div id="head">
      <h1>ひとこと掲示板</h1>
    </div>
    <div id="content">
    	<div style="text-align: right"><?php echo $this->Html->link('ログアウト','./logout'); ?></div>
        <?php echo $this->Form->create('Post', array('type' => 'post')); ?>
        <?php echo $this->Form->hidden('member_id', array('value' => $user['member_id'])); ?> 
        <dl>
          <dt><?php echo h($user['name']); ?>さん、メッセージをどうぞ</dt>
          <dd>
            <?php 
            if(isset($reply[0]['Post']['message'])){
                echo $this->Form->textarea('message', array('cols' => 50 ,'rows' => 5, 'value' => $reply[0]['Post']['message']));
            }else{
                echo $this->Form->textarea('message', array('cols' => 50 ,'rows' => 5));                
            }
            
            ?> 
            <!-- <textarea name="message" cols="50" rows="5"><?php //echo h($message); ?></textarea> -->
              
              
            <?php echo $this->Form->hidden('reply_post_id', array('value' => $postId)); ?>               
            <!-- <input type="hidden" name="reply_post_id" value="<?php //echo h($_REQUEST['res']); ?>" /> -->
          </dd>
        </dl>
        <div>
          <p>
            <?php echo $this->Form->end('投稿する'); ?>
            <!-- <input type="submit" value="投稿する" /> -->
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
        echo $this->Text->autoLink(h($post['Post']['message']));     
     ?>

      <span class="name">（<?php echo h($post['Member']['name']); ?>）</span>[<?php echo $this->Html->link('Re','./index/' . $post['Post']['post_id']); ?>]</p>
      
      <p class="day"><?php echo $this->Html->link($post['Post']['created'],'./view/' . $post['Post']['post_id']); ?>

          <?php
          if ($post['Post']['reply_post_id'] > 0):
          ?>
              <?php echo $this->Html->link('返信元のメッセージ','./view/' . $post['Post']['reply_post_id']); ?>
          <?php
          endif;
          ?>

          <?php
          if ($user['member_id'] == $post['Post']['member_id']):
          ?>
          	[<?php echo $this->Html->link('削除','./delete/' . $post['Post']['post_id']); ?>]
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
