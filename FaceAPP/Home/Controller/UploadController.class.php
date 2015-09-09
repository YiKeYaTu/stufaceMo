<?php
namespace Home\Controller;
use Think\Controller;
class UploadController extends Controller {
    public function index(){
        $this->display();
    }

    public function upload(){
    	$data = [
    		'uid' => session('uid'),
    		'sex' => session('sex'),
    		'post.form' => 'mobile',
    	];
    	$this->ajaxReturn($data);
    }
}