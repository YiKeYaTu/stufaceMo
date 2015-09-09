<?php
	function doupload($this){
		$upload = new \Think\Upload();                      // 实例化上传类
        $upload->maxSize = 3145728;                         // 设置附件上传大小
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型
        $upload->rootPath = './Public/upimage/';            // 设置附件上传根目录
        $upload->autoSub = false;
        $upload->savePath = ''; 
        if(session('uid')){                      //学生上传单张照片
            $upload->saveName = time().'_'.session('uid');              // 设置上传文件名
            
            $info = $upload->uploadOne($_FILES['photo']);       //执行上传方法
            
            if(!$info) {                                       // 上传错误提示错误信息
                $this->error($upload->getError());
            }else{                                              // 上传成功 获取上传文件信息
                return './Public/upimage/'.$info['savename'];
                }
        }else{                                                  //后台管理员批量上传照片
            $info = $upload->upload($_FILES['photo']);      
                if(!$info) {                                       // 上传错误提示错误信息
                $this->error($upload->getError());
            }else{                                              // 上传成功 获取上传文件信息
                return $info;
            } 
        }

        
    }

        

    function dothumb($picpath){
    	$arr = explode('/', $picpath);
    	$filename = array_pop($arr);
        $big_name = get_big_name($filename);
        $imginfo = getImageSize($picpath);
        $imgw = $imginfo [0];     
        $imgh = $imginfo [1];
    	$image = new \Think\Image();
        $image->open($picpath);
        $image->save('./Public/allimage/'.$big_name);
        $image->thumb(300, 300,\Think\Image::IMAGE_THUMB_SCALE)->save('./Public/allimage/'.$filename);
        unlink($picpath);
	    return $filename;
    }

    function savepic($filename){
        $picpath = './Public/upimage/'.$filename;
        $image = new \Think\Image();
        $image->open('./Public/upimage/'.$filename);
        $image->save('./Public/allimage/'.$filename);
        unlink($filename);
       
    }

    function get_big_name($filename){
        $arr = explode('.', $filename);
        $big_name = $arr[0].'_big.'.$arr[1];
        return $big_name; 
    }

    function get_uid($filename){
        $arr = explode('_', $filename);
        $a = $arr[1];
        $array = explode('.',$a);
        $uid = $array[0];
        return $uid;
    }

    function log_result(){
        $url = "http://hongyan.cqupt.edu.cn/RedCenter/Api/Handle/login";
        $post_data = array(
            'user' => I('post.username'),
            'password' => I('post.password'),
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        $data = json_decode ($output,true);
        return $data;
    }
    
    function curl_pic(){
        $access_token = 'gh_68f0a1ffc303';
        $media_id = I('post.media_id');
        $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=$access_token&media_id=$media_id";
        $local = './Public/allimage/'.date("Ymdhis").".jpg";
        $cp = curl_init($url);
        $fp = fopen($local,"w");
        curl_setopt($cp, CURLOPT_FILE, $fp);
        curl_setopt($cp, CURLOPT_HEADER, 0);
        curl_exec($cp);
        curl_close($cp);
        fclose($fp);
        $arr = explode('/', $local);
        $filename = array_pop($arr);
        return $filename;
    }

    function curl_uid(){
        $url = 'http://hongyan.cqupt.edu.cn/MagicLoop/index.php?s=/addon/Api/Api/bindVerify';
        //$data['openid'] = I('post.openid');
        $data['openid'] = I('post.openid');
        $data['token'] = 'gh_68f0a1ffc303';
        $data['timestamp'] = time();
        $data['string'] = 'asdfghyjuikl';
        $data['secret'] =  sha1(sha1($data['timestamp']).md5($data['string'])."redrock");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        $d = json_decode($data,true);
        $uid = $d['stuId'];
        var_dump($uid);
        //return $uid;
    }

    function curl_info(){
        $url = 'http://hongyan.cqupt.edu.cn/MagicLoop/index.php?s=/addon/Api/Api/userInfo';
        $data['openid'] = I('post.openid');
        //$data['openid'] = 'asdfgthyjuiklosadfbeuya';
        $data['token'] = 'gh_68f0a1ffc303';
        $data['timestamp'] = time();
        $data['string'] = 'asdfghyjuikl';
        $data['secret'] =  sha1(sha1($data['timestamp']).md5($data['string'])."redrock");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        $info = json_decode($data,true);
        if($info['sex']==1)
            $info['sex']='男';
        else
            $info['sex']='女';
        //var_dump($info);
        return $info;
    }

    function myFun($uid) {
        
        return $uid;
    }
