<?php
/**
 * 
 * 文件上传的各种判断
 * @author yjj
 *
 */
class UploadController extends spController
{
	/**
	 * 单个文件上传
	 */
	function doUploadFileAc()
	{
		$obj=new Upload();
		$res=$obj->uploadOneFile();
		echo json_encode($res);
		exit;
	}
	public function onCancelAc()
	{
		$obj=new Upload();
		$fileName=$_REQUEST['fileName'];
		$dir=$_REQUEST['dir'];
		$flag=$obj->onCancel($fileName,$dir);
		$res=$this->returnMsg($flag);
		echo json_encode($res);
		exit;
	}
	//上传文件
	public function uploadFileAc()
	{
		$obj=new Upload();
		$res=$obj->uploadFile();
		echo json_encode($res);
		exit;
	}
	public function deleteFileAc()
	{
		$obj=new Upload();
		$fileName=$_REQUEST['fileName'];
		$flag=$obj->deleteFile($fileName);
		$res=$this->returnMsg($flag);
		echo json_encode($res);
		exit;
	}
}