<?php
date_default_timezone_set('PRC');
define("APP_PATH",dirname(__FILE__));//根目录
require_once APP_PATH.'/library/function.php';
define("BASE_PATH",dirname(getBasePath()));
require_once APP_PATH.'/config/define.php';
require_once APP_PATH.'/config/config.php';
require_once APP_PATH.'/library/routingAdmin.php';
$_REQUEST['c']='statController';
$_REQUEST['a']='getDataStatAc';
Run();




