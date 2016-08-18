<?php
namespace Home\Controller;
use Think\Controller;
class SmileController extends Controller {
    public function getjsapi(){
        $timestamp = time();
        $appid = "wx81a4a4b77ec98ff4";
        $nonceStr = "dsadsadsa";
        $conf = array(
            'token' => 'gh_68f0a1ffc303',
            'timestamp' => $timestamp,
            'string' => $nonceStr,
            'secret' => sha1(sha1($timestamp) . md5($nonceStr) . "redrock")
        );
        $data = $this->curl_api('http://hongyan.cqupt.edu.cn/MagicLoop/index.php?s=/addon/Api/Api/apiJsTicket', $conf);
        $jsapi = "jsapi_ticket=".$data['data']."&noncestr=$nonceStr".'&timestamp'."=$timestamp"."&url=".'http://hongyan.cqupt.edu.cn/stufaceMo'.$_SERVER["REQUEST_URI"];
        $jsapi_tickit = sha1($jsapi);
        return array(
            'appId' => $appid, // 必填，公众号的唯一标识
            'timestamp' => $timestamp, // 必填，生成签名的时间戳
            'nonceStr' => $nonceStr, // 必填，生成签名的随机串
            'signature' => $jsapi_tickit,// 必填，签名，见附录1'
        );

    }
    public function index(){
        if($picUid = I('uid')){
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
            $where = [
                'uid' => $picUid,
            ];
            $vote = M('image')->where($where)->getField('vote');
            $where = [
                'vote' => ['gt', $vote],
            ];
            $top = M('image')->where($where)->count() + 1;
            $this->assign('message', $message);
            $this->assign('top', $top);
            $data = $this->getjsapi();
            $this->assign('jsapi', $data);
            $this->display();
        }else if($id = I('id')){
            $where = [
                'id' => $id,
            ];
            if($message = M('image')->where($where)->select()){
                $message[0]['ID'] = $id;
                $vote = M('image')->where($where)->getField('vote');
                $where = [
                    'vote' => ['gt', $vote],
                ];
                $top = M('image')->where($where)->count() + 1;
                $this->assign('message', $message);
                $this->assign('top', $top);
                $data = $this->getjsapi();
                $this->assign('jsapi', $data);
                $this->display();
            }else{
                $this->error('没有这张照片');
            }
        }
    }

    public function select(){
        $id = I('post.id');
        $where = [
            'id' => $id,
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
            if(!$stuId){
                $this->ajaxReturn(2);
                return;
            }
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