<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
  <meta charest="utf-8">
  <title>后台管理系统</title>
	<link href="/face/Public/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" href="<?php echo U('Index/index');?>">管理系统</a>
      </div>
      <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
	      <li><a href="<?php echo U('Check/index');?>">照片审核</a></li>
        <li><a href="<?php echo U('Uploadpic/index');?>">照片上传</a></li>
	      <li><a href="<?php echo U('Home/Index/index');?>">笑脸迎新网</a></li>
	    </ul>
      <ul class="nav navbar-nav navbar-right">
        <li>
          <a href="#" data-toggle="modal" data-target=".bs-modal-signUp1" id="sub">
          <?php  if(session('manager')){ echo "退出"; echo "<script>
                    var sub = document.getElementById('sub');
                    sub.onclick = function(){
                      window.location.href='".U('Index/logout')."';
                      sub.childNodes == '登陆';
                    }     
                    </script>"; }else{ echo "登陆"; } ?>
          </a>
        </li>
        <div class="modal fade bs-modal-signUp1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <h4 class="modal-title">Login</h4>
            </div>
            <div class="modal-body">
              <div class="form-horizontal" role="form">
                <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="manager" placeholder="Your Name">
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" id="password" placeholder="Password">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default" id="login">login</button>
              </div>
            </div>
          </div>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div>
      </ul>
    </div>
  </div>
</div>













<div class="container">
	<div style="width: 250px;height: 600px; position: absolute; left: 80%; top:70px;overflow:scroll">
		<ul class="list-group">
			<?php
 foreach ($noPassers as $key) { ?>
		    <li class="list-group-item"><a onclick="showpic(this)" href="#" title="<?php echo $key['uid'] ?>" name="<?php echo $key['pic'] ?>"><?php echo $key['uid'].": ".$key['time'] ?></a></li>
		    <?php
 } ?>
		</ul>
	</div>
	<div class="row">
		<div class="col-md-offset-3" style="width:600px; height: 450px; margin-top: 100px; margin-bottom: 70px; border: 2px solid #0000FF; background-size: cover;" id="showpic"></div>
		</div>
		<button class="col-md-1 col-md-offset-4 btn btn-success" id="pass">通过</button>
		<button class="col-md-1 col-md-offset-2 btn btn-danger" id="delete">删除</button>
	</div>
</div>
<script>
	function showpic(pic){
		var show = document.getElementById('showpic');
		url = "/face/Public/allimage/" + pic.name;
		show.style.backgroundImage = "url('"+url+"')"; 
		var id = pic.title;
		show.title = id;
	}

	var pass = document.getElementById('pass');
	pass.onclick = function(){
		var id = document.getElementById('showpic').title;
		if(id){
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "<?php echo U('Check/pass');?>");
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send('stunum='+id);
			xhr.onload = function(){
				if(xhr.responseText){
					alert("pass! 已可以在主页显示");
					window.location.href = "<?php echo U('Check/index');?>";
				}else{
					alert("通过失败");
				}
			}
		}else{
			alert("请先选择照片");
		}
	}
	var del = document.getElementById('delete');
	del.onclick = function(){
		var id = document.getElementById('showpic').title;
		if(id){
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "<?php echo U('Check/delete');?>");
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send('stunum='+id);
			xhr.onload = function(){
				if(xhr.responseText){
					alert("已从数据库删除");
					window.location.href = "<?php echo U('Check/index');?>";
				}else{
					alert("通过失败");
				}
			}
		}else{
			alert("请先选择照片");
		}
	} 
</script>
<script src="/face/Public/js/jquery-1.11.1.min.js"></script>
<script src="/face/Public/js/bootstrap.min.js"></script>
<script type="text/javascript">
	var login = document.getElementById('login');
	login.onclick = function(){
		var manager = document.getElementById("manager").value;
		var password = document.getElementById("password").value;
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "<?php echo U('Index/login');?>");
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send('manager='+manager+'&password='+password);
		xhr.onload = function(){
			if(xhr.responseText){
				window.location.href = "<?php echo U('Index/index');?>";
			}else{
				alert("验证失败");
			}
		}
	}
</script>
</body>
</html>