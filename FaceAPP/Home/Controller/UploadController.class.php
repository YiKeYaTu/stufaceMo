<?php
namespace Home\Controller;
use Think\Controller;
class UploadController extends Controller {
    public function index(){
        if(session('uid') >=2015000000 ){
            $this->display();
        }else{
            $this->error('老腊肉不能上传照片哦-_-|');
        }
    }

    public function upload(){
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