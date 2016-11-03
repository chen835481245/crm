<?php
class login extends spModel
{
	/*
	 * 检测操作员并存session
	 */
	function checkLogin()
	{
		$result=array();
		$operatorId=$_REQUEST['OperatorID'];
		$operatorPwd=md5(trim($_REQUEST['pwd']));
		$sql="select t1.operid,t1.deptid,t1.`name`,t1.roleid,t2.`level`  
		from admin_user t1,admin_role t2 where t1.roleid=t2.roleid 
		and t1.operid='$operatorId' and t1.password='$operatorPwd'";
		$data=$this->getOne($sql);
		if(!empty($data['operid'])){
			$result['success']=true;
			$_SESSION["deptid"]=$data['deptid'];
			$deptNameArr=$this->getDeptName();
			$_SESSION['deptName']=$deptNameArr[$data['deptid']];
			$_SESSION["roleid"]=$data['roleid'];
			$_SESSION["opid"]=$operatorId;
			$name=$data['name']==''?$data['roleid']:$data['name'];
			$_SESSION["name"]="【".$operatorId."】".$name;
			$_SESSION["level"]=$data['level'];
		}else{
			$result['success']=false;
			$result['msg']='操作员id或密码错误';
			writeLog($result['msg'].$sql);
		}
		return $result;
	}

	function getDeptName()
	{
		$sql="select deptid ,dept_name from admin_dept";
		$data=$this->getArray($sql,1);
		return $data;
	}

	function firstPage()
	{
		$redis=new redisInit('redis2');
		if(!$redis->exists('admin_first_data'))
		{
			$res=$this->getFirstPageData();
			$redis->hmset('admin_first_data', $res);
			$redis->expire('admin_first_data', 21600);//6小时过期
		}else{
			$res=$redis->hgetall('admin_first_data');
		}
		return $res;
	}
	function getFirstPageData()
	{
		$res=array();
		$sql="SELECT count(1) num from city where valid=1 UNION ALL
				SELECT count(DISTINCT(fid)) num from shop where grade=2 UNION ALL
				select count(1) num from `user` UNION ALL
				SELECT count(1) num from apply UNION ALL
				SELECT count(1) num from apply where `status`=0 UNION all
				SELECT SUM(amount) as num from apply where `status`=0";
		$data=$this->getAll($sql);
		$data['5']['num']=$data['5']['num']/100;
		foreach ($data as $key=>$val){
			$res[]=number_format($val['num']);
		}
		return $res;
	}








}