<?php
class weihuclient extends spModel
{
	function weihuclientData($type=1)
	{
		$result=array();
		$page=$_REQUEST['page'];
		if (!is_numeric($page) || $page <= 0)
		{
			$page = 1;
		}
		$pagesize = 20;
		$start = ($page - 1) * $pagesize;
		//30天-59

		switch ($type){
			case 1:
				$end_date=date("Y-m-d",strtotime("-30 day"));
				$begin_date=date("Y-m-d",strtotime("-59 day"));
				$act='client30Ac';
				break ;
			case 2:
				$end_date=date("Y-m-d",strtotime("-60 day"));
				$begin_date=date("Y-m-d",strtotime("-89 day"));
				$act='client60Ac';
				break;
			case 3:
				$end_date=date("Y-m-d",strtotime("-90 day"));
				$begin_date=date("Y-m-d",strtotime("-1 year"));
				$act='client90Ac';
				break;
		}
		/*30天的条件包含（30天-59天连续没有联系）
		 60天的条件只包含（60-89天连续没有联系的）
		 90天以上（只包含90天或90天以上的）*/

		if($_SESSION['level']>2){
			$operid=$_REQUEST['operid'];
			$operidSql=$operid==''?'':" and t1.operid='$operid'";
			if($_SESSION['level']==3){
				$operidSql.=" and t1.operid not in('sa','admin')";
			}
		}else{
			$operid=$_SESSION['opid'];
			$operidSql=" and t1.operid='$operid'";
		}

		$sql="SELECT t1.mail,t1.first_name,t1.last_name,t1.follow_time,t1.id,t1.client_type,t2.`name` as opername
		 from client t1 left join admin_user t2 on t1.operid=t2.operid
		   where t1.follow_time BETWEEN '$begin_date' AND '$end_date' 
		 $operidSql  LIMIT $start,$pagesize";
		$sqlNum="select count(1) num from client t1 where t1.follow_time 
		BETWEEN '$begin_date' AND '$end_date' $operidSql";
		$data=$this->getAll($sql);
		
		$sqlType="select id,`name` from client_type";
		$types=$this->getArray($sqlType,1);
		foreach ($data as $key=>$val){
			$data[$key]['client_type_name']=$types[$val['client_type']];
		}
		$result['data']=$data;
		$numRes=$this->getOne($sqlNum);
		$total=$numRes['num'];
		$linkUrl=spUrl('weihuclientController',$act);
		$linkUrl.="&operid=".$operid;
		$result['linkBar'] = multi($total, $pagesize, $page, $linkUrl);
		return $result;
	}






















}