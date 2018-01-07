<?php
class spController
{
	/**
	 * 视图对象
	 */
	public $v;
	
	/**
	 * 赋值到模板的变量
	 */
	private $__template_vals = array();
	
	function __construct()
	{
		$this->v = new Smarty;
		$this->v->force_compile = true;
		$this->v->debugging = false;
		$this->v->caching = false;
		$this->v->cache_lifetime = 120;
		$this->v->registerPlugin('function','spUrl','spUrlView');
		$this->basePath= '.';//BASE_PATH;//项目的根目录
		$this->title=$GLOBALS['spConfig']['title'];
		$this->userInfo=json_encode($_SESSION['userInfo']); 
		$pub=new pub();
		$this->qxRescode=$pub->getQxRescode();
	}
	/**
	 * 渲染到页面 
	 */
	function display($path)
	{
		$this->v->display($path);
	}
	/**
	 * 魔术函数，获取赋值作为模板内变量
	 */
	public function __set($name, $value)
	{
		$this->v->assign($name,$value);
		$this->__template_vals[$name] = $value;
	}
	public function jumpUrl($url,$res,$param=array())
	{
		if(!empty($param)){
			foreach ($param as $key=>$val){
				$url.="&".$key."=".$val;
			}
		}
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		echo "<script type='text/javascript'>alert('".$res['msg']."');document.location.href=('".$url."');</script>";
		exit;
	}
	public function returnMsg($flag)
	{
		if($flag){
			$res['success']=true;
			$res['msg']='操作成功';
		}else{
			$res['success']=false;
			$res['msg']='操作失败';
		}
		return $res;
	}
}

