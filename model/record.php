<?php
class record extends spModel
{
	public function checking()
	{
		$data=array();
		$selectText=$_POST['selectText'];
		$selectTextIn=str_replace(' ', '', $selectText);
		$mail=$_POST['mail'];
		$clientname=$_POST['clientname'];

		if($selectTextIn!=''||$mail!=''||$clientname!='') {
			$selectType = $_REQUEST['selectType'];
			if ($mail != '') {
				if ($selectType == 1) {
					$mailSql = " and t1.mail = '$mail'";
				} else {
					$mailSql = " and t1.mail like '%$mail%' ";
				}
			}
			$company_name_sql=$clientname==''?'':" and t1.company_name like '%$clientname%'";
			$selectTextSql=$selectTextIn==''?'':" and CONCAT(first_name,last_name) LIKE '%$selectTextIn%'";
	
			$sql="SELECT t1.*,t2.`name` as opername,t3.`name` as type_name from client t1 LEFT JOIN
				admin_user t2 ON t1.operid=t2.operid 
				LEFT JOIN client_type t3 ON t1.client_type=t3.id
				where 1=1 $company_name_sql $selectTextSql $mailSql  LIMIT 0,20";
			$data=$this->getAll($sql);
		}
		return $data;
	}
	function customer()
	{
		$data=$data1=$data2=array();
		$mail=$_POST['mail'];
		if($mail!=''){
			$selectType=$_REQUEST['selectType'];
			if($selectType==1){
				$mailSql=" and t2.mail = '$mail'";
			}else{
				$mailSql=" and t2.mail like '%$mail%' ";
			}
			$sql1="SELECT t2.first_name ,t2.last_name,t1.datetime as date,t1.content,t3.`name` as opername from dynamic_track t1 
			LEFT JOIN admin_user t3 on t1.operid=t3.operid ,client t2 
			where t1.client_id=t2.id $mailSql order by t1.id desc limit 0,20";
			
			$sql2="SELECT t2.first_name ,t2.last_name,t1.datetime as date,t1.content,t3.`name` as opername from market_track t1 
			LEFT JOIN admin_user t3 on t1.operid=t3.operid ,client t2 
			where t1.client_id=t2.id $mailSql order by t1.id desc limit 0,20";
	
			$data1=$this->getAll($sql1);
			$data2=$this->getAll($sql2);
		}	
		$data['data1']=$data1;
		$data['data2']=$data2;
		return $data;
	}
	function dynamicList()
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
		$numRes=0;
		$mail=$_REQUEST['mail'];
		$content=$_REQUEST['content'];
		$keyword=$_REQUEST['keyword'];
		$begin_date=$_REQUEST['begin_date'];
		$end_date=$_REQUEST['end_date'];
		if($begin_date==''){
			$end_date=$begin_date=date("Y-m-d");
		}
		$is_help=$_REQUEST['is_help'];

		$content_sql=$content==''?'':" and t1.content like '%$content%'";
		$keyword_sql=$keyword==''?'':" and t1.keyword='$keyword'";
		$mail_sql=$mail==''?'':" and t2.mail='$mail'";

		if($_SESSION['level']>2){
			$operid=$_REQUEST['operid'];
			$operidSql=$operid==''?'':" and t2.operid='$operid'";
			if($_SESSION['level']==3){
				$operidSql.=" and t2.operid not in('sa','admin')";
			}
		}else{
			$operid=$_SESSION['opid'];
			$operidSql=" and t2.operid='$operid'";
		}

		if($begin_date!=''&&$end_date!=''){
			$dateSql=" and t1.datetime BETWEEN '$begin_date' and '$end_date 23:59:59'";
		}
		$is_help_sql=$is_help==''?'':" and t1.is_help='$is_help'";

		$sql="select t1.*,t2.first_name,t2.last_name,t2.mail,t3.`name` as opername,t2.client_type
		 from dynamic_track t1,
		client t2 LEFT JOIN admin_user t3 ON t2.operid=t3.operid
		where t1.client_id=t2.id $content_sql $is_help_sql $keyword_sql $mail_sql $operidSql $dateSql 
		order by t1.datetime desc
		LIMIT $start,$pagesize";
		$sqlNum="select count(1) num from dynamic_track t1,client t2 where t1.client_id=t2.id
		$content_sql $keyword_sql $mail_sql $operidSql $dateSql $is_help_sql";

		if($_REQUEST['isSelect']==1){
			$data=$this->getAll($sql);
			$sqlType="select id,`name` from client_type";
			$types=$this->getArray($sqlType,1);
			foreach ($data as $key=>$val){
				if($val['is_help']==1){
					$data[$key]['help_name']='需协助';
				}else{
					$data[$key]['help_name']='否';
				}
				$data[$key]['client_type_name']=$types[$val['client_type']];
			}
			$numRes=$this->getOne($sqlNum);
		}
		$result['data']=$data;
		$total=intval($numRes['num']);
		$linkUrl=spUrl('recordController','dynamicListAc');
		$linkUrl.="&isSelect=1&content=$content&keyword=".$keyword."&operid=".
		$operid."&mail=".$mail."&is_help=".$is_help."&begin_date=".$begin_date."&end_date=".$end_date;
		$result['linkBar'] = multi($total, $pagesize, $page, $linkUrl);
		return $result;

	}

	function marketList()
	{
		$result=array();
		$numRes=0;
		$data=array();
		$page=$_REQUEST['page'];
		if (!is_numeric($page) || $page <= 0)
		{
			$page = 1;
		}
		$pagesize = 20;
		$start = ($page - 1) * $pagesize;

		$mail=$_REQUEST['mail'];
		$content=$_REQUEST['content'];
		$keyword=$_REQUEST['keyword'];
		$begin_date=$_REQUEST['begin_date'];
		$end_date=$_REQUEST['end_date'];
		if($begin_date==''){
			$end_date=$begin_date=date("Y-m-d");
		}

		$openid=$_REQUEST['openid'];
		$name=$_REQUEST['name'];

		$content_sql=$content==''?'':" and t1.content like '%$content%'";
		$keyword_sql=$keyword==''?'':" and t1.keyword='$keyword'";
		$mail_sql=$mail==''?'':" and t2.mail='$mail'";

		if($_SESSION['level']>2){
			$operid=$_REQUEST['operid'];
			$operidSql=$operid==''?'':" and t2.operid='$operid'";
			if($_SESSION['level']==3){
				$operidSql.=" and t2.operid not in('sa','admin')";
			}
		}else{
			$operid=$_SESSION['opid'];
			$operidSql=" and t2.operid='$operid'";
		}

		if($begin_date!=''&&$end_date!=''){
			$dateSql=" and t1.datetime BETWEEN '$begin_date' and '$end_date 23:59:59'";
		}
		$openid_sql=$openid==''?'':" and t1.openid='$openid'";
		$name_sql=$name==''?'':" and t2.first_name='$name'";



		$sql="select t1.*,t2.first_name,t2.last_name,t2.mail,t3.`name` as opername,t2.client_type from market_track t1,
		client t2 LEFT JOIN admin_user t3 ON t2.operid=t3.operid
		where t1.client_id=t2.id $openid_sql $name_sql $content_sql $keyword_sql $mail_sql $operidSql $dateSql 
		order by t1.datetime desc
		LIMIT $start,$pagesize";

		if($_REQUEST['isSelect']==1){
			$sqlNum="select count(1) num from market_track t1,client t2 where t1.client_id=t2.id
			$content_sql $keyword_sql $mail_sql $operidSql $dateSql $openid_sql $name_sql";

			$data=$this->getAll($sql);
			$sqlType="select id,`name` from client_type";
			$types=$this->getArray($sqlType,1);
			foreach ($data as $key=>$val){
				if($val['is_back']==1){
					$data[$key]['back_name']='有反馈';
				}else{
					$data[$key]['back_name']='无反馈';
				}
				$data[$key]['client_type_name']=$types[$val['client_type']];
			}
			$numRes=$this->getOne($sqlNum);
		}
		$result['data']=$data;
		$total=intval($numRes['num']);
		$linkUrl=spUrl('recordController','marketListAc');
		$linkUrl.="&isSelect=1&content=$content&keyword=".$keyword."&operid=".
		$operid."&mail=".$mail."&openid=".$openid."&name=".$name."&begin_date=".$begin_date."&end_date=".$end_date;
		$result['linkBar'] = multi($total, $pagesize, $page, $linkUrl);
		return $result;
	}


}