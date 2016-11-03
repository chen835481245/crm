<?php
class email extends spModel
{
	public function clientList($is_gw=0)
	{
		$result=array();
		$data=array();
		$page=$_REQUEST['page'];
		if (!is_numeric($page) || $page <= 0)
		{
			$page = 1;
		}
		$pagesize = 20;
		if($_REQUEST['out']=='1'){
			$pagesize=100000;
		}
		$start = ($page - 1) * $pagesize;
		$first_name=ucfirst($_REQUEST['first_name']);
		$mail=$_REQUEST['mail'];
		$begin_date=$_REQUEST['begin_date'];
		$end_date=$_REQUEST['end_date'];

		$first_name_sql=$first_name==''?'':" and (t1.first_name='$first_name' or t1.last_name='$first_name')";
		$mail_sql=$mail==''?'':" and t1.mail='$mail'";
		if($begin_date!=''&&$end_date!=''){
			$date_sql=" and t1.datetime BETWEEN '$begin_date' AND '$end_date 23:59:59'";
		}else{
			$date_sql='';
		}

		if($_SESSION['level']>2){
			$operid=$_REQUEST['operid'];
			$operidSql=$operid==''?'':" and t1.operid='$operid'";
			if($_SESSION['level']==3){
				$operidSql.=" and t1.operid not in('sa','admin')";
			}
		}else{
			$operid=$_SESSION['opid'];
			$operidSql=" and t1.operid='$operid'";
		}

		$sql="SELECT t1.*,t2.`name` as opername from client_email t1 LEFT JOIN
		admin_user t2 ON t1.operid=t2.operid 
		where 1=1  $first_name_sql $mail_sql $date_sql $operidSql LIMIT $start,$pagesize";

		$sqlNum="select count(1) num from client_email t1 where 1=1
		$first_name_sql $mail_sql $date_sql $operidSql";
			
		if($_REQUEST['isSelect']==1){
			$data=$this->getAll($sql);
			foreach ($data as $key=>$val){
				$data[$key]['datetime']=date("Y-m-d",strtotime($val['datetime']));
			}
			$numRes=$this->getOne($sqlNum);
		}
		$result['data']=$data;
		$total=intval($numRes['num']);
		$linkUrl=spUrl('emailController','clientListAc');
		$linkUrl.="&isSelect=1&first_name=".
		$first_name."&mail=".$mail."&begin_date=".$begin_date."&end_date=".$end_date;
		$result['linkBar'] = multi($total, $pagesize, $page, $linkUrl);
		return $result;
	}
	function blackList()
	{
		$result=array();
		$data=array();
		$page=$_REQUEST['page'];
		if (!is_numeric($page) || $page <= 0)
		{
			$page = 1;
		}
		$pagesize = 20;
		$start = ($page - 1) * $pagesize;
		$mail=$_REQUEST['mail'];
		$mail_sql=$mail==''?'':" and t1.mail='$mail'";

		$sql="SELECT t1.*,t2.`name` as opername from client_black t1 LEFT JOIN
		admin_user t2 ON t1.operid=t2.operid 
		where 1=1   $mail_sql  LIMIT $start,$pagesize";

		$sqlNum="select count(1) num from client_black t1 where 1=1
		$mail_sql ";
			
		$data=$this->getAll($sql);
		foreach ($data as $key=>$val){
			$data[$key]['datetime']=date("Y-m-d",strtotime($val['datetime']));
		}
		$numRes=$this->getOne($sqlNum);
		$result['data']=$data;
		$total=intval($numRes['num']);
		$linkUrl=spUrl('emailController','blackListAc');
		$linkUrl.="&mail=".$mail;
		$result['linkBar'] = multi($total, $pagesize, $page, $linkUrl);
		return $result;

	}
	function addAll()
	{
		require_once 'library/Excel/reader.php';
		$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('CP936');
		$file=$_FILES['fileExcel'];
		if($file['error']!=0){
			echo "<script language=javascript>alert('上传文件失败！');</script>";
			exit;
		}
		$data->read($file['tmp_name']);
		$trueNum=0;
		$falseNum=0;
		$str='';
		//邮件	first_name	last_name	国家(要英文)	备注	操作员（空则为当前用户）
		for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
			$tmpData=array();
			for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
				$tmpData[]=$data->sheets[0]['cells'][$i][$j];
			}
			$res=$this->doClientAdd($tmpData);
			if($res['success']){
				$trueNum++;
			}else{
				$falseNum++;
			}
		}
		$i=$i-2;
		if($falseNum==0){
			$msg="处理结束，共处理：".$i."个，成功：".$i."个";
		}else{
			$msg="处理结束，共处理：".$i."个，成功：".$trueNum."个，失败：".$falseNum."个。";
		}
		$res['msg']=$msg;
		return $res;
	}
	function doClientAdd($tmpData)
	{
		$row['mail']=$tmpData[0];
		$row['datetime']=date("Y-m-d H;i:s");
		$row['first_name']=iconv("gbk", 'utf-8', ucfirst($tmpData[1]));
		$row['last_name']=iconv("gbk", 'utf-8', ucfirst($tmpData[2]));
		$row['country']=iconv("gbk", 'utf-8', $tmpData[3]);
		$row['remark']=iconv("gbk", 'utf-8', $tmpData[4]);
		$row['operid']=$tmpData[5]==''?$_SESSION['opid']:iconv("gbk", 'utf-8', $tmpData[5]);
		
		$email=$tmpData[0];
		if($this->exist('client_email',array('mail'=>$email))){
			$res['success']=false;
			return $res;
		}
		if($this->exist('client_black',array('mail'=>$email))){
			$res['success']=false;
			$res['name']=$row['mail'];
			return $res;
		}
		$falg=$this->table('client_email')->create($row);
		if($falg){
			$res['success']=true;
		}else{
			$res['success']=false;
		}
		return $res;
	}
	
	function addEmailClient()
	{
		$flag=false;
		$row=$_POST;
		$row['first_name']=ucfirst($row['first_name']);
		$row['last_name']=ucfirst($row['last_name']);
		$row['operid']=$_SESSION['opid'];
		unset($row['id']);
		$param=array();
		$row['datetime']=date("Y-m-d H:i:s");
		$row['deal_date']=date("Y-m-d");
		if(!$this->exist('client_email',array('mail'=>$row['mail']))){
			$flag=$this->table('client_email')->create($row);
		}
		return $flag;
	}
	








}