<?php
class pwd extends spModel
{
	public function addTypeList($is_gw=0)
	{
		$result=array();
		$data=array();
		$page=$_REQUEST['page'];
		if (!is_numeric($page) || $page <= 0)
		{
			$page = 1;
		}
		$pagesize = 20;
		$start = ($page - 1) * $pagesize;

		$sql="SELECT * from pwd_type LIMIT $start,$pagesize";

		$sqlNum="select count(1) num from pwd_type";
			
		$data=$this->getAll($sql);
		$result['data']=$data;
		$total=intval($numRes['num']);
		$linkUrl=spUrl('pwdController','addTypeListAc');
		$result['linkBar'] = multi($total, $pagesize, $page, $linkUrl);
		return $result;
	}
	function getTypes()
	{
		$sql="select id,`name` from pwd_type";
		return $this->getArray($sql,1);
	}
	function getUserArr($owners)
	{
		$sql="select operid,`name` from admin_user where valid=1";
		$data=$this->getAll($sql);
		if(!empty($owners)){
			foreach ($data as $key=>$val){
				$data[$key]['check']=in_array($val['operid'], $owners);
			}
		}
		return $data;
	}
	function doAddPwd()
	{
		$id=$_POST['id'];
		$row=$_POST;
		if($id==''){
			$row['datetime']=date("Y-m-d H:i:s");
			$row['operid']=$_SESSION['opid'];
			$flag=$this->table('pwd_recode')->create($row);	
			$this->addOwner($_POST['str'], $flag);
		}else{
			$row['datetime']=date("Y-m-d H:i:s");
			$row['operid']=$_SESSION['opid'];
			$flag=$this->table('pwd_recode')->update(array('id'=>$id), $row);	
			$this->addOwner($_POST['str'], $id);
		}
		return $flag;
	}
	function addOwner($str,$recode_id)
	{
		$this->table('pwd_owner')->delete(array('recode_id'=>$recode_id));
		$arr=explode(',', $str);
		$sql="insert into pwd_owner(`operid`,`recode_id`)  values";
		$str='';
		foreach ($arr as $key=>$val){
			$str.=",('$val',$recode_id)";
		}
		$str=substr($str, 1);
		$sql.=$str;
		$flag=$this->exec($sql);
		return $flag;
	}
	function pwdList()
	{
		$result=array();
		$data=array();
		$page=$_REQUEST['page'];
		if (!is_numeric($page) || $page <= 0)
		{
			$page = 1;
		}
		$pagesize = 20;
		$start = ($page - 1) * $pagesize;
		
		$search=$_REQUEST['search'];
		$search_sql=$search==''?'':" and (t1.username='$search' or t1.url like 
		'%$search%' or t1.remark like '%$search%')";
		
		if($_SESSION['level']>2){
			$sql="select t1.* from pwd_recode t1
			where  1=1  $search_sql  LIMIT $start,$pagesize";
			
			$sqlNum="select count(1) num from pwd_recode t1 where 
			1=1  $search_sql ";
			
		}else{
			$operid=$_SESSION['opid'];
			$sql="SELECT t1.* from pwd_recode t1,pwd_owner t2 WHERE  
			t1.id=t2.recode_id and t2.operid='$operid' $search_sql LIMIT $start,$pagesize";
			
			$sqlNum="SELECT count(1) num from pwd_recode t1,pwd_owner t2 WHERE  
			t1.id=t2.recode_id and t2.operid='$operid' $search_sql";
		}

		
		
		//LEFT JOIN pwd_type t2 ON t1.type_id=t2.id LEFT JOIN admin_user t3 ON t3.operid=t1.operid
		$sql_type="select id,name from pwd_type";
		$types=$this->getArray($sql_type,1);
		$sql_oper="select operid,name from admin_user";
		$opernames=$this->getArray($sql_oper,1);
		
		
		$sql1="select t1.recode_id,t2.`name` from pwd_owner t1,admin_user t2 where t1.operid=t2.operid";
		$owners=$this->getAll($sql1);
		$ownArr=array();
		foreach ($owners as $key=>$val){
			$ownArr[$val['recode_id']][]=$val;
		}

		
			
		$data=$this->getAll($sql);
		foreach ($data as $key=>$val){
			$data[$key]['datetime']=date("Y-m-d",strtotime($val['datetime']));
			$data[$key]['type_name']=$types[$val['type_id']];
			$data[$key]['opername']=$opernames[$val['operid']];
		}
		$numRes=$this->getOne($sqlNum);
		$result['data']=$data;
		$result['ownArr']=$ownArr;
		$total=intval($numRes['num']);
		$linkUrl=spUrl('pwdController','pwdListAc');
		$linkUrl.="&search=".$search;
		$result['linkBar'] = multi($total, $pagesize, $page, $linkUrl);
		return $result;

	}








}