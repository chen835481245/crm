<?php
class statController extends spController
{
	function getDataStatAc()
	{
		$obj=new stat();
		$years=array('2015'=>'2015','2016'=>'2016','2017'=>'2017','2018'=>'2018','2019'=>'2019','2020'=>'2020');
		$months=array('01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07',
		'08'=>'08','09'=>'09','10'=>'10','11'=>'11','12'=>'12');
		$this->years=$years;
		$this->months=$months;
		$year=$_REQUEST['year']==''?date("Y"):$_REQUEST['year'];
		$month=$_REQUEST['month']==''?date("m"):$_REQUEST['month'];
		$this->year=$year;
		$this->month=$month;
		$this->data=$obj->getDataStat();
		$this->display('stat/getDataStat.html');
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}