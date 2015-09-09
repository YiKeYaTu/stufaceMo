<?php
return array(
	
	//'SHOW_PAGE_TRACE' 		=>	true,			//页面Trace

	'DB_TYPE'               =>  'mysql',     	// 数据库类型
    'DB_HOST'               =>  'localhost', 	// 服务器地址
    'DB_NAME'               =>  'smileface',    // 数据库名
    'DB_USER'               =>  'root',      	// 用户名
    'DB_PWD'                =>  '111003qwertyuiop',          	// 密码
    'DB_PORT'               =>  '3306',        	// 端口
    'DB_CHARSET'            =>  'utf8',
	'DB_PREFIX'             =>  'tbl_',     	//设置表前缀

	'URL_MODEL'				=>  '0',

	'MODULE_ALLOW_LIST'    =>    array('Home','Admin'),
	'DEFAULT_MODULE'     	=>  'Home',
	
	'TMPL_L_DELIM'			=>	'<{',			//修改定界符
	'TMPL_R_DELIM'			=>	'}>',

	'TMPL_PARSE_STRING' 	=> 	array(
		//'__PUBLIC__' => '/Public', // 更改默认的/Public 替换规则
		//'__UPLOAD__' => 'localhost'.__ROOT__.'/Uploads', // 增加新的上传路径替换规则
	), 
);