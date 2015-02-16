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

<div id="content">
<p>次のフォームに必要事項をご記入ください。</p>

<?php echo $this->Form->create('Member', array('type' => 'post')); ?>
	<dl>
		<dt>ニックネーム<span class="required">必須</span></dt>
		<dd>
                <?php //valueを書いていると、初回アクセス時にsessionにデータがないため、エラーになるはず?>
                <?php echo $this->Form->input('name', array('size' => 35 ,'required' => false, 'maxlength' => 255)); ?> 
                <!-- <input type="text" name="name" size="35" maxlength="255" value="" /> -->
		</dd>

                <p></p><p></p>
                
                
		<dt>メールアドレス<span class="required">必須</span></dt>
		<dd>
                <?php echo $this->Form->input('email', array('required' => "required")); ?> 
		</dd>
		
                <p></p><p></p>
                
		<dt>パスワード<span class="required">必須</span></dt>
		<dd>
                <?php echo $this->Form->input('password', array('size' => 10 , 'required' => false, 'maxlength' => 20)); ?> 
        	<!-- <input type="password" name="password" size="10" maxlength="20" value="" /> -->
                </dd>
                
                <!--
		<dt>写真など</dt>
		<dd>

	        	<p>現在登録されている写真</p>
	        	<p><img src="./member_picture/" width="100" height="100" alt="" /></p>

	        	<p>再アップロード</p>
	        	<input type="file" name="image" size="35" value="test"  />

                </dd>
                -->

	</dl>

	<div>
        <?php echo $this->Form->end('入力内容を確認する'); ?>
        <!-- <input type="submit" value="入力内容を確認する" /> -->
	</div>

</form>
</div>

<div id="foot">
<p><img src="../images/txt_copyright.png" width="136" height="15" alt="(C) H2O Space. MYCOM" /></p>
</div>

</div>
</body>
</html>
