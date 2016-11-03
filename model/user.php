<?php
/**
 * 系统权限方法
 */
class user extends spModel
{
	/*
	 * 操作员列表
	 */
	function userList()
	{
		$result=array();
		$page=$_REQUEST['page'];
		if (!is_numeric($page) || $page <= 0)
		{
			$page = 1;
		}
		$pagesize = RETURN_NUM;
		$start = ($page - 1) * $pagesize;
		$end=$page*$pagesize;
		if($_SESSION['level']<3){
			$operid=$_SESSION['opid'];
			$operidSql=" and t1.operid='$operid'";
		}
		$sql="SELECT t1.name,t1.operid,t2.dept_name,t3.role_name from admin_user t1,admin_dept t2,admin_role t3 
		WHERE t1.deptid=t2.deptid and t1.roleid=t3.roleid and t1.valid=1 $operidSql LIMIT $start,$pagesize";
		$sqlNum="select count(1) num from admin_user t1 where 1=1 and t1.valid=1";
		$result['data']=$this->getAll($sql);
		$numRes=$this->getOne($sqlNum);
		$total=$numRes['num'];
		$linkUrl=spUrl('userController','userListAc');
		$result['linkBar'] = multi($total, $pagesize, $page, $linkUrl);
		return $result;
	}
	/*
	 * 得到角色列表
	 */
	function getRoles()
	{
		$data=array();
		$sql="select roleid,role_name from admin_role";
		$data=$this->getArray($sql);
		return $data;
	}
	/*
	 * 执行新增操作员
	 */
	function douserAdd()
	{
		$result=array();
		$operid=trim($_POST['operid']);
		$deptid=trim($_POST['deptid']);
		$password=md5($_POST['password']);
		$roleid=trim($_POST['roleid']);
		$name=trim($_POST['name']);
		$sqlOk="select count(1) num from admin_user where operid='$operid'";
		$isOkArr=$this->getOne($sqlOk);
		if($isOkArr['num']>0){
			$result['success']=false;
			$result['msg']='已存在该操作员编号，请更换！';
			return $result;
		}else{
			$rdate=date("Y-m-d H:i:s");
			$row=array('operid'=>$operid,'deptid'=>$deptid,'rdate'=>$rdate,'password'=>$password,'roleid'=>$roleid,'name'=>$name,'valid'=>1);
			$this->tbl_name='admin_user';
			$this->create($row);
		}
		$result['success']=true;
		$result['msg']='操作成功！';
		return $result;
	}
	/*
	 * 删除操作员
	 */
	function douserDelete()
	{
		$result=array();
		$operid=trim($_REQUEST['operid']);
		if($operid==''){
			$result['success']=false;
			$result['msg']='操作员编号为空，请联系管理员';
			return $result;
		}
		$sql="update admin_user set valid=0 where operid='$operid'";
		$flag=$this->exec($sql);
		if(!$flag){
			$result['success']=false;
			$result['msg']='删除操作员失败';
		}else{
			$result['success']=true;
			$result['msg']='删除成功！';
		}
		return $result;
	}
	/*
	 * 得到一个操作员信息
	 */
	function getOneuser()
	{
		$operid=$_REQUEST['operid'];
		$sql="select * from admin_user where operid='$operid'";
		$data=$this->getOne($sql);
		return $data;
	}
	//修改操作员
	function douserUpdate()
	{
		$result=array();
		$operid=trim($_POST['operid']);
		$deptid=trim($_POST['deptid']);
		$password=md5($_POST['password']);
		$roleid=trim($_POST['roleid']);
		$name=trim($_POST['name']);
		$sql="update admin_user set deptid='$deptid' ,roleid='$roleid',name='$name' where operid='$operid'";
		$flag=$this->exec($sql);
		if(!$flag){
			$result['success']=false;
			$result['msg']='修改操作员信息失败';
		}else{
			$result['success']=true;
			$result['msg']='操作成功！';
		}
		return $result;
	}
	//修改密码
	function douserChangePwd()
	{
		$result=array();
		$operid=trim($_POST['operid']);
		$newpassword=md5($_POST['newpassword']);
		$sql="update admin_user set password='$newpassword' where operid='$operid'";
		$flag=$this->exec($sql);
		if(!$flag){
			$result['success']=false;
			$result['msg']='修改密码失败';
		}else{
			$result['success']=true;
			$result['msg']='修改密码成功！';
		}
		return $result;
	}
	function getUserArr()
	{
		$sql="select operid,`name` from admin_user where valid=1";
		$data=$this->getArray($sql,1);
		return $data;
	}
	/**
	 * --------------------------------------------------部门管理----------------------------------------------------------
	 */
	//部门列表
	function deptList()
	{
		$result=array();
		$page=$_REQUEST['page'];
		if (!is_numeric($page) || $page <= 0)
		{
			$page = 1;
		}
		$pagesize = RETURN_NUM;
		$start = ($page - 1) * $pagesize;
		$end=$page*$pagesize;
		
		$sql="select t1.deptid,t1.dept_name,t1.remark
		from admin_dept t1   LIMIT $start,$pagesize";
		
		$data=$this->getAll($sql);
		$sqlNum="select count(1) num from admin_dept where 1=1";
		$result['data']=$this->getAll($sql);
		$numRes=$this->getOne($sqlNum);
		$total=$numRes['num'];
		$linkUrl=spUrl('userController','deptListAc');
		$result['linkBar'] = multi($total, $pagesize, $page, $linkUrl);
		return $result;
	}
	//部门新增
	function doDeptAdd()
	{
		$result=array();
		$deptid=trim($_POST['deptid']);
		$name=trim($_POST['name']);
		$mark=trim($_POST['mark']);
		$sqlOk="select count(1) num from admin_dept where deptid='$deptid'";
		$isOkArr=$this->getOne($sqlOk);
		if($isOkArr['num']>0){
			$result['success']=true;
			$result['msg']='此部门号已存在！';
			return $result;
		}
		$row=array('deptid'=>$deptid,'dept_name'=>$name,'remark'=>$mark);
		$this->tbl_name='admin_dept';
		$this->create($row);
		$result['success']=true;
		$result['msg']='部门新增成功！';
		return $result;
	}
	//得到一条部门信息
	function getOneDept()
	{
		$data=array();
		$deptid=trim($_REQUEST['deptid']);
		$sql="select * from admin_dept where deptid='$deptid'";
		$data=$this->getOne($sql);
		return $data;
	}
	//执行修改
	function doDeptUpdate()
	{
		$result=array();
		$deptid=trim($_POST['deptid']);
		$name=trim($_POST['name']);
		$mark=trim($_POST['mark']);
		$sqlOk="select count(1) num from admin_user where deptid='$deptid'";
		$isOkArr=$this->getOne($sqlOk);
		if($isOkArrp['num']>0){
			$result['success']=false;
			$result['msg']='此部门下存在操作员，请先修改对应操作员的部门号后再做删除';
			return $result;
		}
		$sql="update admin_dept set deptid='$deptid',dept_name='$name',remark='$mark' where deptid='$deptid'";
		$flag=$this->exec($sql);
		if(!$flag){
			$result['success']=false;
			$result['msg']='部门修改失败！';
		}else{
			$result['success']=true;
			$result['msg']='部门修改成功！';
		}
		return $result;
	}



	//执行删除
	function doDeptDelete()
	{
		$res=array();
		$deptid=trim($_POST['deptid']);
		$sql="delete from admin_dept where deptid='$deptid'";
		$flag=$this->exec($sql);
		if(!$flag){
			$result['success']=false;
			$result['msg']='删除部门失败！';
		}else{
			$result['success']=true;
			$result['msg']='删除部门成功！';
		}
		return $result;
	}
	/**
	 * --------------------------------------------------角色管理----------------------------------------------------------
	 */
	//角色列表
	function roleList()
	{
		$result=array();
		$page=$_REQUEST['page'];
		if (!is_numeric($page) || $page <= 0)
		{
			$page = 1;
		}
		$pagesize = RETURN_NUM;
		$start = ($page - 1) * $pagesize;
		$end=$page*$pagesize;
		
		$sql="select * from admin_role  LIMIT $start,$pagesize";
		$data=$this->getAll($sql);
		$sqlNum="select count(1) num from admin_role where 1=1";
		$result['data']=$this->getAll($sql);
		$numRes=$this->getOne($sqlNum);
		$total=$numRes['num'];
		$linkUrl=spUrl('userController','roleListAc');
		$result['linkBar'] = multi($total, $pagesize, $page, $linkUrl);
		return $result;
	}
	//角色新增
	function doRoleAdd()
	{
		$result=array();
		$name=trim($_POST['name']);
		$opid=$_SESSION["opid"];
		$remark=trim($_POST['remark']);
		$level=trim($_POST['level']);
		$row=array('role_name'=>$name,'level'=>$level,'remark'=>$remark);
		$this->tbl_name='admin_role';
		$flag=$this->create($row);
		if(!$flag){
			$result['success']=false;
			$result['msg']='角色新增失败';
		}else{
			$result['success']=true;
			$result['msg']='新增成功，请点击管理去配置角色权限！';
		}
		return $result;
	}
	//得到一条记录
	function getRoleOne()
	{
		$roleid=trim($_REQUEST['roleid']);
		$sql="select * from admin_role where roleid='$roleid'";
		$data=$this->getOne($sql);
		return $data;
	}
	//执行修改
	function doRoleUpdate()
	{
		$result=array();
		$roleid=trim($_REQUEST['roleid']);
		$name=trim($_POST['name']);
		$remark=trim($_POST['remark']);
		$level=trim($_POST['level']);

		$sql="update admin_role set role_name='$name' ,level='$level',remark='$remark' where roleid='$roleid'";
		$flag=$this->exec($sql);

		if(!$flag){
			$result['success']=false;
			$result['msg']='角色修改失败';
		}else{
			$result['success']=true;
			$result['msg']='角色修改成功！';
		}
		return $result;
	}



	//执行删除
	function doRoleDelete()
	{
		$res=array();
		$roleid=trim($_REQUEST['roleid']);
		$sqlOk="select count(1) num from admin_user where roleid='$roleid'";
		$sqlOkArr=$this->getOne($sqlOk);

		if($sqlOkArr['num']>0){
			$result['success']=false;
			$result['msg']='改角色下存在操作员，请先修改该操作员的角色后再删除';
			return $result;
		}
		$sql="delete from admin_role where roleid='$roleid'";
		$flag=$this->exec($sql);
		if(!$flag){
			$result['success']=false;
			$result['msg']='删除角色失败';
		}else{
			$result['success']=true;
			$result['msg']='删除角色成功！';
		}
		return $result;
	}
	/**
	 * --------------------------------------------------资源管理----------------------------------------------------------
	 */

	/**
	 * 已有资源关联表
	 */
	function getRoleauth()
	{
		$resData=array();
		$roleid=$_REQUEST['roleid'];
		$sql="select t1.rid as id,t1.rescode  ,t1.resurl,t1.`name`,t1.resindex,t2.permission from 
			admin_resource t1 LEFT JOIN admin_roleauth t2 ON t1.rid=t2.rid AND t2.roleid='$roleid'
			where isvalid=1 order by resindex asc";
		$resData=$this->getAll($sql);
		foreach ($resData as $key=>$val){
			if(strlen($val['rescode'])>3){
				$resData[$key]['pId']=substr($val['rescode'], 0,strlen($val['rescode'])-3);
			}else{
				$resData[$key]['pId']='';
			}
			$resData[$key]['permission']=empty($val['permission'])?'0000000000':$val['permission'];
			$resData[$key]['target']='mainframe';
		}
		//print_r($resData);exit();
		return $resData;
	}
	/**
	 * 总资源列表（资源配置时用）
	 */
	function getTreedata()
	{
		$sql="select rid as id,rescode  ,resurl,name,resindex from admin_resource where isvalid=1 order by resindex asc";
		$resData=$this->getAll($sql);
		foreach ($resData as $key=>$val){
			if(strlen($val['rescode'])>3){
				$resData[$key]['pId']=substr($val['rescode'], 0,strlen($val['rescode'])-3);
			}else{
				$resData[$key]['pId']='';
			}
			$resData[$key]['target']='mainframe';
		}
		//print_r($resData);exit();
		return $resData;
	}
	function getResData()
	{
		$sql="select rid as id,rescode  ,resurl,name,resindex from admin_resource where isvalid=1 order by rescode,resindex asc";
		$resData=$this->getAll($sql);
		//foreach ()
	}
	/**
	 * 操作员资源 
	 */
	function getResource()
	{
		$userInfo=array();
		$roleid=$_SESSION["roleid"];
		if($_SESSION['opid']=='sa'||$_SESSION['opid']=='admin'){
			$sql="select t1.rid as id,t1.rescode  ,t1.resurl,t1.`name`,t1.resindex,'1111111111' AS permission
			from admin_resource t1 where t1.isvalid=1 order by resindex asc";
		}else{
			$sql="select t1.rid as id,t1.rescode  ,t1.resurl,t1.`name`,t1.resindex,t2.permission
			from admin_resource t1,admin_roleauth t2 where t1.isvalid=1 
			and t1.rid=t2.rid AND t2.roleid='$roleid' order by resindex asc";
		}
		$resData=$this->getAll($sql);
		foreach ($resData as $key=>$val){
			if(substr($val['permission'], 0,1)!=1){//没有查看权限的删除
				unset($resData[$key]);continue;
			}
			if(strlen($val['rescode'])>3){
				$resData[$key]['pId']=substr($val['rescode'], 0,strlen($val['rescode'])-3);
			}else{
				$resData[$key]['pId']='';
			}
			$resData[$key]['target']='mainframe';
			
			$userInfo[$val['rescode']]=$val['permission'];
		}
		$resData=array_values($resData);
		$_SESSION['userInfo']=$userInfo; 
		//print_r($resData);exit();
		return $resData;
	}
	
	/**
	 * 执行新增资源
	 */
	function sourceAddDo()
	{
		$req['name']=$_POST['name'];
		$req['resurl']=$_POST['resurl'];
		$req['resindex']=$_POST['resindex'];
		$req['isvalid']=1;
		$req['rescode']=$this->getRescode();
		$this->tbl_name='admin_resource';
		$rid=$this->create($req);
		if($rid){
			$res['success']=true;
			$res['msg']='新增资源成功';
		}else{
			$res['success']=false;
			$res['msg']='新增资源失败';
		}
		return $res;
	}
	/**
	 * 修改资源
	 */
	function sourceModifyDo()
	{
		$name=$_POST['name'];
		$resurl=$_POST['resurl'];
		$resindex=$_POST['resindex'];
		$rescode=$_POST['rescode'];
		$sql="update admin_resource set name='$name',resurl='$resurl',resindex='$resindex' where rescode='$rescode'";
		$flag=$this->exec($sql); 
		if($flag){
			$res['success']=true;
			$res['msg']='修改资源成功';
		}else{
			$res['success']=false;
			$res['msg']='修改资源失败';
		}
		return $res;
	}

	function getRescode()
	{
		$rescode=$_REQUEST['rescode'];
		if($rescode=='-1'){//顶级目录
			$sql="SELECT rescode from admin_resource where LENGTH(rescode)=3 ORDER BY rescode DESC limit 0,1";
			$res=$this->getOne($sql);
			$txt='001';
			if(count($res)>0){
				$number=$res['rescode']+1;
				$txt=sprintf("%03d",$number);//生成3位数，不足前面补0
			}
		}else{//其他
			$len=strlen($rescode);
			$lenTxt=$len+3;
			$sql="select rescode from admin_resource where rescode like '$rescode%' 
			 AND LENGTH(rescode)=$lenTxt  ORDER BY rescode DESC limit 0,1";
			$res=$this->getOne($sql);
			$txt=$rescode.'001';
			if(count($res)>0){
				$number=$res['rescode']+1;
				$txt=sprintf("%0".$lenTxt."d",$number);//生成3位数，不足前面补0
			}
		}
		return $txt;
	}

	/**
	 * 资源角色关联
	 */
	function doManageRoleres()
	{
		$res=array();
		$array=array();
		$roleid=$_REQUEST['roleid'];
		$sql="delete from admin_roleauth where roleid='$roleid'";
		writeLog($sql);
		$this->exec($sql);
		$permission=$_REQUEST['permission'];
		$strArr=explode('|', $permission);
		foreach($strArr as $key=>$val){
			$tmpArr=explode('_', $val);
			$array[$tmpArr[1]][$tmpArr[0]]=true;
		}
		$sql="INSERT INTO admin_roleauth(`roleid`,`permission`,`rid`) VALUES";
		$str="";
		if(!empty($array)){
			foreach ($array as $key=>$val){
				$permissionIn='';
				$permissionIn.=$val['ck']?1:0;
				$permissionIn.=$val['xz']?1:0;
				$permissionIn.=$val['xg']?1:0;
				$permissionIn.=$val['sc']?1:0;
				$permissionIn.=$val['dc']?1:0;
				$permissionIn.=$val['qt']?1:0;
				$str.=",('$roleid','$permissionIn','$key')";			
			}
		}
		if($str!=""){
			$str=substr($str, 1);
			$sql.=$str;
			$flag=$this->exec($sql);
		}
		if(!$flag){
			$res['success']=false;
			$res['msg']='权限配置失败：数据库执行失败';
		}else{
			$res['success']=true;
			$res['msg']='权限配置成功';
		}
		return $res;
	}
	/**
	 * 得到一条资源信息
	 */
	function getOneSource()
	{
		$rescode=$_GET['rs_code'];
		$sql="select * from admin_resource where rescode='$rescode'";
		$data=$this->getOne($sql);
		return $data;
	}
	
	/**
	 * 删除资源（isvalid=0）
	 */
	function sourceDel()
	{
		$rescode=$_POST['rescode'];
		$sql="delete from admin_resource where rescode like '$rescode%'";
		$flag=$this->exec($sql);
		if($sql){
			$res['success']=true;
			$res['msg']='删除资源成功';
		}else{
			$res['success']=false;
			$res['msg']='删除资源失败';
		}
		return $res;
	}
	
	
	function doClientChange()
	{
		$operid=$_POST['operid'];
		$operidNew=$_POST['operidNew'];
		$sql1="update client set operid='$operidNew' where operid='$operid'";
		$sql2="update client_email set operid='$operidNew' where operid='$operid'";
		$sql3="update dynamic_track set operid='$operidNew' where operid='$operid'";
		$sql4="update market_track set operid='$operidNew' where operid='$operid'";
		$sql5="update pwd_owner set operid='$operidNew' where operid='$operid'";
		
		
		$flag=$this->exec($sql1);
		$flag=$this->exec($sql2);
		$flag=$this->exec($sql3);
		$flag=$this->exec($sql4);
		$flag=$this->exec($sql5);
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