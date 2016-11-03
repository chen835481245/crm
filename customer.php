<?php
date_default_timezone_set('PRC');
define("APP_PATH",dirname(__FILE__));//根目录
require_once APP_PATH.'/library/function.php';
define("BASE_PATH",dirname(getBasePath()));
require_once APP_PATH.'/config/define.php';
require_once APP_PATH.'/config/config.php';
require_once APP_PATH.'/library/routingAdmin.php';

$mail=$_POST['mail'];
$obj=new spModel();
if($mail!=''){
	$sql1="SELECT t1.datetime as date,t1.content,t3.`name` as opername from dynamic_track t1 
	LEFT JOIN admin_user t3 on t1.operid=t3.operid ,client t2 
	where t1.client_id=t2.id and t2.mail='$mail' order by t1.id desc limit 0,20";

	$sql2="SELECT t1.datetime as date,t1.content,t3.`name` as opername from market_track t1 
	LEFT JOIN admin_user t3 on t1.operid=t3.operid ,client t2 
	where t1.client_id=t2.id and t2.mail='$mail' order by t1.id desc limit 0,20";
	
	$data1=$obj->getAll($sql1);
	$data2=$obj->getAll($sql2);
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
<form action="customer.php" method="post">
	<div style='text-align:left;font-size:12px;'>
	邮箱：
	<input type="text" name='mail' id='mail' value='<?php echo $mail;?>'>
	<input type="submit" value='查 询'/>
</div>
</form>
<table class="imagetable">
<tr>
	<th>日常动态</th>
</tr>
<table class="imagetable">
<tr>
	<th style='width:100px;'>时间</th>
	<th style='width:500px;'>动态内容</th>
	<th style='width:100px;'>操作人</th>
</tr>
<?php 
if(empty($data1)){
	echo "<tr><td colspan='3'>暂无此记录</td></tr>"	;
}else{
foreach ($data1 as $key=>$val){
?>
<tr>
	<td><?php echo $val['date'];?></td>
	<td><?php echo $val['content'];?></td>
	<td><?php echo $val['opername'];?></td>
</tr>
<?php }}?>
</table>


<br>
<table class="imagetable">
<tr>
	<th>营销动态</th>
</tr>
</table>
<table class="imagetable">
<tr>
	<th style='width:100px;'>时间</th>
	<th style='width:500px;'>动态内容</th>
	<th style='width:100px;'>操作人</th>
</tr>
<?php 
if(empty($data2)){
	echo "<tr><td colspan='3'>暂无此记录</td></tr>"	;
}else{
foreach ($data2 as $key=>$val){
?>
<tr>
	<td><?php echo $val['date'];?></td>
	<td><?php echo $val['content'];?></td>
	<td><?php echo $val['opername'];?></td>
</tr>
<?php }}?>
</table>
</div>
</body>
</html>


