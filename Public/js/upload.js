$(function () {
	var container = $(".container"),
		cover = $(".cover"),
		upload_info1 = $(".upload-info1"),
		upload = $(".upload"),
		container = $(".container"),
		p_form = $(".p_form"),
		test_last = /\.png$|jpeg$|jpg$/,
		check_upload = false,
		file = $(p_form[0].children[0]),
		upload_img = $(".upload-img"),
		uploading = $(".upload-info3"),
		formData,
		xhr;
	//微信配置信息
	// wx.config({
 //        debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
 //        appId: 'wx81a4a4b77ec98ff4', // 必填，公众号的唯一标识
 //        timestamp: '', // 必填，生成签名的时间戳
 //        nonceStr: '', // 必填，生成签名的随机串
 //        signature: '',// 必填，签名，见附录1
 //        jsApiList: ['chooseImage','uploadImage'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
 //    });
 //    wx.checkJsApi({
 //      jsApiList: [
 //        'chooseImage',
 //        'previewImage'
 //      ],
 //      success: function (res) {
 //        console.log("success");
 //      },
 //      fail: function (res) {
 //        console.log("fail");
 //      }
 //    });
    function reupload() {
    	upload.css({
			"background":"#c3c3c3"
		})
		.attr("value","上传图片");
		cover.animate({
			"width":"0",
			"height":"0"
		},200);
		upload_info1.animate({
			"display": "none",
		},200);
    }
    function close() {
    	upload.css({
			"background":"#c3c3c3"
		})
		.attr("value","上传图片")
		cover.animate({
			"width":"0",
			"height":"0"
		},200);
		upload_info1.animate({
			"display": "none",
		},200);
    }
    function chooseImg () {
    	var value = $(p_form[0].children[0]).val();
    	if(test_last.test(value)){
    		check_upload =  true;
    		upload_img.css('display',"none");
    		container.css('background-image',"url(" + getFullSrc(file[0]) +  ")");
    	}else{
    		alert("所选文件格式不对");
    		check_upload =  false;
    	}
    }
    function getFullSrc (obj) {
    	return window.URL.createObjectURL(obj.files[0]);
    }
    function uploadImg () {
    	if(!check_upload) return;
    	formData = new FormData(p_form[0]);
    	cover.css('display',"block");
    	uploading.css('display',"block");
		$.post("index.php?m=Home&c=Upload&a=upload","",function (res) {
			res = JSON.parse(res);
			if(res){
				formData.append("uid",res["uid"]);
				formData.append("sex",res["sex"]);
				formData.append("form",res["form"]);
				xhr = new XMLHttpRequest();  
				xhr.open( "POST", "http://hongyan.cqupt.edu.cn/stuface/?m=Home&c=Index&a=uploadpic" ,true); 
				xhr.onload = function(res) {  
					console.log(res.currentTarget.response);
					if (xhr.status == 200) { //上传图片功能 这里我向你发送文件后 你需要判断是否上传成功 返回true或者false
						if(res.currentTarget.response == "true"){
							alert("上传成功,请等待管理员审核");
							window.history.back(-1);
						}else{
							upload_info1.css('display',"block");
						}
					} 
				};  
				xhr.send(formData); 
			}else{
				upload_info1.css('display',"block");
			}
		})
    }
  //   function chooseImg() {
  //   	upload.css({
  //  			"background":"#f8a04b"
  //  		})
  //  		.attr("value","确认上传");
		// count = 1;
		// wx.chooseImage({
  //         success: function (res) {
  //           images.localId = res.localIds;
  //           container.attr("background",images.localId);
  //           container.css('background',"url(" + images.localId + ")");
  //           upload.css({
  //   			"background":"#f8a04b"
  //   		})
  //   		.attr("value","确认上传");
  //         },
  //         fail: function () {
  //         	console.log('fail');
  //         }
  //       });
  //   }
  //   function upload_to_wx (that) {
  //   	var that = that;
  //   	wx.uploadImage({
		// 	localId : images.localId,
		// 	success : function (res) {
		// 		upload_to_back(res);
		// 		upload_info1.animate({
		// 			"display": "block",
		// 		},200).html("<p>上传成功</p>");
		// 	}
		// })
		// $(that).css({
		// 	"background":"url(images/uploading.png) 50% 50% fixed no-repeat",
		// 	"background-size":"100% 100%"
		// });
		// $(that).attr("value","正在上传");
		// cover.animate({
		// 	"width":"100%",
		// 	"height":"100%"
		// },200);
		// upload_info1.animate({
		// 	"display": "block",
		// },200);
		
  //   }
  //    function upload_to_back (res) {
  //   	res_id = res.serverId;
  //   	$.post("",res_id,function (res) {
  //   		if(res){

  //   		}else{

  //   		}
  //   	})
  //   }
	//上传按钮点击后黑色透明背景出现以及上传信息提示
	upload.bind('touchend',function () {
		uploadImg();
	});
	//重新上传处理，上传成功的我没有写，和这差不多，根据后端传来的状态决定吧
	$(".refresh").bind("touchend",function () {
		reupload();
	});
	//点击关闭按钮是发生
	$(".close").bind("touchend",function () {
		close();
	});
	container.bind("touchend",function () {
		file.trigger("click");
	});
	file.bind("change",function () {
		chooseImg();
	})
	//功能实现后加载背景
	$("body").css({
		"background":"url(Public/images/bodybg3.png) 50% 0 no-repeat",
		"background-size":"100% 100%"
	});
});