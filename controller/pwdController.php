<?php
class pwdController extends spController
{
	function addTypeListAc()
	{
		$obj=new pwd();
		if($_POST['type']==1){
			$db=new spModel();
			$row['name']=$_POST['name'];
			$flag=$db->table('pwd_type')->create($row);
			$res=$this->returnMsg($flag);
			$url=spUrl('pwdController','addTypeListAc');
			$this->jumpUrl($url, $res);
		}
		if($_POST['type']==2){
			$db=new spModel();
			$row['name']=$_POST['name'];
			$flag=$db->table('pwd_type')->update(array('id'=>$_POST['id']), $row);
			$res=$this->returnMsg($flag);
			$url=spUrl('pwdController','addTypeListAc');
			$this->jumpUrl($url, $res);
		}
		$data=$obj->addTypeList();
		$this->data=$data;
		$this->display('pwd/typeList.html');
	}
	public function deleteTypeAc()
	{
		$db=new spModel();
		$id=$_REQUEST['id'];
		$sql="delete from pwd_type where id='$id'";
		$flag=$db->exec($sql);
		$res=$this->returnMsg($flag);
		die(json_encode($res));
	}
	
	/**
	 * 密码管理
	 */
	public function pwdListAc()
	{
		$obj=new pwd();
		$data=$obj->pwdList();
		$this->search=$_REQUEST['search'];
		$this->data=$data;
		$this->display('pwd/pwdList.html');
	}
	public function addPwdAc()
	{
		$id=$_REQUEST['id'];
		$obj=new pwd();
		$data=array();
		$owners=array();
		$this->types=$obj->getTypes();
		if($id==''){
			$this->title='新增我的密码';
			$data['datetime']=date("Y-m-d H:i:s");
			$this->name=$_SESSION['name'];
			$this->data=$data;
		}else{
			$db=new spModel();
			$this->title='修改我的密码';
			$this->name=$_SESSION['name'];
			$sql="select * from pwd_recode where id='$id'";
			$this->data=$db->getOne($sql);
			$sql1="select id,operid from pwd_owner where recode_id='$id'";
			$owners=$db->getArray($sql1,1);
		}
		$operids=$obj->getUserArr($owners);
		$this->operids=$operids;
		$this->display('pwd/pwdAdd.html');
	}
	public function doAddPwdAc()
	{
		$obj=new pwd();
		$flag=$obj->doAddPwd();
		$res=$this->returnMsg($flag);
		$url=spUrl('pwdController','addPwdAc');
		$this->jumpUrl($url, $res);
	}
	public function deletePwdAc()
	{
		$db=new spModel();
		$id=$_REQUEST['id'];
		$flag=$db->table('pwd_recode')->delete(array('id'=>$id));
		$db->table('pwd_owner')->delete(array('recode_id'=>$id));
		$res=$this->returnMsg($flag);
		die(json_encode($res));
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}


