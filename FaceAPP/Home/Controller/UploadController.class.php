<?php
namespace Home\Controller;
use Think\Controller;
class UploadController extends Controller {
    public function index(){
        if(session('uid') < 2014000000){
            $this->error('老腊肉不能上传照片哦');
            return;
        }
        // $data = $this->getjsapi();
        // $this->assign('jsapi', $data);
        $this->display();
    }

    public function upload(){
    	$data = [
    		'uid' => session('uid'),
    		'sex' => urldecode(session('sex')),
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

    public function changesex(){
        $Model = new \Think\Model();
        $Model->execute("update tbl_image set sex='女' where id in (131, 132, 125)");
    }
}      
