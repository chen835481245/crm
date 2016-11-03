<?php
date_default_timezone_set('PRC');
define("APP_PATH",dirname(__FILE__));//根目录
require_once APP_PATH.'/library/function.php';
define("BASE_PATH",dirname(getBasePath()));
require_once APP_PATH.'/config/define.php';
require_once APP_PATH.'/config/config.php';
require_once APP_PATH.'/library/routingAdmin.php';


$selectText=$_POST['selectText'];
$selectTextIn=str_replace(' ', '', $selectText);
$mail=$_POST['mail'];
$clientname=$_POST['clientname'];

if($selectTextIn!=''||$mail!=''||$clientname!=''){
	$obj=new spModel();
	$mailSql=$mail==''?'':" and mail='$mail'";
	$company_name_sql=$clientname==''?'':" and t1.company_name like '%$clientname%'";
	$selectTextSql=$selectTextIn==''?'':" and CONCAT(first_name,last_name) LIKE '%$selectTextIn%'";
	
	$sql="SELECT t1.*,t2.`name` as opername,t3.`name` as type_name from client t1 LEFT JOIN
		admin_user t2 ON t1.operid=t2.operid 
		LEFT JOIN client_type t3 ON t1.client_type=t3.id
		where 1=1 $company_name_sql $selectTextSql $mailSql  LIMIT 0,20";
	$data=$obj->getAll($sql);
}
?>
<!-- CSS goes in the document HEAD or added to your external stylesheet -->
<!DOCTYPE style PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
table.imagetable {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#333333;
	border-width: 1px;
	border-color: #999999;
	border-collapse: collapse;
}
table.imagetable th {
	background:#b5cfd2 url('cell-blue.jpg');
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #999999;
	width:200px;
}
table.imagetable td {
	background:#dcddc0 url('cell-grey.jpg');
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #999999;
}
</style>
</head>
<!-- Table goes in the document BODY -->
<body>
<div style='width:1000px;padding:10px 0px 0px 20px'>
<form action="checking.php" method="post">
	<div style='text-align:left;font-size:12px;'>
	公司名称:
	<input type="text" name='clientname' id='clientname' value='<?php echo $clientname;?>'>
	&nbsp;&nbsp;
	输入客户姓名:
	<input type="text" name='selectText' id='selectText' value='<?php echo $selectText;?>'>
	&nbsp;&nbsp;
	邮箱：
	<input type="text" name='mail' id='mail' value='<?php echo $mail;?>'>
	<input type="submit" value='查 询'/>
</div>
</form>

<table class="imagetable">
<tr>
	<th>公司名称 </th>
	<th>客户姓名</th>
	<th>国家</th>
	<th>客户当前的分组</th>
	<th>创建时间</th>
	<th>拥有者</th>
</tr>
<?php 
if(empty($data)){
	echo "<tr><td colspan='7'>未查到此人</td></tr>"	;
}else{
foreach ($data as $key=>$val){
?>
<tr>
	<td><?php echo $val['company_name'];?></td>
	<td><?php echo $val['first_name'].' '.$val['last_name'];?></td>
	<td><?php echo $val['country'];?></td>
	<td><?php echo $val['type_name'];?></td>
	<td><?php echo $val['datetime'];?></td>
	<td><?php echo $val['opername'];?></td>
</tr>
<?php }}?>
</table>
</div>
</body>
</html>


