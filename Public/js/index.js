$(function () {
	var firstUl = $('.clicked-ul').eq(0),
	    secondUl = $('.clicked-ul').eq(1),
	    first = $("#b1"),
	    second = $("#b2");
	//下拉菜单
	$(firstUl).bind("touchend",function () {
		if ($(this).hasClass('second-line')) {
			$(this).removeClass('second-line');
		};
		$(this).addClass('first-line');
		if (!$(secondUl).hasClass('second-line')) $(secondUl).addClass('second-line');
	});
	$(secondUl).bind("touchend",function () {
		if ($(this).hasClass('second-line')) {
			$(this).removeClass('second-line');
		};
		$(this).addClass('first-line');
		if (!$(firstUl).hasClass('second-line')) $(firstUl).addClass('second-line');
	});
	$(".part-first").css({
		"background":"url(Public/images/bodybg1.png) 50% 0 no-repeat",
		"background-size":"100% 100%"
	});
	$("#c1").bind("click",function (e) {
		var target = e.target;
		if(target.nodeName = "A"){
			first.text($(target).html());
		}
	})
	$("#c2").bind("click",function (e) {
		var target = e.target;
		if(target.nodeName = "A"){
			second.text($(target).html());
		}
	})
})