<?php
namespace Home\Controller;
use Think\Controller;
class SmileController extends Controller {
   public function index(){
        $picUid = I('uid');
        $picId = '';
        $all = M('image')->select();
        for($i = 0; $i < count($all); $i++){
            if($all[$i]['uid'] == $picUid){
                $picId = $i + 1;
                break;
            }
        }
        $message = M('image')->where("uid=$picUid")->select();
        $message[0]['ID'] = $picId;
        $this->assign('message', $message);
        $this->display();
    }
    
    public function select(){
        $uid = I('post.uid');
        $where = [
            'uid' => $uid,
            ];
        if(M('image')->where($where)->select()){
            $this->ajaxReturn(true);
        }else{
            $this->ajaxReturn(false);
        }
    }

    private function get_top($stunum){    //获取排名
        $images = M('image')->order('vote')->select();
        $en = '';
        for($i = 0; $i < count($images); $i++){
            if($images[$i]['uid'] == $stunum){
                $en = $i;
                break;
            }
        }
        return $en;
    }

    public function vote(){
        $stuId = session('uid');
    	$picUid = I('post.uid');
    	if($picUid){
            $where = [
                'uid' => $stuId, 
                'vote_uid' => $picUid,
            ];
            if(M('vote')->where($where)->select()){
                $where = [
                    'uid' => $stuId, 
                    'vote_uid' => $picUid,
                ];
                $date = M('vote')->field('vote_day')->where($where)->select();
                if($date[0]['vote_day'] == date('d', time())){
                    $this->ajaxReturn(false);
                }else{
                    $save = [
                        'vote_day' => date('d', time()),
                    ];
                    M('vote')->where($where)->save($save);
                    $votes = M('image')->field('vote')->where("uid=$picUid")->select();
                    $vote = $votes[0]['vote'] + 1;
                    $save = [
                        'vote' => $vote,
                    ];
                    M('image')->where("uid=$picUid")->save($save);

                    $data = [
                        'vote' => $vote,
                        'top' => $this->get_top($picUid),
                    ];
                    $this->ajaxReturn($data, 'json');
                }
            }else{
                $add = [
                    'uid' => $stuId, 
                    'vote_uid' => $picUid,
                    'vote_day' => date('d', time()),
                ];
                M('vote')->add($add);
                $votes = M('image')->field('vote')->where("uid=$picUid")->select();
                $vote = $votes[0]['vote'] + 1;
                $save = [
                    'vote' => $vote,
                ];
                M('image')->where("uid=$picUid")->save($save);
                $data = [
                        'vote' => $vote,
                        'top' => $this->get_top($picUid),
                    ];
                $this->ajaxReturn($data, 'json');
            }
    	}else{
    		$this->ajaxReturn(false);
    	}
    }
}