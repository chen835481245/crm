<?php
class gwclientController extends spController
{
	/**
	 * 国外客户管理
	 */
	public function clientListAc()
	{
		$obj=new gnclient();
		if($_REQUEST['out']=='1'){
            $data=$obj->clientList(1,5000);
			$pubObj=new pub();
			$titleArr=array("first_name","last_name","客户公司名称 ","客户类型","客户电话","客户在线工具","创建日期",
			"持有者","客户公司网址","客户手机","客户备注");
				
			$keyArr=array("first_name","last_name","company_name","type_name","phone","tool_number","datetime"
			,"opername","url","mobile_phone","remark");
			$arrReplaceName=array('datetime');
			$pubObj->outExcelCommon($data['data'], $titleArr, $keyArr,'',$arrReplaceName);
			exit;
		}else{
            $data=$obj->clientList(1);
        }
		$userObj=new user();
		$operids=$userObj->getUserArr();
		$this->operids=$operids;
		
		$this->client_types=$obj->getClientTypes();
		$this->client_type=$_REQUEST['client_type'];
		
		$this->level=$_SESSION['level'];
		$this->company_name=$_REQUEST['company_name'];
		$this->first_name=$_REQUEST['first_name'];
		$this->mail=$_REQUEST['mail'];
		$this->begin_date=$_REQUEST['begin_date'];
		$this->end_date=$_REQUEST['end_date'];
		$this->data=$data;
		$this->display('gwclient/clientList.html');
	}
	public function addClientAc()
	{
		$id=$_REQUEST['id'];
		$obj=new gnclient();
		$this->client_types=$obj->getClientTypes();
		$countryData=$obj->getCountryData();
		$this->countryDataJson=json_encode($countryData);
		if($_SESSION['opid']=='sa'||$_SESSION['opid']=='admin'){
			$userObj=new user();
			$operids=$userObj->getUserArr();
			$this->operids=$operids;
		}else{
			$this->operids=array($_SESSION['opid']=>$_SESSION['name']);
		}
		if($id==''){
			$this->title='新增国外客户';
			$this->data=$data;
		}else{
			$obj=new spModel();
			$this->title='修改国外客户';
			$sql="select * from client where id='$id'";
			$this->data=$obj->getOne($sql);
		}
		$this->display('gwclient/clientAdd.html');
	}
	function checkClientAc()
	{
		$obj=new spModel();
		$sql="select * from client where mail='".$_REQUEST['mail']."' limit 1";
		$data=$obj->getOne($sql);
		if(!empty($data)){
			$sql="select * from admin_user WHERE operid='".$data['operid']."'";
			$data=$obj->getOne($sql);
			$res['success']=false;
			$res['msg']='此客户已存在业务员：'.$data['name'];
		}else{
			$res['success']=true;
			$res['msg']='不存在此客户，请添加';
		}
		die(json_encode($res));
	}
	public function doAddClientAc()
	{
		$id=$_REQUEST['id'];
		$obj=new spModel();
		$row=$_POST;
		$row['is_gw']=1;
		unset($row['id']);
		$param=array();
		$url=spUrl('gwclientController','addClientAc');
		$row['first_name']=ucfirst($_POST['first_name']);
		$row['last_name']=ucfirst($_POST['last_name']);
		if($id==''){
			$row['datetime']=date("Y-m-d H:i:s");
			$row['is_pub']=0;
			if($obj->exist('client',array('mail'=>$_POST['mail']))){
				$res['success']=false;
				$res['msg']='此客户已存在';
				$this->jumpUrl($url, $res);exit;
			}
			$flag=$obj->table('client')->create($row);
		}else{
			$flag=$obj->table('client')->update(array('id'=>$id),$row);
			$param=array('id'=>$id);
		}
		if($flag){
			$emailObj=new email();
			$emailObj->addEmailClient();
		}
		$res=$this->returnMsg($flag);
		$this->jumpUrl($url, $res,$param);
	}
	public function deleteClientAc()
	{
		$db=new spModel();
		$id=$_REQUEST['id'];
		$sql="delete from client where id='$id'";
		$flag=$db->exec($sql);
		$res=$this->returnMsg($flag);
		die(json_encode($res));
	}
	function topubAc()
	{
		$db=new spModel();
		$id=$_POST['id'];
		$sql="update client set is_pub=1 where id in($id)";
		$flag=$db->exec($sql);
		$res=$this->returnMsg($flag);
		die(json_encode($res));
	}
	function clientMoreAc()
	{
		$obj=new gnclient();
		$data=$obj->clientMore();
		$this->data=$data;
		$this->display('gwclient/clientMore.html');
	}
	function clientPubListAc()
	{
		$obj=new gnclient();
		$data=$obj->clientPubList(1);
		if($_REQUEST['out']=='1'){
			$pubObj=new pub();
			$titleArr=array("first_name","last_name","客户公司名称 ","客户类型","客户电话","客户在线工具","创建日期",
			"持有者","客户公司网址","客户手机","客户备注");
				
			$keyArr=array("first_name","last_name","company_name","type_name","phone","tool_number","datetime"
			,"opername","url","mobile_phone","remark");
			$arrReplaceName=array('datetime');
			$pubObj->outExcelCommon($data['data'], $titleArr, $keyArr,'',$arrReplaceName);
			exit;
		}
		$this->company_name=$_REQUEST['company_name'];
		$this->first_name=$_REQUEST['first_name'];
		$this->mail=$_REQUEST['mail'];
		$this->begin_date=$_REQUEST['begin_date'];
		$this->end_date=$_REQUEST['end_date'];
		$this->data=$data;
		$this->display('gwclient/clientPubList.html');
	}






















}