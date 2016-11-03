<?php
class loginController extends spController
{
	// 这里是首页
	function index()
	{ 
		$this->display("login/login.html");
	}
	function firstPageAc()
	{
		$obj=new login();
		$this->data=$obj->firstPage();
		$this->display("login/firstPage.html");
	}
	//登录首页
	function loginIndex()
	{
		$mod=new login();
		$operatorId=$_REQUEST['OperatorID'];
		$operatorPwd=$_REQUEST['pwd'];
		if($operatorId==''&&$operatorPwd==''){
			$url=spUrl('loginController','index');
			echo "<script type='text/javascript'>document.location.href=('".$url."');</script>";
			exit;			
		}
		$res=$mod->checkLogin();
		if(!$res['success']){
			echo "<html><script type='text/javascript'>alert('".$res['msg']."');window.onload=function login(){history.back();}</script><body></body></html>";
			exit;
		}
		$user= $_SESSION['name'];//操作员
		$modUser=new user();
		$userInfo=$modUser->getResource();
	    $this->userInfo=json_encode($userInfo); 
	    $this->deptName=$_SESSION['deptName'];
	    $this->user=$user;
		//$this->userInfo='[{"rid":"1","rescode":"100","resindex":"","resurl":"","name":"\u540e\u53f0\u7ba1\u7406","pId":"","target":"mainframe"},{"rid":"2","rescode":"100001","resindex":"","resurl":"manageController\/horseLampAc\/","name":"\u8dd1\u9a6c\u706f\u7ba1\u7406","pId":"100","target":"mainframe"},{"rid":"3","rescode":"100002","resindex":"","resurl":"manageController\/getQuestionListAc","name":"\u95ee\u9898\u53cd\u9988","pId":"100","target":"mainframe"},{"rid":"4","rescode":"100003","resindex":"","resurl":"manageController\/getMallListAc","name":"\u5546\u54c1\u7ba1\u7406","pId":"100","target":"mainframe"},{"rid":"5","rescode":"100004","resindex":"","resurl":"manageController\/getVersionListAc","name":"\u7248\u672c\u7ba1\u7406","pId":"100","target":"mainframe"},{"rid":"6","rescode":"100005","resindex":"","resurl":"manageController\/getSourceListAc","name":"\u6765\u6e90\u7ba1\u7406","pId":"100","target":"mainframe"},{"rid":"7","rescode":"100006","resindex":"","resurl":"manageController\/userManageAc","name":"\u7528\u6237\u7ba1\u7406","pId":"100","target":"mainframe"},{"rid":"8","rescode":"200","resindex":"","resurl":"","name":"\u7cfb\u7edf\u67e5\u8be2","pId":"","target":"mainframe"},{"rid":"9","rescode":"200001","resindex":"","resurl":"queryController\/getPaymentListAc","name":"\u652f\u4ed8\u67e5\u8be2","pId":"200","target":"mainframe"},{"rid":"10","rescode":"200002","resindex":"","resurl":"queryController\/getExchangeListAc","name":"\u5151\u6362\u67e5\u8be2","pId":"200","target":"mainframe"},{"rid":"11","rescode":"300","resindex":"","resurl":"","name":"\u7edf\u8ba1\u529f\u80fd","pId":"","target":"mainframe"},{"rid":"12","rescode":"300001","resindex":"","resurl":"statController\/getOnLineNumsAc","name":"\u5728\u7ebf\u7edf\u8ba1","pId":"300","target":"mainframe"},{"rid":"13","rescode":"300002","resindex":"","resurl":"statController\/getIncomeAc","name":"\u6536\u5165\u5206\u6790","pId":"300","target":"mainframe"},{"rid":"14","rescode":"300003","resindex":"","resurl":"statController\/getIncomeTotalAc","name":"\u6536\u5165\u6c47\u603b","pId":"300","target":"mainframe"},{"rid":"15","rescode":"300004","resindex":"","resurl":"statController\/userStatAc","name":"\u7528\u6237\u7edf\u8ba1","pId":"300","target":"mainframe"},{"rid":"16","rescode":"900","resindex":"","resurl":"","name":"\u7cfb\u7edf\u6743\u9650\u7ba1\u7406","pId":"","target":"mainframe"},{"rid":"17","rescode":"900001","resindex":"","resurl":"userController\/userListAc\/","name":"\u64cd\u4f5c\u5458\u7ba1\u7406","pId":"900","target":"mainframe"},{"rid":"18","rescode":"900002","resindex":"","resurl":"userController\/deptListAc\/","name":"\u90e8\u95e8\u7ba1\u7406","pId":"900","target":"mainframe"},{"rid":"19","rescode":"900003","resindex":"","resurl":"userController\/roleListAc\/","name":"\u89d2\u8272\u7ba1\u7406","pId":"900","target":"mainframe"},{"rid":"20","rescode":"900004","resindex":"","resurl":"userController\/sourceListAc\/","name":"\u8d44\u6e90\u7ba1\u7406","pId":"900","target":"mainframe"}]';
		$this->display("login/loginIndex.html");
	}	
	
	//退出登录
	function loginOut()
	{
		session_destroy();
		$this->display("login/login.html");
	}
	
	
	
	
}	