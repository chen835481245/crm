<?php
class gnclient extends spModel
{
	public function clientList($is_gw=0,$pagesize =20)
	{
		$result=array();
		$data=array();
		$page=$_REQUEST['page'];
		if (!is_numeric($page) || $page <= 0)
		{
			$page = 1;
		}
		$start = ($page - 1) * $pagesize;
		$company_name=$_REQUEST['company_name'];
		$first_name=$_REQUEST['first_name'];
		$mail=$_REQUEST['mail'];
		$client_type=$_REQUEST['client_type'];
		$begin_date=$_REQUEST['begin_date'];
		$end_date=$_REQUEST['end_date'];
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
		
		$company_name_sql=$company_name==''?'':" and t1.company_name like '%$company_name%'";
		$first_name_sql=$first_name==''?'':" and t1.first_name='$first_name'";
		$mail_sql=$mail==''?'':" and t1.mail='$mail'";
		$client_type_sql=$client_type==''?'':" and t1.client_type='$client_type'";
		if($begin_date!=''&&$end_date!=''){
			$date_sql=" and t1.datetime BETWEEN '$begin_date' AND '$end_date 23:59:59'";
		}else{
			$date_sql='';
		}

		$sql="SELECT t1.*,t2.`name` as opername,t3.`name` as type_name from client t1 LEFT JOIN
		admin_user t2 ON t1.operid=t2.operid 
		LEFT JOIN client_type t3 ON t1.client_type=t3.id
		where t1.is_gw=$is_gw and is_pub=0 $company_name_sql $operidSql $first_name_sql $mail_sql $date_sql $client_type_sql
		LIMIT $start,$pagesize";

		$sqlNum="select count(1) num from client t1 where t1.is_gw=$is_gw and is_pub=0
		$company_name_sql $first_name_sql $mail_sql $date_sql $operidSql $client_type_sql";

		if($_REQUEST['isSelect']==1){
			$data=$this->getAll($sql);
			$numRes=$this->getOne($sqlNum);
		}
		$result['data']=$data;
		$total=intval($numRes['num']);
		if($is_gw==1){
			$linkUrl=spUrl('gwclientController','clientListAc');
		}else{
			$linkUrl=spUrl('gnclientController','clientListAc');
		}
		
		$linkUrl.="&isSelect=1&company_name=".$company_name."&first_name=".
		$first_name."&mail=".$mail."&begin_date=".$begin_date."&end_date=".$end_date."&operid=".$operid;
		$result['linkBar'] = multi($total, $pagesize, $page, $linkUrl);
		return $result;
	}
	function getClientTypes()
	{
		$sql="select id,name from client_type";
		$res=$this->getArray($sql,1);
		return $res;
	}
	function clientMore()
	{
		$id=$_REQUEST['id'];
		$sql="SELECT t1.*,t2.`name` as opername,t3.`name` as type_name from client t1 LEFT JOIN
		admin_user t2 ON t1.operid=t2.operid 
		LEFT JOIN client_type t3 ON t1.client_type=t3.id
		where t1.id='$id'";
		$data=$this->getOne($sql);
		return $data;
	}
	function clientPubList($is_gw=0)
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
		$company_name=$_REQUEST['company_name'];
		$first_name=$_REQUEST['first_name'];
		$mail=$_REQUEST['mail'];
		$begin_date=$_REQUEST['begin_date'];
		$end_date=$_REQUEST['end_date'];

		$company_name_sql=$company_name==''?'':" and t1.company_name like '%$company_name%'";
		$first_name_sql=$first_name==''?'':" and t1.first_name='$first_name'";
		$mail_sql=$mail==''?'':" and t1.mail='$mail'";
		if($begin_date!=''&&$end_date!=''){
			$date_sql=" and t1.datetime BETWEEN '$begin_date' AND '$end_date 23:59:59'";
		}else{
			$date_sql='';
		}

		$sql="SELECT t1.*,t2.`name` as opername,t3.`name` as type_name from client t1 LEFT JOIN
		admin_user t2 ON t1.operid=t2.operid 
		LEFT JOIN client_type t3 ON t1.client_type=t3.id
		where t1.is_gw=$is_gw and is_pub=1 $company_name_sql $first_name_sql $mail_sql $date_sql LIMIT $start,$pagesize";

		$sqlNum="select count(1) num from client t1 where t1.is_gw=$is_gw and is_pub=1
		$company_name_sql $first_name_sql $mail_sql $date_sql";

		$data=$this->getAll($sql);
		$numRes=$this->getOne($sqlNum);
		$result['data']=$data;
		$total=intval($numRes['num']);
		$linkUrl=spUrl('gnclientController','clientPubListAc');
		$linkUrl.="&isSelect=1&company_name=".$company_name."&first_name=".
		$first_name."&mail=".$mail."&begin_date=".$begin_date."&end_date=".$end_date;
		$result['linkBar'] = multi($total, $pagesize, $page, $linkUrl);
		return $result;
	}
	function getClients()
	{
		$operidSql='';
		if($_SESSION['level']<=2){
			$operid=$_SESSION['opid'];
			$operidSql=" and operid='$operid'";
		}
		$sql="select id,first_name as name,mail,company_name 
		from client where 1=1 $operidSql";
		return $this->getAll($sql);
	}
	function getCountryData()
	{
		$countryData=array(0=>array('id'=>'Andorra','name'=>'安道尔'),
		1=>array('id'=>'United Arab Emirates','name'=>'阿联酋'),
		2=>array('id'=>'Afghanistan','name'=>'阿富汗'),
		3=>array('id'=>'Antigua and Barbuda','name'=>'安提瓜和巴布达'),
		4=>array('id'=>'Anguilla','name'=>'安格拉 '),
		5=>array('id'=>'Albania','name'=>'阿尔巴尼亚'),
		6=>array('id'=>'Armenia','name'=>'亚美尼亚'),
		7=>array('id'=>'Netherlands Antilles','name'=>'荷兰属地'),
		8=>array('id'=>'Angola','name'=>'安哥拉'),
		9=>array('id'=>'Argentina','name'=>'阿根廷'),
		10=>array('id'=>'American Samoa','name'=>'东萨摩亚'),
		11=>array('id'=>'Austria','name'=>'奥地利'),
		12=>array('id'=>'Australia','name'=>'澳大利亚'),
		13=>array('id'=>'Aruba','name'=>'阿鲁巴'),
		14=>array('id'=>'Azerbaijan','name'=>'阿塞拜疆'),
		15=>array('id'=>'Bosnia Hercegovina','name'=>'波黑'),
		16=>array('id'=>'Barbados','name'=>'巴巴多斯'),
		17=>array('id'=>'Bangladesh','name'=>'孟加拉国'),
		18=>array('id'=>'Belgium','name'=>'比利时'),
		19=>array('id'=>'Burkina Faso','name'=>'布基纳法索'),
		20=>array('id'=>'Bulgaria','name'=>'保加利亚'),
		21=>array('id'=>'Bahrain','name'=>'巴林'),
		22=>array('id'=>'Burundi','name'=>'布隆迪'),
		23=>array('id'=>'Benin','name'=>'贝宁'),
		24=>array('id'=>'Brunei Darussalam','name'=>'文莱达鲁萨兰国'),
		25=>array('id'=>'Bolivia','name'=>'玻利维亚'),
		26=>array('id'=>'Brazil','name'=>'巴西'),
		27=>array('id'=>'Bahamas','name'=>'巴哈马'),
		28=>array('id'=>'Bhutan','name'=>'不丹'),
		29=>array('id'=>'Botswana','name'=>'伯兹瓦纳'),
		30=>array('id'=>'Belarus','name'=>'白俄罗斯'),
		31=>array('id'=>'Belize','name'=>'伯利兹'),
		32=>array('id'=>'Canada','name'=>'加拿大'),
		33=>array('id'=>'Cocos Islands','name'=>'科科斯群岛'),
		34=>array('id'=>'Central African Republic','name'=>'中非共和国'),
		35=>array('id'=>'Congo','name'=>'刚果'),
		36=>array('id'=>'Switzerland','name'=>'瑞士'),
		37=>array('id'=>'Ivory Coast','name'=>'象牙海岸'),
		38=>array('id'=>'Cook Islands','name'=>'库克群岛'),
		39=>array('id'=>'Chile','name'=>'智利'),
		40=>array('id'=>'Cameroon','name'=>'喀麦隆'),
		41=>array('id'=>'China','name'=>'中国'),
		42=>array('id'=>'Colombia','name'=>'哥伦比亚'),
		43=>array('id'=>'Equatorial Guinea','name'=>'赤道几内亚'),
		44=>array('id'=>'Costa Rica','name'=>'哥斯达黎加'),
		45=>array('id'=>'Cuba','name'=>'古巴'),
		46=>array('id'=>'Christmas Island','name'=>'圣诞岛（英属）'),
		47=>array('id'=>'Cyprus','name'=>'塞浦路斯'),
		48=>array('id'=>'Czech Republic','name'=>'捷克共和国'),
		49=>array('id'=>'Germany','name'=>'德国'),
		50=>array('id'=>'Djibouti','name'=>'吉布提'),
		51=>array('id'=>'Denmark','name'=>'丹麦'),
		52=>array('id'=>'Dominica','name'=>'多米尼加联邦'),
		53=>array('id'=>'Dominican Republic','name'=>'多米尼加共和国'),
		54=>array('id'=>'Algeria','name'=>'阿尔及利亚'),
		55=>array('id'=>'Ecuador','name'=>'厄瓜多尔'),
		56=>array('id'=>'Estonia','name'=>'爱沙尼亚'),
		57=>array('id'=>'Egypt','name'=>'埃及'),
		58=>array('id'=>'Western Sahara','name'=>'西萨摩亚'),
		59=>array('id'=>'Spain','name'=>'西班牙'),
		60=>array('id'=>'Ethiopia','name'=>'埃塞俄比亚'),
		61=>array('id'=>'El Salvador','name'=>'萨尔瓦多'),
		62=>array('id'=>'Finland','name'=>'芬兰'),
		63=>array('id'=>'Fiji','name'=>'斐济'),
		64=>array('id'=>'Falkland Islands','name'=>'福克兰群岛'),
		65=>array('id'=>'Micronesia','name'=>'密克罗尼西亚'),
		66=>array('id'=>'Faroe Islands','name'=>'法罗群岛'),
		67=>array('id'=>'France','name'=>'法国'),
		68=>array('id'=>'Gobon','name'=>'加蓬'),
		69=>array('id'=>'Great Britain (UK)','name'=>'大不列颠联合王国'),
		70=>array('id'=>'Grenada','name'=>'格林纳达'),
		71=>array('id'=>'Georgia','name'=>'格鲁吉亚'),
		72=>array('id'=>'French Guiana','name'=>'法属圭亚那'),
		73=>array('id'=>'Ghana','name'=>'加纳'),
		74=>array('id'=>'Gibraltar','name'=>'直布罗陀'),
		75=>array('id'=>'Greenland','name'=>'格陵兰群岛'),
		76=>array('id'=>'Gambia','name'=>'冈比亚'),
		77=>array('id'=>'Guynea','name'=>'几内亚'),
		78=>array('id'=>'Guadeloupe','name'=>'瓜德罗普岛（法属）'),
		79=>array('id'=>'Greece','name'=>'希腊'),
		80=>array('id'=>'Guatemala','name'=>'危地马拉'),
		81=>array('id'=>'Guam','name'=>'关岛'),
		82=>array('id'=>'Guinea-Bissau','name'=>'几内亚比绍'),
		83=>array('id'=>'Guyana','name'=>'圭亚那'),
		84=>array('id'=>'Honduras','name'=>'洪都拉斯'),
		85=>array('id'=>'Croatia','name'=>'克罗蒂亚'),
		86=>array('id'=>'Haiti','name'=>'海地'),
		87=>array('id'=>'Hungary','name'=>'匈牙利'),
		88=>array('id'=>'Indonesia','name'=>'印度尼西亚'),
		89=>array('id'=>'Ireland','name'=>'爱尔兰共和国'),
		90=>array('id'=>'Israel','name'=>'以色列'),
		91=>array('id'=>'India','name'=>'印度'),
		92=>array('id'=>'British Indian Ocean Territory','name'=>'英属印度洋领地'),
		93=>array('id'=>'Iraq','name'=>'伊拉克'),
		94=>array('id'=>'Iran','name'=>'伊朗'),
		95=>array('id'=>'Iceland','name'=>'冰岛'),
		96=>array('id'=>'Italy','name'=>'意大利'),
		97=>array('id'=>'Jamaica','name'=>'牙买加'),
		98=>array('id'=>'Jordan','name'=>'约旦'),
		99=>array('id'=>'Japan','name'=>'日本'),
		100=>array('id'=>'Kenya','name'=>'肯尼亚'),
		101=>array('id'=>'Kyrgyzstan','name'=>'吉尔吉斯斯坦'),
		102=>array('id'=>'Cambodia','name'=>'柬埔塞'),
		103=>array('id'=>'Kiribati','name'=>'基里巴斯'),
		104=>array('id'=>'Comoros','name'=>'科摩罗'),
		105=>array('id'=>'Korea-North','name'=>'北朝鲜'),
		106=>array('id'=>'Korea-South','name'=>'南朝鲜'),
		107=>array('id'=>'Kuwait','name'=>'科威特'),
		108=>array('id'=>'Cayman Islands','name'=>'开曼群岛（英属）'),
		109=>array('id'=>'Kazakhstan','name'=>'哈萨克斯坦'),
		110=>array('id'=>'Lao People s Republic','name'=>'老挝人民共和国'),
		111=>array('id'=>'Lebanon','name'=>'黎巴嫩'),
		112=>array('id'=>'St. Lucia','name'=>'圣露西亚岛'),
		113=>array('id'=>'Liechtenstein','name'=>'列支敦士登'),
		114=>array('id'=>'Sri Lanka','name'=>'斯里兰卡'),
		115=>array('id'=>'Liberia','name'=>'利比里亚'),
		116=>array('id'=>'Lesotho','name'=>'莱索托'),
		117=>array('id'=>'Lithuania','name'=>'立陶宛'),
		118=>array('id'=>'Luxembourg','name'=>'卢森堡'),
		119=>array('id'=>'Latvia','name'=>'拉脱维亚'),
		120=>array('id'=>'Libya','name'=>'利比亚'),
		121=>array('id'=>'Morocco','name'=>'摩洛哥'),
		122=>array('id'=>'Monaco','name'=>'摩纳哥'),
		123=>array('id'=>'Moldova','name'=>'摩尔多瓦'),
		124=>array('id'=>'Madagascar','name'=>'马达加斯加'),
		125=>array('id'=>'Marshall Islands','name'=>'马绍尔群岛'),
		126=>array('id'=>'Mali','name'=>'马里'),
		127=>array('id'=>'Myanmar','name'=>'缅甸'),
		128=>array('id'=>'Mongolia','name'=>'蒙古'),
		129=>array('id'=>'Northern Mariana Islands','name'=>'北马里亚纳群岛'),
		130=>array('id'=>'Martinique','name'=>'马提尼克岛（法属）'),
		131=>array('id'=>'Mauritania','name'=>'毛里塔尼亚'),
		132=>array('id'=>'Montserrat','name'=>'蒙塞拉特岛'),
		133=>array('id'=>'Malta','name'=>'马尔他'),
		134=>array('id'=>'Maldives','name'=>'马尔代夫'),
		135=>array('id'=>'Malawi','name'=>'马拉维'),
		136=>array('id'=>'Mexico','name'=>'墨西哥'),
		137=>array('id'=>'Malaysia','name'=>'马来西亚'),
		138=>array('id'=>'Mozambique','name'=>'莫桑比克'),
		139=>array('id'=>'Namibia','name'=>'纳米比亚'),
		140=>array('id'=>'New Caledonia','name'=>'新喀里多尼亚'),
		141=>array('id'=>'Niger','name'=>'尼日尔'),
		142=>array('id'=>'Norfolk Island','name'=>'诺福克岛'),
		143=>array('id'=>'Nigeria','name'=>'尼日利亚'),
		144=>array('id'=>'Nicaragua','name'=>'尼加拉瓜'),
		145=>array('id'=>'Netherlands','name'=>'荷兰'),
		146=>array('id'=>'Norway','name'=>'挪威'),
		147=>array('id'=>'Nepal','name'=>'尼泊尔'),
		148=>array('id'=>'Nauru','name'=>'瑙鲁'),
		149=>array('id'=>'Niue','name'=>'纽埃'),
		150=>array('id'=>'New Zealand','name'=>'新西兰'),
		151=>array('id'=>'Oman','name'=>'阿曼'),
		152=>array('id'=>'Panama','name'=>'巴拿马'),
		153=>array('id'=>'Peru','name'=>'秘鲁'),
		154=>array('id'=>'French Polynesia','name'=>'法属玻利尼西亚'),
		155=>array('id'=>'Papua New Guinea','name'=>'巴布亚新几内亚'),
		156=>array('id'=>'Philippines','name'=>'菲律宾'),
		157=>array('id'=>'Pakistan','name'=>'巴基斯坦'),
		158=>array('id'=>'Poland','name'=>'波兰'),
		159=>array('id'=>'Pitcairn Island','name'=>'皮特克恩岛'),
		160=>array('id'=>'Puerto Rico','name'=>'波多黎各'),
		161=>array('id'=>'Portugal','name'=>'葡萄牙'),
		162=>array('id'=>'Palau','name'=>'帕劳'),
		163=>array('id'=>'Paraguay','name'=>'巴拉圭'),
		164=>array('id'=>'Qatar','name'=>'卡塔尔'),
		165=>array('id'=>'Reunion Island','name'=>'留尼汪岛（法属）'),
		166=>array('id'=>'Romania','name'=>'罗马尼亚'),
		167=>array('id'=>'Russian Federation','name'=>'俄罗斯联邦'),
		168=>array('id'=>'Rwanda','name'=>'卢旺达'),
		169=>array('id'=>'Saudi Arabia','name'=>'沙特阿拉伯'),
		170=>array('id'=>'Solomon Islands','name'=>'所罗门群岛'),
		171=>array('id'=>'Seychelles','name'=>'塞舌尔'),
		172=>array('id'=>'Sudan','name'=>'苏旦'),
		173=>array('id'=>'Sweden','name'=>'瑞典'),
		174=>array('id'=>'Singapore','name'=>'新加坡'),
		175=>array('id'=>'St. Helena','name'=>'海伦娜'),
		176=>array('id'=>'Slovakia','name'=>'斯洛伐克'),
		177=>array('id'=>'Sierra Leone','name'=>'塞拉利昂'),
		178=>array('id'=>'San Marino','name'=>'圣马力诺'),
		179=>array('id'=>'Senegal','name'=>'塞内加尔'),
		180=>array('id'=>'Somalia','name'=>'索马里'),
		181=>array('id'=>'Suriname','name'=>'苏里南'),
		182=>array('id'=>'Syrian Arab Republic','name'=>'叙利亚'),
		183=>array('id'=>'Swaziland','name'=>'斯威士兰'),
		184=>array('id'=>'Chad','name'=>'乍得'),
		185=>array('id'=>'French Southern Territories','name'=>'法属南半球领地'),
		186=>array('id'=>'Togo','name'=>'多哥'),
		187=>array('id'=>'Thailand','name'=>'泰国'),
		188=>array('id'=>'Tajikistan','name'=>'塔吉克斯坦'),
		189=>array('id'=>'tokelau','name'=>'托克劳群岛'),
		190=>array('id'=>'Turkmenistan','name'=>'土库曼斯坦'),
		191=>array('id'=>'Tunisia','name'=>'突尼斯'),
		192=>array('id'=>'Tonga','name'=>'汤加'),
		193=>array('id'=>'East Timor','name'=>'东帝汶'),
		194=>array('id'=>'Turkey','name'=>'土耳其'),
		195=>array('id'=>'Tuvalu','name'=>'图瓦鲁'),
		196=>array('id'=>'Tanzania','name'=>'坦桑尼亚'),
		197=>array('id'=>'Ukrainian SSR','name'=>'乌克兰'),
		198=>array('id'=>'Uganda','name'=>'乌干达'),
		199=>array('id'=>'United Kingdom','name'=>'英国'),
		200=>array('id'=>'United States','name'=>'美国'),
		201=>array('id'=>'Uruguay','name'=>'乌拉圭'),
		202=>array('id'=>'Vatican City State','name'=>'梵地冈'),
		203=>array('id'=>'Venezuela','name'=>'委内瑞拉'),
		204=>array('id'=>'Virgin Islands','name'=>'维京群岛'),
		205=>array('id'=>'Vietnam','name'=>'越南'),
		206=>array('id'=>'Vanuatu','name'=>'瓦努阿图'),
		207=>array('id'=>'Samoa','name'=>'东萨摩亚'),
		208=>array('id'=>'Yemen','name'=>'也门'),
		209=>array('id'=>'Yugoslavia','name'=>'南斯拉夫'),
		210=>array('id'=>'South Africa','name'=>'南非'),
		211=>array('id'=>'Zambia','name'=>'赞比亚'),
		212=>array('id'=>'Zaire','name'=>'扎伊尔'),
		213=>array('id'=>'Zimbabwe','name'=>'津巴布韦'),
		214=>array('id'=>'Hongkong','name'=>'香港'),
		215=>array('id'=>'Macao','name'=>'澳门'),
		216=>array('id'=>'Taiwan','name'=>'台湾'));
		return $countryData;
	}







}