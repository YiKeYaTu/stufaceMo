<?php
namespace Home\Controller;
use Think\Controller;
class UploadController extends Controller {
    public function index(){
        if(session('uid') < 2016000000){
            $this->error('老腊肉不能上传照片哦');
            return;
        }
        $this->display();
    }

    public function upload(){
    	$data = [
    		'uid' => session('uid'),
    		'sex' => session('sex'),
    		'form' => 'mobile',
    	];
            $uid = session('uid');
            $sex = session('sex');
            $name = session('name');
            $where = [
                'uid' => $uid,
            ];
            if(!M('user')->where($where)->count()){
                $add = [
                    'name' => $name,
                    'uid' => $uid,
                    'sex' => $sex,
                    'has_upload' => 0,
                    'vote_day' => 0,
                ];
                M('user')->add($add);
            }
    	$this->ajaxReturn($data);
    }
}      
//