<?php
function spUrl($controller = null, $action = null, $args = null, $anchor = null, $no_sphtml = FALSE) {
	$controller = ( null != $controller ) ? $controller : 'loginController';
	$action = ( null != $action ) ? $action : 'index';
	$url = getBasePath()."?c={$controller}&a={$action}";
	if(null != $args)foreach($args as $key => $arg) $url .= "&{$key}={$arg}";
	return $url;
}
/**
 * 前台smarty用的回调方法
 * @param $param
 */
function spUrlView($param)
{
	extract($param);
	$controller=$c;
	$action=$a;
	$controller = ( null != $controller ) ? $controller : 'loginController';
	$action = ( null != $action ) ? $action : 'index';
	$url = getBasePath()."?c={$controller}&a={$action}";
	return $url;
}
/**
 * 得到根目录
 */
function getBasePath()
{
	if('' == $GLOBALS['spConfig']["url_path_base"]){
		if(basename($_SERVER['SCRIPT_NAME']) === basename($_SERVER['SCRIPT_FILENAME']))
		$GLOBALS['spConfig']["url_path_base"] = $_SERVER['SCRIPT_NAME'];
		elseif (basename($_SERVER['PHP_SELF']) === basename($_SERVER['SCRIPT_FILENAME']))
		$GLOBALS['spConfig']["url_path_base"] = $_SERVER['PHP_SELF'];
		elseif (isset($_SERVER['ORIG_SCRIPT_NAME']) && basename($_SERVER['ORIG_SCRIPT_NAME']) === basename($_SERVER['SCRIPT_FILENAME']))
		$GLOBALS['spConfig']["url_path_base"] = $_SERVER['ORIG_SCRIPT_NAME'];
	}
	return $GLOBALS['spConfig']["url_path_base"];
}
/**
 * $pwd 加密key  $data 加密字符
 */
function rc4 ($pwd, $data)
{
	$key[] ="";
	$box[] ="";

	$pwd_length = strlen($pwd);
	$data_length = strlen($data);

	for ($i = 0; $i < 256; $i++)
	{
		$key[$i] = ord($pwd[$i % $pwd_length]);
		$box[$i] = $i;
	}

	for ($j = $i = 0; $i < 256; $i++)
	{
		$j = ($j + $box[$i] + $key[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for ($a = $j = $i = 0; $i < $data_length; $i++)
	{
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;

		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;

		$k = $box[(($box[$a] + $box[$j]) % 256)];
		$cipher .= chr(ord($data[$i]) ^ $k);
	}

	return $cipher;
}
/**
 * 写日志程序
 */
function writeLog($str='',$type='')
{
	if($type==''){
		$path=APP_PATH."/cache/logs/";
	}elseif($type=='e'){//错误日志
		$path=APP_PATH."/cache/errorLogs";
	}
	mkpath($path);
	if(ENABLE_LOG!='0'||$type=='e'){
		$file=sprintf($path."/log_%s.txt",date('Ymd'));
		$strDate=date('Y-m-d H:i:s',time());
		$logStr="$strDate\t$str\r\n";
		$f=fopen($file, 'a+');
		if($f){
			fwrite($f, $logStr);
			fclose($f);
		}
	}
}
function writeArrLog($arr,$type='')
{
	$str='';
	foreach ($arr as $key=>$val)
	{
		$str.=$key.'=>'.$val.',';
	}
	writeLog($str,$type);
}
/**
 * 创建目录，函数有循环创建目录功能,先会判断文件是否存在，若存在，则直接返回true，若不存在，则创建，若创建成功，返回true，
 * 创建失败，返回false
 *
 * @param string $mkpath
 * @param string $mode
 * @return boolean
 */
function mkpath ($mkpath)
{
	if (file_exists($mkpath))
	{
		return true;
	}
	else
	{
		$path = '';
		$mkpath = str_replace('\\', '/', $mkpath);
		$path_arr = explode('/', $mkpath);
		$nums=count($path_arr);
		for ($i = 0; $i <$nums ; $i ++)
		{
			$path .= $path_arr[$i] . "/";
			if (! file_exists($path))
			{
				mkdir($path);
			}
		}
		if (file_exists($mkpath))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
/**
 * ip获取
 */
function userip()
{
	//php获取ip的算法
	if ($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"])
	{
		$ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
	}
	elseif ($HTTP_SERVER_VARS["HTTP_CLIENT_IP"])
	{
		$ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
	}
	elseif ($HTTP_SERVER_VARS["REMOTE_ADDR"])
	{
		$ip = $HTTP_SERVER_VARS["REMOTE_ADDR"];
	}
	elseif (getenv("HTTP_X_FORWARDED_FOR"))
	{
		$ip = getenv("HTTP_X_FORWARDED_FOR");
	}
	elseif (getenv("HTTP_CLIENT_IP"))
	{
		$ip = getenv("HTTP_CLIENT_IP");
	}
	elseif (getenv("REMOTE_ADDR"))
	{
		$ip = getenv("REMOTE_ADDR");
	}
	else
	{
		$ip = "0";
	}
	return $ip;
}
/**
 *  @desc 根据两点间的经纬度计算距离
 *  @param float $lat 纬度值
 *  @param float $lng 经度值
 *  http://en.wikipedia.org/wiki/Haversine_formula
 */
function getDistance($lat1, $lng1, $lat2, $lng2)
{
	$earthRadius = 6367000; //地球半径

	$lat1 = ($lat1 * pi() ) / 180;
	$lng1 = ($lng1 * pi() ) / 180;

	$lat2 = ($lat2 * pi() ) / 180;
	$lng2 = ($lng2 * pi() ) / 180;

	$calcLongitude = $lng2 - $lng1;
	$calcLatitude = $lat2 - $lat1;
	$stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);  $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
	$calculatedDistance = $earthRadius * $stepTwo;

	return round($calculate);
}
/**
 * 返回适用于extjs的tree的json字符串，对于null值，json_encode会直接用null返回，则要进行替换为""
 * @param array $data 存储数据的数组 array('parentid'=>array('id'=>array()))形式
 * @param string $parentcode 处理那个parentid下的数据
 * @param array $returnArr 返回的数组，会加进去leaf、iconCls、children、checked项
 * @param boolean $hasCheck 是否是一个带checkbox的选择树
 * @param array $checkedCode 目前选中项数据
 */
function getJson($data)
{
	$json=json_encode($data);
	$json = preg_replace("/(:)\s*null\s*([,\}])/is", '$1""$2', $json);
	return $json;
}
/**
 * 分页, @param 记录总数， 每页记录数， 当前页码， 页码url
 */
function multi($num, $perpage, $curpage, $mpurl, $maxpages = 0, $page = 10, $autogoto = TRUE, $simple = FALSE)
{
	//global $maxpage;
	$ajaxtarget = !empty($_GET['ajaxtarget']) ? " ajaxtarget=\"".dhtmlspecialchars($_GET['ajaxtarget'])."\" " : '';

	$shownum = $showkbd = TRUE;
	$lang['prev'] = '&lsaquo;';
	$lang['next'] = '&rsaquo;';

	$multipage = '';
	//$mpurl .= substr($mpurl, -1)=='/' ? '' : '/';
	$mpurl .= strpos($mpurl, '?') ? '&amp;' : '?';
	$realpages = 1;
	if($num > $perpage)
	{
		$offset = $page % 2 == 0 ? ($page-2)/2 : ($page - 2 - 1 ) / 2;

		$realpages = ceil($num / $perpage);
		$pages = $maxpages && $maxpages < $realpages ? $maxpages : $realpages;
		$curpage = $curpage >= $pages ? $pages: $curpage;

		if($page >= $pages)
		{
			$from = 1;
			$to = $pages;
		}
		else
		{
			if ($curpage <= ($offset + 2))
			{
				$from = 1;
				$to = $page - 1;
			}
			else if ($curpage > ($pages - $offset - 2))
			{
				$from = $pages -  $page + 2;
				$to = $pages ;
			}
			else
			{
				$from = $curpage - $offset;
				$to = $curpage + $offset;
			}


		}

		$multipage = ($curpage > 1 && !$simple ? '<a href="'.$mpurl.'page='.($curpage - 1).'" class="prev"'.$ajaxtarget.'>'.$lang['prev'].'</a>' : '')
		.(($curpage - $offset) > 2 && $pages > $page ? '<a href="'.$mpurl.'page=1" class="first"'.$ajaxtarget.'>1</a>...' : '');

		for($i = $from; $i <= $to; $i++)
		{
			$multipage .= $i == $curpage ? '<strong>'.$i.'</strong>' :
                '<a href="'.$mpurl.'page='.$i.($ajaxtarget && $i == $pages && $autogoto ? '#' : '').'"'.$ajaxtarget.'>'.$i.'</a>';
		}


		$multipage .= ($to < $pages ? '...<a href="'.$mpurl.'page='.$pages.'" class="last"'.$ajaxtarget.'>'.$realpages.'</a> ' : '')
		.($curpage < $pages && !$simple ? '<a href="'.$mpurl.'page='.($curpage + 1).'" class="next"'.$ajaxtarget.'>'.$lang['next'].'</a>' : '')
		.($showkbd && !$simple && $pages > $page && !$ajaxtarget ?
		($shownum && !$simple ? '&nbsp;&nbsp;共'.$num.'条&nbsp;&nbsp;' : '').'到第<kbd><input id="custompage" type="text" name="custompage" size="3" value="'.intval($curpage).'" onkeyup="javascript:var curpage='.intval($curpage).';var page=this.value;if(page==\'\')return false;page=page.match(/^[0-9]\d*$/);if(page>'.$pages.'||page<1) { this.value=curpage;return false;}" /></kbd>页 <input name="input" type="button" class="btn_44" value="确 定" onclick="javascript:var curpage='.intval($curpage).';var page=document.getElementById(\'custompage\').value;page=page.match(/^[0-9]\d*$/);if(page>'.$pages.'||page<1||page==\'\') { document.getElementById(\'custompage\').value=curpage;return false;} window.location=\''.$mpurl.'page=\'+page; return false;"  />' : '');

		$multipage .= ($to == $pages && $pages <= $page) ? '&nbsp;&nbsp;共 '.$num.' 条' : '';
		$multipage = $multipage ? '<div class="pages">'.$multipage.'</div>' : '';
	}
	else
	$multipage = '<div class="pages">&nbsp;<strong>1</strong>&nbsp;&nbsp;共 '.$num.' 条</div>';

	if ($curpage > $realpages || $curpage < 1)
	{
		//throw new Exception('页数选择不能超过实际范围!', -2);
		return false;
	}
	return $multipage;
}
function getLastDay($year,$month,$reformat = 'Y-m-d')
{
	$returnStr=date('Y-m-t',strtotime($year.'-'.$month.'-01'));
	if ($returnStr>date('Y-m-d',time()))
	{
		$returnStr=date('Y-m-d',time());
	}
	$rs = date($reformat,strtotime($returnStr));
	return $rs;
}

function checkEmpty($row)
{
	foreach ($row as $key=>$val){
		if($val==''){
			return false;
		}
	}
	return true;
}
function createOrderNo() {
	$year_code = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
	return $year_code[intval(date('Y')) - 2010] .
	strtoupper(dechex(date('m'))) . date('d') .
	substr(time(), -5) . substr(microtime(), 2, 5) . rand(0, 99999);
}
function C($key=NULL)
{
	$configs=array();
	if($key==NULL)return $configs;
	$configs=$GLOBALS['spConfig'][$key];
	return $configs;
}
