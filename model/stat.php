<?php
class stat extends spModel
{
	function getDataStat()
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
		
		$year=$_REQUEST['year']==''?date("Y"):$_REQUEST['year'];
		$month=$_REQUEST['month']==''?date("m"):$_REQUEST['month'];
		
		$beg_date="$year-$month-01";
		$end_date="$year-$month-31 23:59:59";
		
		if($month=='-1'){
			$beg_date="$year-01-01";
			$end_date="$year-12-31 23:59:59";
		}
		$selectType=$_REQUEST['selectType'];
		$date=date("Y-m-d");
		if($selectType==2){
			$beg_date=$date;
			$end_date="$date 23:59:59";
		}
		if($selectType==3){
			$beg_date=date("Y-m-d",strtotime("-7 day"));
			$end_date="$date 23:59:59";
		}

		$sql="SELECT operid,`name` from admin_user where valid=1";
		$userArr=$this->getAll($sql);
		$sql1="SELECT operid,count(1) num from client where datetime 
		BETWEEN '$beg_date' AND '$end_date' 
		GROUP BY operid";
		$sql2="SELECT operid,count(1) num from client_email where datetime 
		BETWEEN '$beg_date' AND '$end_date' 
		GROUP BY operid";
		$sql3="SELECT operid,count(1) num from dynamic_track where datetime 
		BETWEEN '$beg_date' AND '$end_date' 
		GROUP BY operid";
		$sql4="SELECT operid,count(1) num from market_track where datetime 
		BETWEEN '$beg_date' AND '$end_date' 
		GROUP BY operid";
		$data1=$this->getArray($sql1,1);
		$data2=$this->getArray($sql2,1);
		$data3=$this->getArray($sql3,1);
		$data4=$this->getArray($sql4,1);
		
		foreach ($userArr as $key=>$val){
			$operid=$val['operid'];
			$tmp=array();
			$tmp['clientNum']=intval($data1[$operid]);
			$tmp['emailNum']=intval($data2[$operid]);
			$tmp['dynamicNum']=intval($data3[$operid]);
			$tmp['marketNum']=intval($data4[$operid]);
			$tmp['opername']=$val['name'];
			$data[]=$tmp;
		}
		return $data;
	}
}