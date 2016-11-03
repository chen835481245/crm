<?php
class emailController extends spController
{
	/**
	 * 邮件客户管理
	 */
	public function clientListAc()
	{
		$obj=new email();
		$data=$obj->clientList();
		
		$userObj=new user();
		$this->level=$_SESSION['level'];
		$operids=$userObj->getUserArr();
		$this->operids=$operids;
		$this->operid=$_REQUEST['operid'];
		
		if($_REQUEST['out']=='1'){
			$pubObj=new pub();
			$titleArr=array("First Name","Last Name","Email","国家","最后处理时间","建立时间","备注",
			"处理人");
			
			$keyArr=array("first_name","last_name","mail","country","deal_date","datetime","remark","opername");
			$arrReplaceName=array();
			$pubObj->outExcelCommon($data['data'], $titleArr, $keyArr,'',$arrReplaceName);
			exit;
		}
		$this->first_name=$_REQUEST['first_name'];
		$this->mail=$_REQUEST['mail'];
		$this->begin_date=$_REQUEST['begin_date'];
		$this->end_date=$_REQUEST['end_date'];
		$this->data=$data;
		$this->display('email/clientList.html');
	}
	public function addClientAc()
	{
		$id=$_REQUEST['id'];
		$obj=new gnclient();
		$data=array();
		$countryData=$obj->getCountryData();
		$this->countryDataJson=json_encode($countryData);
		
		$obj=new email();
		if($id==''){
			$this->title='新增邮件客户';
			$data['datetime']=date("Y-m-d H:i:s");
			$this->data=$data;
		}else{
			$obj=new spModel();
			$this->title='修改邮件客户';
			$sql="select * from client_email where id='$id'";
			$this->data=$obj->getOne($sql);
		}
		$this->display('email/clientAdd.html');
	}
	function checkMailAc()
	{
		$db=new spModel();
		$id=$_POST['id'];
		
		if($db->exist('client_black',array('mail'=>$_REQUEST['mail']))){
				$res['success']=false;
				$res['msg']='该邮箱已被列入黑名单，请勿添加';
				die(json_encode($res));	
		}
		if(!$id){
			if($db->exist('client_email',array('mail'=>$_REQUEST['mail']))){
				$res['success']=false;
				$res['msg']='已存在该邮箱';
			}else{
				$res['success']=true;
			}
		}else {
			$res['success']=true;
		}
		die(json_encode($res));	
	}
	public function doAddClientAc()
	{
		$id=$_REQUEST['id'];
		$obj=new spModel();
		$row=$_POST;
		$row['first_name']=ucfirst($row['first_name']);
		$row['last_name']=ucfirst($row['last_name']);
		$row['operid']=$_SESSION['opid'];
		unset($row['id']);
		$param=array();
		if($id==''){
			$row['datetime']=date("Y-m-d H:i:s");
			$row['deal_date']=date("Y-m-d");
			$flag=$obj->table('client_email')->create($row);
		}else{
			$flag=$obj->table('client_email')->update(array('id'=>$id),$row);
			$param=array('id'=>$id);
		}
		$res=$this->returnMsg($flag);
		$url=spUrl('emailController','addClientAc');
		$this->jumpUrl($url, $res,$param);
	}
	public function deleteClientAc()
	{
		$db=new spModel();
		$id=$_REQUEST['id'];
		$sql="delete from client_email where id='$id'";
		$flag=$db->exec($sql);
		$res=$this->returnMsg($flag);
		die(json_encode($res));
	}
	public function dealAc()
	{
		$db=new spModel();
		$id=$_POST['id'];
		$date=date("Y-m-d");
		$operid=$_SESSION['opid'];
		$sql="update client_email set is_deal=1,operid='$operid',deal_date='$date' where id in($id)";
		$flag=$db->exec($sql);
		$res=$this->returnMsg($flag);
		die(json_encode($res));
	}
	
	function addBlackListAc()
	{
		$obj=new email();
		if($_POST['type']==1){
			$db=new spModel();
			$row['mail']=$_POST['mail'];
			$row['datetime']=date("Y-m-d H:i:s");
			$row['operid']=$_SESSION['opid'];
			$row['remark']=$_POST['remark'];
			$flag=$db->table('client_black')->create($row);
			$db->table('client_email')->delete(array('mail'=>$row['mail']));
			$res=$this->returnMsg($flag);
			$url=spUrl('emailController','addBlackListAc');
			$this->jumpUrl($url, $res);
		}
		$data=$obj->blackList();
		$this->data=$data;
		$this->display('email/blackList.html');
	}
	public function deleteBlackAc()
	{
		$db=new spModel();
		$id=$_REQUEST['id'];
		$sql="delete from client_black where id='$id'";
		$flag=$db->exec($sql);
		$res=$this->returnMsg($flag);
		die(json_encode($res));
	}
	function addAllAc()
	{
		$obj=new email();
		$res=$obj->addAll();
		$url=spUrl('emailController','clientListAc');
		$url.="&isSelect=1";
		$this->jumpUrl($url, $res);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}