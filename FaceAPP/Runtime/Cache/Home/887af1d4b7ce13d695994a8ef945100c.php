<?php if (!defined('THINK_PATH')) exit();?><form action="<?php echo U('Index/login');?>" method="post" >
	账号<input type="text" name="username">
	密码<input type="password" name="password">
	<input type="submit" name="submit" value="登录">

</form>


<form action="<?php echo U('Index/upload');?>" method="post" enctype="multipart/form-data">
	<input type="file" name="photo">

	<input type="submit" name="submit" value="上传">
<!--
	<img src="/stuface/Public/upimage/55e5c4576f993.jpg">
-->	
</form>