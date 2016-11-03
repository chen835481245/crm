<?php
$spConfig=array(
	'url_path_base'=>'',
	'production'=>$production,//false 测试     true上线
	'default_controller'=>'loginController',//默认控制器
	'default_action'=>'index',//默认操作
	'db' => array(  // 数据库连接配置
		'driver' => 'mysql',   // 驱动类型
		'persistent'=>false,
		'0'=>array(
		'driver' => 'mysql',   // 驱动类型
		'host' => '192.168.0.34', // 数据库地址
		'port' => 3306,        // 端口
		'login' => 'ptmc_m',     // 用户名
		'password' => "1qazxsw23edc",      // 密码
		'database' => 'ptmc'
		)
	),
	'myUrl'=>'http://127.0.0.1',
);