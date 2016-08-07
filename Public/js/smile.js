$(function () {
	var vote_num = $(".vote"),
		number = $(".num1");
	//主页面加载完后加载背景
	$("body").css({
		"background":"url(./Public/images/bodybg3.png) 50% 0 fixed no-repeat",
		"background-size":"100% 100%"
	});
	$(".vote").bind("touchend",function () {
		$.get("",window.location.search.split("&")[window.location.search.split("&").length - 1],function (res) {
			res = JSON.parse(res);
			if(res != false && res != 2){
				vote_num.html(res[""]);
				number.html(res[""]);
			}else{
				if(res == 2){
					alert('你还没有绑定小帮手哦，请到小帮手首页绑定');
				}else{
					alert("你今天已经给这个笑脸投过票了");
				}
			}
		})
	})
});