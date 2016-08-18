<?php
namespace Home\Controller;
use Think\Controller;
class UploadController extends Controller {
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