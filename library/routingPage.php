<?php
/**
 * 路由转换
 */
function __autoload($class_name)
{
	$directorys = array(
            'library/',
            'controller/',
            'model/',
			'library/smarty/',
			'library/smarty/plugins/',
			'library/smarty/sysplugins/'
            );
            $i=0;
            foreach($directorys as $directory)
            {
            	$i++;
            	$class_name_low=strtolower($class_name);
            	if(file_exists($directory.$class_name . '.php'))
            	{
            		require_once($directory.$class_name . '.php');
            		return;
            	}else if (file_exists($directory.$class_name_low . '.php')){
            		require_once($directory.$class_name_low . '.php');
            		return;
            	}
            }
}
/**
 *
 * 路由方法
 */
function Run()
{
	$controller=trim($_REQUEST['c']);
	$action=trim($_REQUEST['a']);
	$controller=empty($controller)?$GLOBALS['spConfig']['default_page_controller']:$controller;
	$action=empty($action)?$GLOBALS['spConfig']['default_action']:$action;
	//路由转换
	$obj=new $controller();
	$obj->$action();
}

