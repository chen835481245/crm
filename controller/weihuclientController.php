<?php
class weihuclientController extends spController
{
	function client30Ac()
	{
		$obj=new weihuclient();
		$userObj=new user();
		$operids=$userObj->getUserArr();
		$this->operids=$operids;
		$this->operid=$_REQUEST['operid'];
		$this->level=$_SESSION['level'];
		$this->data=$obj->weihuclientData(1);
		$this->act='client30Ac';
		$this->title='30天未联系客户';
		$this->display('weihuclient/weihuclient.html');
	}
	function client60Ac()
	{
		$obj=new weihuclient();
		$userObj=new user();
		$operids=$userObj->getUserArr();
		$this->operids=$operids;
		$this->operid=$_REQUEST['operid'];
		$this->level=$_SESSION['level'];
		$this->title='60天未联系客户';
		$this->act='client60Ac';
		$this->data=$obj->weihuclientData(2);
		$this->display('weihuclient/weihuclient.html');
	}
	function client90Ac()
	{
		$obj=new weihuclient();
		$userObj=new user();
		$operids=$userObj->getUserArr();
		$this->operids=$operids;
		$this->operid=$_REQUEST['operid'];
		$this->level=$_SESSION['level'];
		$this->act='client90Ac';
		$this->title='90天以上未联系客户';
		$this->data=$obj->weihuclientData(3);
		$this->display('weihuclient/weihuclient.html');
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}



















