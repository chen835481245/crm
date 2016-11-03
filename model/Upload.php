<?php
/**
 *
 * 上传
 * @author ch
 *
 */
class Upload extends spModel
{
	public function uploadOneFile()
	{
		$file=$_FILES["Filedata"];
		$path=$_REQUEST['filedir'];
		$pathtype=$_REQUEST['pathtype'];
		if($pathtype=='date'){
			$path=$path.date('Ymd').'/';
		}
		if ($file["error"] != 0)
		{
			$res['success']=false;
			$res['msg']='上传失败';
			return $res;
		}
		$filename=date("YmdHis").rand(10000, 99999).'.'.pathinfo($file['name'], PATHINFO_EXTENSION);
		$directory=APP_PATH.'/file/'.$path;
		mkpath($directory);
		$filePath=$directory.$filename;
		if($_REQUEST['uploadtype']=='thumb2'){
			$width=$_REQUEST['width'];
			$height=$_REQUEST['height'];
			$isUpload=Image::thumb2($file["tmp_name"], $filePath,'',$width,$height,true);
		}else{
			$isUpload=move_uploaded_file($file["tmp_name"],$filePath);
		}
		if(!$isUpload){
			writeLog($filePath);
			$res['success']=false;
			$res['msg']='上传失败，无法移动该文件';
			return $res;
		}
			
		$res['success']=true;
		$res['msg']='success';
		$res['fileName']=$filename;
		$res['filePath']=$filePath;
		$res['src']="file/".$path.$filename;
		$res['size']=$file['size'];
		return $res;
	}
	public function onCancel($fileName,$dir)
	{
		$filePath=APP_PATH.'/file/'.$dir.'/'.$fileName;
		if(!file_exists($filePath)){
			writeLog('文件不存在'.$filePath,'e');
			return false;
		}
		$flag=unlink($filePath);
		if($flag){
			writeLog('删除文件失败'.$filePath,'e');
			return false;			
		}else{
			return true;		
		}
	}
	public function uploadFile()
	{
		$file=$_FILES["Filedata"];
		$path=$_REQUEST['filedir'];
		$pathtype=$_REQUEST['pathtype'];
		if($pathtype=='date'){
			$path=$path.date('Ymd').'/';
		}
		if ($file["error"] != 0)
		{
			$res['success']=false;
			$res['msg']='上传失败';
			return $res;
		}
		$filename=createOrderNo().'.'.pathinfo($file['name'], PATHINFO_EXTENSION);
		$directory=APP_PATH.'/file/'.$path;
		mkpath($directory);
		$filePath=$directory.$filename;
		if($_REQUEST['uploadtype']=='thumb2'){
			$width=$_REQUEST['width'];
			$height=$_REQUEST['height'];
			$isUpload=Image::thumb2($file["tmp_name"], $filePath,'',$width,$height,true);
		}else{
			$isUpload=move_uploaded_file($file["tmp_name"],$filePath);
		}
		if(!$isUpload){
			writeLog($filePath);
			$res['success']=false;
			$res['msg']='上传失败，无法移动该文件';
			return $res;
		}
		$res['success']=true;
		$res['msg']='success';
		$res['fileName']=$filename;
		$res['filePath']="file/".$path.$filename;
		$res['size']=$file['size'];
		return $res;
	}
	public function deleteFile($fileName)
	{
		$filePath=APP_PATH.'/'.$fileName;
		if(!file_exists($filePath)){
			writeLog('文件不存在'.$filePath,'e');
			return false;
		}
		$flag=unlink($filePath);
		if($flag){
			writeLog('删除文件失败'.$filePath,'e');
			return false;			
		}else{
			return true;		
		}
	}
	

}