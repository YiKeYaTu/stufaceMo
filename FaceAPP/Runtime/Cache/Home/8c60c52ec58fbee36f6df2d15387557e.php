<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>smile</title>
	<link rel="stylesheet" href="/stufaceMo/Public/css/normalize.css">
	<link rel="stylesheet" href="/stufaceMo/Public/css/smiles.css">
	<script src="/stufaceMo/Public/js/flexible.js"></script>
	<script src="/stufaceMo/Public/js/zepto.min.js"></script>
	<script src="/stufaceMo/Public/js/smile.js"></script>
</head>
<body>
	<div class="photo">
		<div class="container">
			<img class="show-pic" src="/stufaceMo/Public/images/person1.png">
			<span class="zan">
				<p class="zan-num"><span class="zan-pic"><i class="iconfont1">&#xe6b2;</i>&nbsp;</span>
					<?php  $key = $message[0]; ?>
					<span class="num"><?php echo $key['vote']; ?></span>
				</p>
			</span>
			<span class="ranked">
				<p class="tic-num"><span class="zan-pic">排名:</span><span class="num1">&nbsp;&nbsp;<?php echo $key['ID'];?></span></p>
			</span>
		</div>
		<span class="ranking">NO.<?php echo $key['ID'];?></span>
	</div>
	<input class="vote" type="button" value="为笑脸投一票">
	<script>
		$(function () {
			var vote_num = $(".num"),
				number = $(".num1");
			//主页面加载完后加载背景
			$("body").css({
				"background":"url(Public/images/bodybg3.png) 50% 0 fixed no-repeat",
				"background-size":"100% 100%"
			});
			$(".vote").bind("touchend",function () {
				$.post("<?php echo U('Smile/vote');?>",window.location.search.split("&")[window.location.search.split("&").length - 1],function (res) {
					res = JSON.parse(res);
					console.log(res);
					if(res){
						vote_num.html(res["vote"]);
						number.html(res["top"]);
					}else{
						alert("你今天已经给这个笑脸投过票了");
					}
				})
			})
		});
		
	</script>
</body>
</html>