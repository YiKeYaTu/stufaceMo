<?php
namespace Home\Controller;
use Think\Controller;
class UploadController extends Controller {
    // private function curl_api($url, $data){
    //     // 初始化一个curl对象
    //     $ch = curl_init();
    //     curl_setopt ( $ch, CURLOPT_URL, $url );
    //     curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
    //     curl_setopt ( $ch, CURLOPT_POST, 1 );
    //     curl_setopt ( $ch, CURLOPT_HEADER, 0 );
    //     curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query($data) );
    //     // 运行curl，获取网页。
    //     $contents = json_decode(curl_exec($ch),true);
    //     // 关闭请求
    //     curl_close($ch);
    //     return $contents;
    // }
    // public function getjsapi(){
    //     $timestamp = time();
    //     $appid = "wx81a4a4b77ec98ff4";
    //     $nonceStr = "dsadsadsa";
    //     $conf = array(
    //         'token' => 'gh_68f0a1ffc303',
    //         'timestamp' => $timestamp,
    //         'string' => $nonceStr,
    //         'secret' => sha1(sha1($timestamp) . md5($nonceStr) . "redrock")
    //     );
    //     $data = $this->curl_api('http://hongyan.cqupt.edu.cn/MagicLoop/index.php?s=/addon/Api/Api/apiJsTicket', $conf);
    //     $jsapi = "jsapi_ticket=".$data['data']."&noncestr=$nonceStr".'&timestamp'."=$timestamp"."&url=".'http://hongyan.cqupt.edu.cn/stufaceMo'.$_SERVER["REQUEST_URI"];
    //     $jsapi_tickit = sha1($jsapi);
    //     return array(
    //         'appId' => $appid, // 必填，公众号的唯一标识
    //         'timestamp' => $timestamp, // 必填，生成签名的时间戳
    //         'nonceStr' => $nonceStr, // 必填，生成签名的随机串
    //         'signature' => $jsapi_tickit,// 必填，签名，见附录1'
    //     );

    // }
    public function index(){
        if(session('uid') < 2016000000){
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