<?php
class pub  extends spModel
{
	function getProvince()
	{
		$sql="select province_id,province_name from province";
		$data=$this->getArray($sql,1);
		return $data;
	}
	function getCity($provinceIn)
	{
		$province=$_POST['province'];
		$province=$province==''?$provinceIn:$province;
		$sql="select city_id,city_name from city where city_up_id='$province'";
		return $this->getArray($sql,1);
	}
	function getDistrict($cityIn)
	{
		$city=$_POST['city'];
		$city=$city==''?$cityIn:$city;
		$sql="select district_id,district_name from district where district_up_id='$city' and valid=1";
		return $this->getArray($sql,1);
	}
	function getArea()
	{
		$district=$_POST['district'];
		$sql="select area_id,area_name from area where area_up_id='$district'";
		return $this->getArray($sql,1);
	}
	/**
	 * 得到部门数组
	 */
	function getDept()
	{
		$deptid=$_REQUEST['deptid'];
		$deptSql=" and deptid='$deptid'";
		$sql="select deptid,dept_name from admin_dept where 1";
		$data=$this->getArray($sql);
		return $data;
	}
	function outExcelCommon($data,$titleArr,$keyArr,$fileName='',$arrReplaceName='')
	{
		if($fileName==''){$fileName=date('Ymd');}
		header("Content-Type: application/vnd.ms-excel");
		header('Pragma: public');
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: public");
		header('Expires: 0');
		header("Content-Transfer-Encoding: binary");
		header("Content-Disposition: attachment; filename={$fileName}.xls");
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		echo '<table border="1" cellspacing="2" cellpadding="2" width="80%" align="center">';
		echo '<tr>';
		foreach($titleArr as $key=>$val){
			echo "<td style='width:140px;'>".$val."</td>";
		}
		echo '</tr>';
		if($data){
			foreach($data as $key=>$val){
				echo "<tr>";
				foreach($keyArr as $key1=>$val1){
					if($val["$val1"]!=' '&&$val["$val1"]!=''){
						if(is_array($arrReplaceName)){
							foreach($arrReplaceName as $replaceKey=>$replaceVal){
								if($val1==$replaceVal){
									$val["$val1"]="'".$val["$val1"];
								}
							}
						}
					}
					//$val["$val1"]=iconv('gbk', 'utf-8', $val["$val1"]);
					echo "<td align='right'>".$val["$val1"]."</td>";
				}
				echo "</tr>";
			}
		}
		echo '</table>';
	}
	public function getQxRescode()
	{
		$c=$_REQUEST['c'];
		$a=$_REQUEST['a'];
		$key=$c.'/'.$a;
		if(!empty($_SESSION['qxRescode']))
		return $_SESSION['qxRescode'][$key];
		$sql="SELECT resurl,rescode from admin_resource where resurl <>''";
		$data=$this->getArray($sql,1);
		$_SESSION['qxRescode']=$data;
		return $_SESSION['qxRescode'][$key];
	}
	

	
	

	
	
	
	
}