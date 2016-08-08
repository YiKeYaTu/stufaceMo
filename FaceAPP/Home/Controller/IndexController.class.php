<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    //不确定代码部分
    public function index(){

        $self = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

        $string = 'dsadsadsadsadsadsa';
        $time = time();
        $access = array(
                'token' => 'gh_68f0a1ffc303',
                'timestamp' => $time,
                'string' => $string,
                'secret' => sha1(sha1($time) . md5($string) . "redrock"),
                'openid' => $openid
        );

        $url =  "http://hongyan.cqupt.edu.cn/MagicLoop/index.php?s=/addon/Api/Api/apiJsTicket";
        $res3 = $this->curl_api($url, $access);

        $data = $res3['data'];
        $str = $access['string'];
        $timestamp = $access['timestamp'];

        var_dump($self);
        var_dump($res3);
        var_dump($str);
        var_dump($timestamp);

        $signature = sha1("jsapi_ticket=$data&noncestr=$str$&timestamp=$timestamp&url=$self");

        $access['appid'] = 'wx81a4a4b77ec98ff4';
        $access['signature'] = $signature;

        $this->assign('access', $access);

        if(session('uid') == null && session('openid') == null){
            if($_GET['code'] == null){
                $this->get_code();
                return;
            }else{
                $openid = $this->get_openid();
                session('openid', $openid);
            }
            if(session('uid') == null){

                
                $url = "http://hongyan.cqupt.edu.cn/MagicLoop/index.php?s=/addon/Api/Api/userInfo";
                $res1 = $this->curl_api($url, $access);
                $url =  "http://hongyan.cqupt.edu.cn/MagicLoop/index.php?s=/addon/Api/Api/bindVerify";
                $res2 = $this->curl_api($url, $access);
            

                if($res1 && $res2){
                    $stuId = $res2['stuId'];
                    $stuSex = $res1['sex'] ? "女" : "男";
                    session('uid', $stuId);
                    session('sex', $stuSex);
                    $this->display();
                }else{
                    $this->error('你还没有绑定小帮手哦');
                }
            }
        }else{
            $this->display();
        }
    }
    //不确定代码部分
    private function get_openid(){
        $code = $_GET['code'];
        $appid = "wx81a4a4b77ec98ff4";
        $appsecret = "872a908ec98bd92f8db811eba2a83236";
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
        $res = $this->curl_api($url);
        return $res['openid'];
    }

    private function get_code(){
        $source = 'http://hongyan.cqupt.edu.cn/BookApi/index.php?s=/Home/Index/';
        $appid = 'wx81a4a4b77ec98ff4';
        $token = 'gh_68f0a1ffc303';
        $redirect = urlencode("http://stufacemo.lot.cat");
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect&response_type=code&scope=snsapi_base&state=123#wechat_redirect";

        header("location: $url");

    }
    //auth2 获取openid

    private function curl_api($url, $data){
        // 初始化一个curl对象
        $ch = curl_init();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query($data) );
        // 运行curl，获取网页。
        $contents = json_decode(curl_exec($ch),true);
        // 关闭请求
        curl_close($ch);
        return $contents;
    }

    public function showpic(){
        $time = I('post.time');
        $group = I('post.group');
        $sex = I('post.sex');
        // $time = I('get.time') ? I('get.time') : "1"; //下滑的次数
        // $group = I('get.group') ? I('get.group') : "综合";  //分类
        // $sex = I('get.sex') ? I('get.sex') : "综合"; //男女   
        if($group == '综合' || $group == '最新'){
            if($sex == '全部'){
                $where = [
                    'is_pass' => 1,
                ];
                $allmessage = M('image')->where($where)->order('time')->select();
                krsort($allmessage);
                $message = array_slice($allmessage, $time * 6, 6);


                    //查询登录人信息
                $this->ajaxReturn($message, 'json');
            }else if($sex == '汉子'){
                $where = [
                    'is_pass' => 1,
                    'sex' => '男',
                ];
                $allmessage = M('image')->where($where)->order('time')->select();
                krsort($allmessage);
                $message = array_slice($allmessage, $time * 6, 6);
                $this->ajaxReturn($message, 'json');
            }else if($sex == '妹子'){
                $where = [
                    'is_pass' => 1,
                    'sex' => '女',
                ];
                $allmessage = M('image')->where($where)->order('time')->select();
                krsort($allmessage);
                $message = array_slice($allmessage, $time * 6, 6);
                $this->ajaxReturn($message, 'json');
            }
        }else if($group == '人气'){
            if($sex == '全部'){
                $allmessage = M('image')->order('vote')->select();
                krsort($allmessage);
                $message = array_slice($allmessage, $time * 6, 6);
                $this->ajaxReturn($message, 'json');
            }else if($sex == '汉子'){
                $where = [
                    'is_pass' => 1,
                    'sex' => '男',
                ];
                $allmessage = M('image')->where($where)->order('vote')->select();
                krsort($allmessage);
                $message = array_slice($allmessage, $time * 6, 6);
                $this->ajaxReturn($message, 'json');
            }else if($sex == '妹子'){
                $where = [
                    'is_pass' => 1,
                    'sex' => '女',
                ];
                $allmessage = M('image')->where($where)->order('vote')->select();
                krsort($allmessage);
                $message = array_slice($allmessage, $time * 6, 6);
                $this->ajaxReturn($message, 'json');
            }
        }
    } 
    //图片显示接口
    // public function(){

    // }
}



