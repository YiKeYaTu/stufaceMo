<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>upload</title>
	<link rel="stylesheet" href="/stufaceMo/Public/css/normalize.css">
	<link rel="stylesheet" href="/stufaceMo/Public/css/upload.css">
	<script src="/stufaceMo/Public/js/flexible.js"></script>
	<script src="/stufaceMo/Public/js/zepto.min.js"></script>
	<script src="/stufaceMo/Public/js/jweixin-1.0.0.js"></script>
	<script src="/stufaceMo/Public/js/upload.js"></script>
</head>
<body>
	<div class="photo">
		<div class="container">
			<div class="upload-img">
				<p class="plus"><img class="plus-img" src="/stufaceMo/Public/images/plus.png" alt="点击添加图片"></p>
				<p class="add-img">添加图片</p>
			</div>
        	<img class="show-pic" src="/stufaceMo/Public/images/person1.png">
        </div>
        <div class="cover"></div>
    	<input class="vote" type="text" placeholder="输入你的手机号">
    	<p class="tips">我们是不会泄露你的联系方式哒～</p>
    	<input class="upload" type="button" value="上传图片"></input>
	</div>
	<form style="display: none;" class="p_form" method="post" action="/stuface/index.php?m=home&c=index&a=uploadpic" enctype="multipart/form-data">
		<input type="file" class="add-in-file" name="photo">
		<input type="submit">
	</form>
	<div class="upload-info1">
		<p>呜呜呜上传失败了π^π</p>
		<input class="refresh" type="button" value="点击重发">
		<img class="close" src="/stufaceMo/Public/images/close.png" alt="close">
	</div>
	<div class="upload-info3">
		<p>上传中....</p>
	</div>
	<div class="upload-info2">
		<p class="success"><img src="/stufaceMo/Public/images/right.png" alt="success">&nbsp;上传成功</p>
		<p class="delay-time">(3 秒 后 自 动 跳 转 到 首 页...）</p>
		<img class="close" src="/stufaceMo/Public/images/close.png" alt="close">
	</div>
</body>
</html>