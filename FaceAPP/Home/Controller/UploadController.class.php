<?php
namespace Home\Controller;
use Think\Controller;
class UploadController extends Controller {
    public function index(){
        $this->display();
    }

    public function upload(){
        if(session('uid') < 2016000000)
            $this->error('老腊肉不能上传照片哦');
    	$data = [
    		'uid' => session('uid'),
    		'sex' => session('sex'),
    		'form' => 'mobile',
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
                    'has_upload' => 0,
                    'vote_day' => 0,
                ];
                M('user')->add($add);
            }
    	$this->ajaxReturn($data);
    }
}      
//