<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="../style.css" />
<title>会員登録</title>
</head>

<body>   
    
<div id="wrap">
<div id="head">
<h1>会員登録</h1>
</div>

<?php //var_dump($sesposts); exit; ?>    
    
<div id="content">
<p>記入した内容を確認して、「登録する」ボタンをクリックしてください</p>
<?php echo $this->Form->create('Post'); ?>
<!-- <form action="" method="post"> -->

        <?php echo $this->Form->hidden('action' ,array('value' => 'submit')); ?>
	<!-- <input type="hidden" name="action" value="submit" /> -->
	<dl>
		<dt>ニックネーム</dt>
		<dd>
		<?php echo htmlspecialchars($sesposts['name'], ENT_QUOTES, 'UTF-8'); ?>
                </dd>
		<dt>メールアドレス</dt>
		<dd>
		<?php echo htmlspecialchars($sesposts['email'], ENT_QUOTES, 'UTF-8'); ?>
                </dd>
		<dt>パスワード</dt>
		<dd>
		【表示されません】
		</dd>
	</dl>
	<div><?php echo $this->Html->link('書き直す','./index') ?>　| 
            <?php echo $this->Form->end('登録する'); ?>
            <!-- <input type="submit" value="登録する" /> -->
        </div>
</form>
</div>

    
<div id="foot">
<p><img src="../images/txt_copyright.png" width="136" height="15" alt="(C) H2O Space. MYCOM" /></p>
</div>

</div>
</body>
</html>
