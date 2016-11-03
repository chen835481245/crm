<?php
/**
 * 系统权限控制器
 * @useror chenhao
 *
 */
class userController extends spController
{
	/*
	 * 操作员列表
	 */
	function userListAc()
	{
		$mod=new user();
		$data=$mod->userList();
		//print_r($data);
		$this->data=$data;
		$this->display('user/userList.html');
	}
	/*
	 * 新增操作员
	 */
	function userAddAc()
	{
		$mod=new user();
		$modPub=new pub();
		$this->roleids=$mod->getRoles();
		$this->deptids=$modPub->getDept();
		$this->actionType=$_POST['actionType'];
		$this->title='新增操作员';
		$this->action='douserAddAc';
		$this->display('user/userAdd.html');
	}
	/*
	 * 执行新增
	 */
	function doUserAddAc()
	{
		$mod=new user();
		$res=$mod->douserAdd();
		echo json_encode($res);
	}
	/*
	 * 执行删除
	 */
	function douserDeleteAc()
	{
		$mod=new user();
		$res=$mod->douserDelete();
		echo json_encode($res);
	}
	/*
	 * 修改操作员
	 */
	function userUpdateAc()
	{
		$mod=new user();
		$modPub=new pub();
		$actionType=$_REQUEST['actionType'];
		$this->roleids=$mod->getRoles();
		$this->deptids=$modPub->getDept();
		$this->data=$mod->getOneuser();
		$this->actionType=$actionType;
		if($actionType=='u'){
			$this->title='修改操作员';
			$this->action='douserUpdateAc';
			$this->display('user/userAdd.html');
		}else{
			//密码修改
			$this->title='修改操作员密码';
			$this->action='douserChangePwdAc';
			$this->display('user/userChangePwd.html');
		}
	}
	/*
	 * 修改信息
	 */
	function douserUpdateAc()
	{
		$mod=new user();
		$res=$mod->douserUpdate();
		echo json_encode($res);
	}
	/*
	 * 修改密码
	 */
	function douserChangePwdAc()
	{
		$mod=new user();
		$res=$mod->douserChangePwd();
		echo json_encode($res);
	}
	function clientChangeAc()
	{
		$userObj=new user();
		$operids=$userObj->getUserArr();
		$this->operids=$operids;
		$this->display('user/clientChange.html');
	}
	function doClientChangeAc()
	{
		$obj=new user();
		$res=$obj->doClientChange();
		die(json_encode($res));
	}
	/**
	 * --------------------------------------------------部门管理----------------------------------------------------------
	 */
	/*
	 * 部门列表
	 */
	function deptListAc()
	{
		$mod=new user();
		$data=$mod->deptList();
		$this->data=$data;
		$this->display('user/deptList.html');
	}
	/*
	 * 新增部门
	 */
	function deptAddAc()
	{
		$this->title='新增部门';
		$this->action='doDeptAddAc';
		$this->display('user/deptAdd.html');
	}
	//执行新增
	function doDeptAddAc()
	{
		$mod=new user();
		$res=$mod->doDeptAdd();
		echo json_encode($res);
	}
	//执行修改
	function deptUpdateAc()
	{
		$mod=new user();
		$this->title='修改部门';
		$this->data=$mod->getOneDept();
		$this->action='doDeptUpdateAc';
		$this->display('user/deptAdd.html');
	}
	function doDeptUpdateAc()
	{
		$mod=new user();
		$res=$mod->doDeptUpdate();
		echo json_encode($res);
	}
	//删除
	function doDeptDeleteAc()
	{
		$mod=new user();
		$res=$mod->doDeptDelete();
		echo json_encode($res);
	}
	/**
	 * ------------------------------------------------角色管理-------------------------------------------------------------------------
	 */
	//角色列表
	function roleListAc()
	{
		$mod=new user();
		$data=$mod->roleList();
		$this->data=$data;
		$this->display('user/roleList.html');
	}
	//新增角色
	function roleAddAc()
	{
		$this->title='新增角色';
		$this->action='doRoleAddAc';
		$this->display('user/roleAdd.html');
	}
	//执行新增
	function doRoleAddAc()
	{
		$mod=new user();
		$res=$mod->doRoleAdd();
		echo json_encode($res);
	}
	//修改
	function roleUpdateAc()
	{
		$mod=new user();
		$this->title='修改角色名';
		$this->data=$mod->getRoleOne();
		$this->action='doRoleUpdateAc';
		$this->display('user/roleAdd.html');
	}
	function doRoleUpdateAc()
	{
		$mod=new user();
		$res=$mod->doRoleUpdate();
		echo json_encode($res);
	}
	//删除
	function doRoleDeleteAc()
	{
		$mod=new user();
		$res=$mod->doRoleDelete();
		echo json_encode($res);
	}

	//建立角色资源关联
	function manageRoleresAc()
	{
		$mod=new user();
		$data = $mod->getRoleauth();//已有资源
		$this->treedata = getJson($data);
		//print_r($data);
		$this->roleid=$_REQUEST['roleid'];
		$this->name=$_REQUEST['name'];
		$this->title='角色资源关联设置';
		$this->display('user/manageroleres.html');
	}
	//执行关联
	function doManageRoleresAc()
	{
		$mod=new user();
		$res=$mod->doManageRoleres();
		echo json_encode($res);
	}
	/**
	 * ------------------------------------------------------资源管理--------------------------------------------------------------------------------
	 */

	function sourceListAc()
	{
		$mod=new user();
		$data=$mod->getTreedata();
		$this->treedata=getJson($data);
		$this->display('user/resourceIndex.html');
	}
	function sourceAddAc()
	{
		$this->state='sourceAddDo';
		$this->fieldName='上级资源编号';
		$this->title='新增资源';
		$data['rescode']=$_REQUEST['rs_code'];
		$this->data=$data;
		$this->display('user/resourceAdd.html');
	}
	function sourceModifyAc()
	{
		$this->state='sourceModifyDo';
		$this->fieldName='资源编号';
		$this->title='修改资源';
		$mod=new user();
		$this->data=$mod->getOneSource();
		$this->display('user/resourceAdd.html');
	}
	function sourceAddDoAc()
	{
		$mod=new user();
		$action=$_REQUEST['state'];
		$res=$mod->$action();
		echo json_encode($res);
	}
	function sourceDelAc()
	{
		$mod=new user();
		$res=$mod->sourceDel();
		echo json_encode($res);
	}
	



































































































}