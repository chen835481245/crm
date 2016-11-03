<?php
/**
 * 权限控制
 */
class acl
{
	public $cmd;
	function __construct($cmd='')
	{
		$this->cmd=$cmd;
	}
	/**
	 * 验签
	 */
	function signCheck($post)
	{
		$res=array();
		$str='';
		$str=substr($str, 1);
		if($this->cmd=='300001'||$this->cmd=='300002'||$this->cmd=='200001'){
			$isOk=$this->unionSignCheck($post);
		}else{
			//客户端
			$isOk=$this->clentSignCheck($post);
		}
		//验证
		if($isOk){
			$res[KEY_RETURN_CODE]=VAL_RETURN_CODE_SUCCESS;
			$res[KEY_RETURN_MSG]='success';
		}else{
			$res[KEY_RETURN_CODE]=VAL_RETURN_CODE_SIGN;
			$res[KEY_RETURN_MSG]='验证签名失败';
		}
		unset($str);
		return $res;
	}
	/**
	 * 客户端校验
	 */

	function clentSignCheck()
	{
		foreach ($post as $key =>$val){
			if($key!='sign'&&$key!='content'){
				$str.="&".$key."=".$val;
			}
		}
		$redisObj=new redisInit();
		$account=$post['account'];
		$redisKey=$redisObj->hget($account,NOSQL_USER_FIELD_RANDOMKEY);
		$GLOBALS['spConfig']['redisKey']=$redisKey;
		$signStr=md5($str.'&randomkey='.$redisKey);
		$sign=$post['sign'];
		if($sign==$signStr){
			$content=$_REQUEST['content'];
			$content=rc4($redisKey, $content);
			$GLOBALS['content']=json_decode($content,true);
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 银联校验
	 */
	function unionSignCheck()
	{
		$key=$GLOBALS['spConfig']['unionKey'];
		$sign=$post['sign'];
		$signStr=md5($str.$key);
	}










}