<?php
class recordController extends spController
{
	public function checkingAc()
	{
		$obj=new record();
		$this->data=$obj->checking();
		$this->params=$_REQUEST;
		$this->display('record/checking.html');
	}
	public function customerAc()
	{
		$obj=new record();
		$this->data=$obj->customer();
		$this->params=$_REQUEST;
		$this->display('record/customer.html');
	}
	public function dynamicListAc()
	{
		$obj=new record();
		$data=$obj->dynamicList();
		if($_REQUEST['out']=='1'){
			$pubObj=new pub();
			$titleArr=array("日期","客户名称","动态 ","客户邮箱","操作员","关键字","需协助");
			$keyArr=array("datetime","first_name","content","mail","opername","keywords","help_name");
			$arrReplaceName=array('datetime');
			$pubObj->outExcelCommon($data['data'], $titleArr, $keyArr,'',$arrReplaceName);
			exit;
		}
		$userObj=new user();
		$operids=$userObj->getUserArr();
		$this->operids=$operids;
		$this->level=$_SESSION['level'];
		$this->operid=$_REQUEST['operid'];
		
		$this->content=$_REQUEST['content'];
		$this->mail=$_REQUEST['mail'];
		$this->is_help=$_REQUEST['is_help'];
		$this->keyword=$_REQUEST['keyword'];
		$this->mail=$_REQUEST['mail'];
		$begin_date=$_REQUEST['begin_date'];
		$end_date=$_REQUEST['end_date'];
		if($begin_date==''){
			$end_date=$begin_date=date("Y-m-d");
		}
		$this->begin_date=$begin_date;
		$this->end_date=$end_date;
		$this->data=$data;
		$this->display('record/dynamicList.html');
	}
	public function dynamicAddAc()
	{
		$id=$_REQUEST['id'];
		if($id==''){
			$this->title='增加客户日常动态';
			$data['datetime']=date("Y-m-d H:i:s");
			$data['clientInfo']='';
			$data['client_id']=$_REQUEST['client_id'];
			if($data['client_id']!=''){
				$obj=new spModel();
				$client_id=$data['client_id'];
				$sql="select id,first_name as name,mail,company_name from client where id='$client_id'";
				$dataOne=$obj->getOne($sql);
				$clientInfo=$dataOne['id'].' '.$dataOne['name'].' '.$dataOne['mail'].' '.$dataOne['company_name'];
				$data['clientInfo']=$clientInfo;
			}
			$this->data=$data;
		}else{
			$obj=new spModel();
			$this->title='修改客户日常动态';
			$sql="select * from dynamic_track where id='$id'";
			$data=$obj->getOne($sql);
			$client_id=$data['client_id'];
			$sql="select id,first_name as name,mail,company_name from client where id='$client_id'";
			$dataOne=$obj->getOne($sql);
			$clientInfo=$dataOne['id'].' '.$dataOne['name'].' '.$dataOne['mail'].' '.$dataOne['company_name'];
			$data['clientInfo']=$clientInfo;
			$this->data=$data;
		}
		$obj=new gnclient();
		$clients=$obj->getClients();
		$this->clientsJson=json_encode($clients);
		$this->display('record/dynamicAdd.html');
	}
	public function doAddDynamicAc()
	{
		$id=$_REQUEST['id'];
		$obj=new spModel();
		$row=$_POST;
		unset($row['id']);
		$param=array();
		$row['datetime']=date("Y-m-d H:i:s");
		if($id==''){
			$row['operid']=$_SESSION['opid'];
			$flag=$obj->table('dynamic_track')->create($row);
			$obj->table('client')->update(array('id'=>$_POST['client_id']), array('follow_time'=>$row['datetime']));
		}else{
			$flag=$obj->table('dynamic_track')->update(array('id'=>$id),$row);
			$param=array('id'=>$id);
		}
		$res=$this->returnMsg($flag);
		$url=spUrl('recordController','dynamicAddAc');
		$this->jumpUrl($url, $res,$param);
	}
	public function deleteDynamicAc()
	{
		$db=new spModel();
		$id=$_REQUEST['id'];
		$sql="delete from dynamic_track where id='$id'";
		$flag=$db->exec($sql);
		$res=$this->returnMsg($flag);
		die(json_encode($res));
	}
	function getClientInfoAc()
	{
		$obj=new spModel();
		$id=$_POST['id'];
		$sql="select t1.first_name,t1.last_name,t1.company_name,t1.country,t2.`name` as client_type 
			from client t1,client_type t2 where t1.client_type=t2.id and t1.id='$id'";
		$data=$obj->getOne($sql);
		if($data['last_name']=='')$data['last_name']=' ';
		die(json_encode($data));		
	}
	
	public function marketListAc()
	{
		$obj=new record();
		$data=$obj->marketList();
		$userObj=new user();
		$operids=$userObj->getUserArr();
		$this->operids=$operids;
		$this->level=$_SESSION['level'];
		$this->operid=$_REQUEST['operid'];
		
		if($_REQUEST['out']=='1'){
			$pubObj=new pub();
			$titleArr=array("日期","客户名称","动态 ","客户邮箱","操作员","关键字","反馈状态");
			$keyArr=array("datetime","first_name","content","mail","opername","keywords","back_name");
			$arrReplaceName=array('datetime');
			$pubObj->outExcelCommon($data['data'], $titleArr, $keyArr,'',$arrReplaceName);
			exit;
		}
		$begin_date=$_REQUEST['begin_date'];
		$end_date=$_REQUEST['end_date'];
		if($begin_date==''){
			$end_date=$begin_date=date("Y-m-d");
		}
		$this->begin_date=$begin_date;
		$this->end_date=$end_date;
		
		$this->content=$_REQUEST['content'];
		$this->keyword=$_REQUEST['keyword'];
		$this->mail=$_REQUEST['mail'];
		$this->name=$_REQUEST['name'];
		$this->operid=$_REQUEST['operid'];
		$this->data=$data;
		$this->display('record/marketList.html');
	}
	function dealAc()
	{
		$db=new spModel();
		$id=$_POST['id'];
		$date=date("Y-m-d");
		$operid=$_SESSION['opid'];
		$sql="update market_track set is_back=1 where id in($id)";
		$flag=$db->exec($sql);
		$res=$this->returnMsg($flag);
		die(json_encode($res));
	}
	public function marketAddAc()
	{
		$id=$_REQUEST['id'];
		if($id==''){
			$this->title='增加客户营销动态';
			$data['datetime']=date("Y-m-d H:i:s");
			$data['client_id']=$_REQUEST['client_id'];
			if($data['client_id']!=''){
				$obj=new spModel();
				$client_id=$data['client_id'];
				$sql="select id,first_name as name,mail,company_name from client where id='$client_id'";
				$dataOne=$obj->getOne($sql);
				$clientInfo=$dataOne['id'].' '.$dataOne['name'].' '.$dataOne['mail'].' '.$dataOne['company_name'];
				$data['clientInfo']=$clientInfo;
			}
			$this->data=$data;
		}else{
			$obj=new spModel();
			$this->title='修改客户营销动态';
			$sql="select * from market_track where id='$id'";
			$data=$obj->getOne($sql);
			$client_id=$data['client_id'];
			$sql="select id,first_name as name,mail,company_name from client where id='$client_id'";
			$dataOne=$obj->getOne($sql);
			$clientInfo=$dataOne['id'].' '.$dataOne['name'].' '.$dataOne['mail'].' '.$dataOne['company_name'];
			$data['clientInfo']=$clientInfo;
			$this->data=$data;
		}
		$obj=new gnclient();
		$clients=$obj->getClients();
		$this->clientsJson=json_encode($clients);
		$this->display('record/marketAdd.html');
	}
	public function doAddMarketAc()
	{
		$id=$_REQUEST['id'];
		$obj=new spModel();
		$row=$_POST;
		unset($row['id']);
		$param=array();
		$row['datetime']=date("Y-m-d H:i:s");
		if($id==''){
			$row['operid']=$_SESSION['opid'];
			$flag=$obj->table('market_track')->create($row);
			$obj->table('client')->update(array('id'=>$_POST['client_id']), array('follow_time'=>$row['datetime']));
		}else{
			$flag=$obj->table('market_track')->update(array('id'=>$id),$row);
			$param=array('id'=>$id);
		}
		$res=$this->returnMsg($flag);
		$url=spUrl('recordController','marketAddAc');
		$this->jumpUrl($url, $res,$param);
	}
	public function deleteMarketAc()
	{
		$db=new spModel();
		$id=$_REQUEST['id'];
		$sql="delete from market_track where id='$id'";
		$flag=$db->exec($sql);
		$res=$this->returnMsg($flag);
		die(json_encode($res));
	}
	
	
}