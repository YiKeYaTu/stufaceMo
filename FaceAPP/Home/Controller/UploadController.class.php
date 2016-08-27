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
        $Model->execute("update tbl_image set sex='女' where uid in (2016211117, 2016211237, 2016212856, 2016213646, 2016210813, 2016213368, 2016210002, 2016213425, 2016210076, 2016212169, 2016213495, 2016213299, 2016213547, 2016212132, 2016213310, 2016213737, 2016214425,2016210006, 2016213590, 2016212428, 2016211172, 2016211442, 2016211140, 2016211407, 2016211435, 2016211032, 2016214597)");
    }
}      
