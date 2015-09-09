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
	<div class="row">
		<div class="col-md-offset-3" style="width:600px; height: 450px; margin-top: 100px; margin-bottom: 70px; border: 2px solid #0000FF; background-size:cover" id="showpic"></div>
		</div>
		<div class="row">
			<form role="form" method="post" action="<?php echo U('Uploadpic/upload');;?>"  enctype="multipart/form-data">
	  			<div class="form-group col-md-3 col-md-offset-1">
	    			<input type="text" name="stunum" class="form-control" placeholder="学号"></input>
	  			</div>
	  			<div class="form-group col-md-2 col-md-offset-1">
	    			<input type="text" name="sex" class="form-control" placeholder="性别"></input>
	  			</div>
	  			<div class="form-group col-md-3 col-md-offset-1">
	    			<input type="text" name="name" class="form-control" placeholder="名字"></input>
	  			</div>
	  			<div class="form-group col-md-1 col-md-offset-5">
	    			<input type="file" name="picture" id="pic">
	  			</div>
	        <div class="form-group col-md-1 col-md-offset-5">
	          <input type="submit" class="btn btn-success">
	        </div>
			</form>   
	    <button class="btn btn-info" id="show">点击预览</button> 
		</div>
	</div>
	<script type="text/javascript">
	var show = document.getElementById('show');
	show.onclick = function(){
	  var p = document.getElementById('pic');
	  var sp = document.getElementById('showpic');
	  var url = window.URL.createObjectURL(p.files[0]);
	  sp.style.backgroundImage = "url('"+url+"')";
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