<?php
namespace Home\Model;
use Think\Model;
	class ImageModel extends Model{
		public function addpic($filename){
			$M = M('Image');
			$big_name = get_big_name($filename);
			$data['pic'] = $filename;
			$data['big_pic'] = $big_name;
			$data['uid'] = I('session.uid');
			$data['time'] = date('Y-m-d H:i:s',time());
			if(I('session.user_sex') != null)
				$data['sex'] = I('session.user_sex');
			if(I('post.phone') != null){
				$save['phone'] = I('post.phone');
				$where['uid'] = $uid;
				M('User')->where($where)->save($save);
			}
			$M->add($data);
		}
		
		public function dovote(){
			$where['uid'] = I('post.uid');
			$a = M('Image')->where($where)->field('vote')->select();
			$data['vote'] = $a[0]['vote'] + 1;
			M('Image')->where($where)->save($data);
		}


		
		public function showpic(){
			if(I('get.limit') == '最新')
	        	session('order','time desc');
		    if(I('get.limit') == '人气')
		        session('order','vote desc');
		    if(I('get.limit') == '综合')
		       	session('order',null);
			if(I('get.sex') == '妹子') 
		        session('sex','女');
		    if(I('get.sex') == '汉子') 
		        session('sex','男');
		    if(I('get.sex') == '全部') 
		        session('sex',null);  
		    
			if(I('session.sex')!=null)   
				$data['sex'] = I('session.sex');
		    $order = I('session.order');
		    if(I('get.search')!=null){
		    	$data = null;
		    	$order = null;
		    	$data['id'] = I('get.search');
		    }
			$begin = I('post.btn') ? (I('post.btn')-1)*12 : 0 ;
			$data['is_pass'] = 1;
	        $res = M('Image')->where($data)->order($order)->limit($begin,12)->select();
	        return $res;
	    }
		
	    

		public function getpage(){
			if(I('get.limit') == '最新')
	        	session('order','time desc');
		    if(I('get.limit') == '人气')
		        session('order','vote desc');
		    if(I('get.limit') == '综合')
		       	session('order',null);
			if(I('get.sex') == '妹子') 
		        session('sex',1);
		    if(I('get.sex') == '汉子') 
		        session('sex',0);
		    if(I('get.sex') == '全部') 
		        session('sex',null);  
		    
			if(I('session.sex')!=null)
		        $data['sex'] = I('session.sex');
			$order = I('session.order');
			$data['is_pass'] = 1;
			$count = M('Image')->where($data)->order($order)->count("id");
			$page = ceil($count/12);
			if(I('get.search')!=null)
				return 1;
			return $page;
		}

		function save_in_Image($uid,$pic,$info){
			$M = M('Image');
			$where['uid'] = $uid;
			$res = $M->where($where)->find();
			if(!$res){
				$data['uid'] = $uid;
				$data['pic'] = $pic;
				$data['big_pic'] = $pic;
				$data['time'] = date('Y-m-d H:i:s',time());
				$data['sex'] = $info['sex'];
				$M->add($data);
			}
		}


	} 