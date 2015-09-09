<?php
namespace Home\Model;
use Think\Model;
	class UserModel extends Model{
		//protected $u = M('User');
		public function dologin(){
			$M = M('User');
			$data['uid']= I('post.username');
			$data['password'] = I('post.password');
			$res = $M->where($data)->find();
			$i=M('Image')->find();
			if($res){
				session('uid',$res['uid']);
				session('has_upload',$res['has_upload']);
				session('vote_day',$res['vote_day']);
				session('user_sex',$res['sex']);
				cookie('has_upload',$res['has_upload']);
				cookie('vote_day',$res['vote_day']);
				return true;
			}else{
				return false;
			}
		/*	session('user',I('post.username'));
			//$order = 'id';
			var_dump(I('session.user'));
			if(!empty($_POST))
				$begin = I('get.page') ? (I('get.page')-1)*12 : 0 ;
			$res = $M->where($data)->order(I('session.order'))->limit($begin,2)->select();
			return $res;
		*/
		}

		public function dologout(){
			session('uid',null);
			session('has_upload',null);
			session('vote_day',null);
			session('user_sex',null);
			cookie('has_upload',null);
			cookie('vote_day',null);
		}

		public function dovote(){
			//$vote_day = I('session.vote_day');
			$today = date('d',time());
    		$where['uid'] = I('session.uid');
    		$save['vote_day'] = $today;
    		$U = M('User')->where($where)->save($save);
			session('vote_day',$today);
		}

		public function test(){
			$this->u = M('User');
			$res = $this->u->find();
			var_dump($res);
		}

		public function adduser($data){
			$M = M('User');
			$where['uid'] = $data['userInfo']['stu_num'];
			$flag = $M->where($where)->find();
			if(!$flag){
				$save['uid'] = $data['userInfo']['stu_num'];
				$save['stu_name'] = $data['userInfo']['real_name'];
				if($data['userInfo']['gender'] == '男')
					$save['sex'] = 0;
				if($data['userInfo']['gender'] == '女')
					$save['sex'] = 1;
				$M->add($save);
			}	
		}

		public function save_in_User($uid,$info){
		    $M = M('User');
		    $where['uid'] = $uid;
			$res = $M->where($where)->find();
		   	if($res){
		   		$where['has_upload'] = 0;
		   		$res = $M->where($where)->find();
		   		if($res){
		   			$data['has_upload'] = 1;
					$data['sex'] = $info['sex'];
					$data['stu_name'] = $info['nickname'];
					$M->where("uid=$uid")->save($data);
		   		}
		   	}else{
		   		$data['has_upload'] = 1;
				$data['sex'] = $info['sex'];
				$data['stu_name'] = $info['nickname'];
				$data['uid'] = $uid;
				$M->add($data);
		   	}
			
		    
		}
/*		public function pariselover(){
			$picture_id = I('post.id');
			$where = [
				'id' => $picture_id,
			]
			$vote = M('Image')->field('vote')->where($where)->select();
			$save = [
				'vote' => $vote++,
			];
			if(M('Image')->where($where)->save($save)){
				$save = [
					'vote_day' => date('d', time()),
				];
				$where['uid'] = I('session.uid');
				M('user')->where($where)->save($save);
				return true;
			}else{
				return false;
			}
		}
*/
		public function user_select(){
			
				$student_num = I('get.search');
				$where = [
					'uid' => $student_num,
				];
				$url = M('image')->where($where)->select();
				if($url)
					return $url;
				else 
					return '该生还没有上场照片哦!';
			
		}

} 		
