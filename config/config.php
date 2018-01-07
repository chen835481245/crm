<?php
$spConfig=array(
	'title'=>'管理后台',
	'url_path_base'=>'',
	'production'=>false,//false 测试     true上线
	'default_admin_controller'=>'loginController',//管理后台默认控制器
	'default_page_controller'=>'homeController',//主页默认控制器
	'default_action'=>'index',//管理后台默认操作

	'db' => array(  // 数据库连接配置
		'driver' => 'mysql',   // 驱动类型
		'persistent'=>false,
		'0'=>array(
		'driver' => 'mysql',   // 驱动类型
		'host' => '127.0.0.1', // 数据库地址
		'port' => 3306,        // 端口
		'login' => 'root',     // 用户名
		'password' => "",      // 密码
		'database' => 'keyword'
		)
	),
	'myUrl'=>'http://127.0.0.1',
);
session_start();