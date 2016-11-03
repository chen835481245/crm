<?php
class base extends spModel
{
	public function sourceList()
	{
		$result=array();
		$page=$_REQUEST['page'];
		if (!is_numeric($page) || $page <= 0)
		{
			$page = 1;
		}
		$pagesize = 20;
		$start = ($page - 1) * $pagesize;
		
		$sql="select * from client_source where 1=1  LIMIT $start,$pagesize";
		$sqlNum="select count(1) num from client_source where 1=1   ";
		$data=$this->getAll($sql);
		$result['data']=$data;
		$numRes=$this->getOne($sqlNum);
		$total=$numRes['num'];
		$linkUrl=spUrl('gnclientController','sourceListAc');
		$result['linkBar'] = multi($total, $pagesize, $page, $linkUrl);
		return $result;
	}
	public function typeList()
	{
		$result=array();
		$page=$_REQUEST['page'];
		if (!is_numeric($page) || $page <= 0)
		{
			$page = 1;
		}
		$pagesize = 20;
		$start = ($page - 1) * $pagesize;
		
		$sql="select * from client_type where 1=1   LIMIT $start,$pagesize";
		$sqlNum="select count(1) num from client_type where 1=1   ";
		$data=$this->getAll($sql);
		$result['data']=$data;
		$numRes=$this->getOne($sqlNum);
		$total=$numRes['num'];
		$linkUrl=spUrl('gnclientController','typeListAc');
		$result['linkBar'] = multi($total, $pagesize, $page, $linkUrl);
		return $result;
	}
	function toolList()
	{
		$result=array();
		$page=$_REQUEST['page'];
		if (!is_numeric($page) || $page <= 0)
		{
			$page = 1;
		}
		$pagesize = 20;
		$start = ($page - 1) * $pagesize;
		
		$sql="select * from client_tool where 1=1   LIMIT $start,$pagesize";
		$sqlNum="select count(1) num from client_tool where 1=1   ";
		$data=$this->getAll($sql);
		$result['data']=$data;
		$numRes=$this->getOne($sqlNum);
		$total=$numRes['num'];
		$linkUrl=spUrl('baseController','toolListAc');
		$result['linkBar'] = multi($total, $pagesize, $page, $linkUrl);
		return $result;
	}
	function getClientMsg()
	{
		$sql="select id,CONCAT(first_name,'_',last_name,'_', mail) as name,clientname,
		username,suoyq from client where 1  order by id desc";
		
		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}