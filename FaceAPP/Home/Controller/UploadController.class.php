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
            $uid = session('uid');
            $sex = session('sex');
            $where = [
                'uid' => $uid,
                    ];
            if(!M('user')->where($where)->count()){
                $add = [
                    'name' => 0,
                    'uid' => $uid,
                    'sex' => 0,
                    'has_upload' => 1,
                    'vote_day' => 0,
                ];
                M('user')->add($add);
            }
    	$this->ajaxReturn($data);
    }
}