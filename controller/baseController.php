<?php
class baseController extends spController
{
	/**
	 * 客户来源 
	 */
	public function sourceListAc()
	{
		$obj=new base();
		$data=$obj->sourceList();
		$this->data=$data;
		$this->display('base/sourceList.html');
	}
	public function addSourceAc()
	{
		$id=$_REQUEST['id'];
		if($id==''){
			$this->title='新增客户涞源';
		}else{
			$obj=new spModel();
			$this->title='修改客户涞源';
			$sql="select * from client_source where id='$id'";
			$this->data=$obj->getOne($sql);
		}
		$this->display('base/sourceAdd.html');
	}
	public function doAddSourceAc()
	{
		$id=$_REQUEST['id'];
		$obj=new spModel();
		$row=$_POST;
		$row['is_gw']=0;
		unset($row['id']);
		if($id==''){
			$flag=$obj->table('client_source')->create($row);
		}else{
			$flag=$obj->table('client_source')->update(array('id'=>$id),$row);
		}
		$res=$this->returnMsg($flag);
		die(json_encode($res));
	}
	public function deleteSourceAc()
	{
		$db=new spModel();
		$id=$_REQUEST['id'];
		$sql="delete from client_source where id='$id'";
		$flag=$db->exec($sql);
		$res=$this->returnMsg($flag);
		die(json_encode($res));
	}
	/**
	 * 客户类型
	 */
	public function typeListAc()
	{
		$obj=new base();
		$data=$obj->typeList();
		$this->data=$data;
		$this->display('base/typeList.html');
	}
	public function addTypeAc()
	{
		$id=$_REQUEST['id'];
		if($id==''){
			$this->title='新增客户类型';
		}else{
			$obj=new spModel();
			$this->title='修改客户类型';
			$sql="select * from client_type where id='$id'";
			$this->data=$obj->getOne($sql);
		}
		$this->display('base/typeAdd.html');
	}
	public function doAddTypeAc()
	{
		$id=$_REQUEST['id'];
		$obj=new spModel();
		$row=$_POST;
		$row['is_gw']=0;
		unset($row['id']);
		if($id==''){
			$flag=$obj->table('client_type')->create($row);
		}else{
			$flag=$obj->table('client_type')->update(array('id'=>$id),$row);
		}
		$res=$this->returnMsg($flag);
		die(json_encode($res));
	}
	public function deleteTypeAc()
	{
		$db=new spModel();
		$id=$_REQUEST['id'];
		$sql="delete from client_type where id='$id'";
		$flag=$db->exec($sql);
		$res=$this->returnMsg($flag);
		die(json_encode($res));
	}
	/**
	 * 在线工具类型
	 */
	public function toolListAc()
	{
		$obj=new base();
		$data=$obj->toolList();
		$this->data=$data;
		$this->display('base/toolList.html');
	}
	public function addToolAc()
	{
		$id=$_REQUEST['id'];
		if($id==''){
			$this->title='新增在线工具类型';
		}else{
			$obj=new spModel();
			$this->title='修改在线工具类型';
			$sql="select * from client_tool where id='$id'";
			$this->data=$obj->getOne($sql);
		}
		$this->display('base/toolAdd.html');
	}
	public function doAddToolAc()
	{
		$id=$_REQUEST['id'];
		$obj=new spModel();
		$row=$_POST;
		unset($row['id']);
		if($id==''){
			$flag=$obj->table('client_tool')->create($row);
		}else{
			$flag=$obj->table('client_tool')->update(array('id'=>$id),$row);
		}
		$res=$this->returnMsg($flag);
		die(json_encode($res));
	}
	public function deleteToolAc()
	{
		$db=new spModel();
		$id=$_REQUEST['id'];
		$sql="delete from client_tool where id='$id'";
		$flag=$db->exec($sql);
		$res=$this->returnMsg($flag);
		die(json_encode($res));
	}
}