/**
 * 给javascript数组添加indexOf函数
 */
if (!Array.prototype.indexOf){
    Array.prototype.indexOf=function(testZi){
        for(var i=0;i<this.length;i++){
            if(testZi===this[i]){
                return i;
            }
        }
        return -1;
    };
}
/**
 * 数组去重复函数
 */
function hash_unique(array) {
    var o = [];
    for(var i = 0, j = 0; i < array.length; i++) {
        if(typeof o[array[i]] == 'undefined') {
            o[array[i]] = j++;
        }
    }
    array = [];
    for(var k in o) {
        array[o[k]] = k;
    }
    return array;
}
function js_escape(str)
{
	return escape(encodeURI(str)).replace(/\+/g,'%2B');
}
/**
 * 在url上面新增时间t，解决ie缓存问题
 */
function urlAddT(url)
{
    var p=url.indexOf("\?");
    if (p == -1)
    {
        url = url+'?_t='+Math.random();
    }
    else
    {
        url = url + '&_t='+Math.random();
    }
    return url;
}
/**
 * 弹出一个模态对话框
 */
function openModelDialog(url,width, height, top, left, resizable, scroll)
{
    var str = 'help:no;';
    if(typeof(url) == "undefined")
    {
        return false;
    }
    if(typeof(width) == "undefined")
    {
        width = 450;
    }
    str += "dialogWidth:"+width+"px;";
    if(typeof(height) == "undefined")
    {
        height = 300;
    }
    str += "dialogHeight:"+height+"px;"

    if(typeof(top) != "undefined")
    {
        str += "dialogTop:"+top+"px;";
    }
    if (typeof(left) != 'undefined') {
        str += "dialogLeft:"+left+"px;";
    }
    if(typeof(resizable) == "undefined")
    {
        resizable = 'yes';
    }
    str += "resizable:"+resizable+";";

    if(typeof(scroll) == "undefined")
    {
        scroll = "yes";
    }
    str += "scroll:"+scroll+";";
    if(typeof(top) == "undefined" && typeof(left) == "undefined")
    {
        str += "center:yes;";
    }

    url = urlAddT(url);
    return showModalDialog(url,window, str);
}

function checkEmail(strEmail) {
	if(strEmail==null||strEmail=="")
	{
		return 'Email地址不能为空'
	}
	
	if (strEmail.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) != -1)
	return 1;
	else
	return 'Email地址格式不正确';
}


function checkIdcard(idcard){
	var Errors=new Array(
	"1",
	"身份证号码位数不对!",
	"身份证号码出生日期超出范围或含有非法字符!",
	"身份证号码校验错误!",
	"身份证地区非法!"
	);
	var area={11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",21:"辽宁",22:"吉林",23:"黑龙江",31:"上海",32:"江苏",33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南",42:"湖北",43:"湖南",44:"广东",45:"广西",46:"海南",50:"重庆",51:"四川",52:"贵州",53:"云南",54:"西藏",61:"陕西",62:"甘肃",63:"青海",64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外"}
	var idcard,Y,JYM;
	var S,M;
	var idcard_array = new Array();
	idcard_array = idcard.split("");
	//地区检验
	if(area[parseInt(idcard.substr(0,2))]==null) return Errors[4];
	//身份号码位数及格式检验
		switch(idcard.length){
			case 15:
			if ( (parseInt(idcard.substr(6,2))+1900) % 4 == 0 || ((parseInt(idcard.substr(6,2))+1900) % 100 == 0 && (parseInt(idcard.substr(6,2))+1900) % 4 == 0 )){
			ereg=/^[1-9][0-9]{5}[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))[0-9]{3}$/;//测试出生日期的合法性
			} else {
			ereg=/^[1-9][0-9]{5}[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|1[0-9]|2[0-8]))[0-9]{3}$/;//测试出生日期的合法性
			}
			if(ereg.test(idcard)) return Errors[0];
			else return Errors[2];
			break;
			case 18:
			//18位身份号码检测
			//出生日期的合法性检查
			//闰年月日:((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))
			//平年月日:((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|1[0-9]|2[0-8]))
			if ( parseInt(idcard.substr(6,4)) % 4 == 0 || (parseInt(idcard.substr(6,4)) % 100 == 0 && parseInt(idcard.substr(6,4))%4 == 0 )){
			ereg=/^[1-9][0-9]{5}19[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))[0-9]{3}[0-9Xx]$/;//闰年出生日期的合法性正则表达式
			} else {
			ereg=/^[1-9][0-9]{5}19[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|1[0-9]|2[0-8]))[0-9]{3}[0-9Xx]$/;//平年出生日期的合法性正则表达式
			}
			if(ereg.test(idcard)){//测试出生日期的合法性
			//计算校验位
			S = (parseInt(idcard_array[0]) + parseInt(idcard_array[10])) * 7
			+ (parseInt(idcard_array[1]) + parseInt(idcard_array[11])) * 9
			+ (parseInt(idcard_array[2]) + parseInt(idcard_array[12])) * 10
			+ (parseInt(idcard_array[3]) + parseInt(idcard_array[13])) * 5
			+ (parseInt(idcard_array[4]) + parseInt(idcard_array[14])) * 8
			+ (parseInt(idcard_array[5]) + parseInt(idcard_array[15])) * 4
			+ (parseInt(idcard_array[6]) + parseInt(idcard_array[16])) * 2
			+ parseInt(idcard_array[7]) * 1
			+ parseInt(idcard_array[8]) * 6
			+ parseInt(idcard_array[9]) * 3 ;
			Y = S % 11;
			M = "F";
			JYM = "10X98765432";
			M = JYM.substr(Y,1);//判断校验位
			if(M == idcard_array[17]) return Errors[0]; //检测ID的校验位
			else return Errors[3];
			}
			else return Errors[2];
			break;
			default:
			return Errors[1];
			break;
		}
}
/**
 * 校验邮箱
 */
function checkEmail(strEmail) {
	if(strEmail==null||strEmail=="")
	{
		return 'Email地址不能为空'
	}
	
	if (strEmail.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) != -1)
	return 1;
	else
	return 'Email地址格式不正确';
}
function checkMobile(sMobile){
	if(sMobile==null||sMobile==''){
		return "手机号码不能为空！";
	}
    if(!(/^1[0-9][0-9]\d{4,8}$/.test(sMobile))){ 
        return "手机号码输入不正确！"; 
    }else{
    	return 1;
    }
} 
/**
 * 弹出一个非模态对话框
 */
function openModelessDialog(url,width, height, top, left, resizable, scroll)
{
    var str = 'help:no;';
    if(typeof(url) == "undefined")
    {
        return false;
    }
    if(typeof(width) == "undefined")
    {
        width = 450;
    }
    str += "dialogWidth:"+width+"px;";
    if(typeof(height) == "undefined")
    {
        height = 300;
    }
    str += "dialogHeight:"+height+"px;"

    if(typeof(top) != "undefined")
    {
        str += "dialogTop:"+top+"px;";
    }
    if (typeof(left) != 'undefined') {
        str += "dialogLeft:"+left+"px;";
    }
    if(typeof(resizable) == "undefined")
    {
        resizable = 'yes';
    }
    str += "resizable:"+resizable+";";

    if(typeof(scroll) == "undefined")
    {
        scroll = "yes";
    }
    str += "scroll:"+scroll+";";
    if(typeof(top) == "undefined" && typeof(left) == "undefined")
    {
        str += "center:yes;";
    }

    url = urlAddT(url);
    return showModelessDialog(url,window, str);
}

function modifyTab(id,title,url){
    var i = parent.tabpanel.getActiveIndex();
    document.location.href = url;
    parent.tabpanel.getActiveTab().tab.attr('id', id);
    parent.tabpanel.tabs[i].id = id;
    parent.tabpanel.setTitle(i,title);
}
function checkpwd(pwd,birth,bankaccount){
		    if(pwd.length !=6){
			return 1;
		    }
			// 全一样
		    if (/^(\d)\1+$/.test(pwd))
		    {
		    	return 2;
		    } 
		    // 顺增
		    var str = pwd.replace(/\d/g, function($0, pos) {
		        return parseInt($0)-pos;
		    });
		    if (/^(\d)\1+$/.test(str)) 
		    {
		    	return 2;
		    }	
		    // 顺减
		    str = pwd.replace(/\d/g, function($0, pos) {
		        return parseInt($0)+pos;
		    });
		    if (/^(\d)\1+$/.test(str))   {
		    	return 2;
		    }  
		    if(pwd==birth.substr(2,8))
		    {
		    	return 2;
		    }
		    if(bankaccount!=0){
		    if(pwd==bankaccount.substr(bankaccount.length-6))
		    {
		    	return 2;
		    }
		    }
		    return 0;
}
//提交刷新父页面
function ajax_submit(postUrl, formname, refalshparentpage, closewin)
{
    if (typeof(postUrl) == "undefined") {
        alert('页面提交url不能为空');
        return false;
    }
    if (typeof(formname) == "undefined") {
        alert('页面表单名不能为空');
        return false;
    }
    if(typeof(refalshparentpage)=="undefined"){
    	refalshparentpage=true;
    }
    if(typeof(closewin)=="undefined"){
    	closewin=true;
    }
    var postParams = $('form[name="'+formname+'"]').serialize();

    $.ajax({
        type: "POST",
        url: postUrl,
        data:postParams,
        dataType : "json",
        success: function(result){
            alert(result.msg);
            if (result.success == true) {
                if (refalshparentpage == true) {
                    window.dialogArguments.location.href=window.dialogArguments.location;
                }
                if (closewin == true) {
                    window.close();
                }
                
            }
        },
        complete:function(req,text){
            if(text!='success'){
                //alert(text+" "+req.responseText);
            	alert('执行失败，请联系管理员');
            }
        }
    });
}
/** 
 * ajax提交 
 * @param url 
 * @param param 参数
 * @param callback回调函数 
 * 第一个参数必填
 * @return 
 */  
function commonAjax(url, param, callBack,type,dataType) 
{
	if (typeof(url) == "undefined") {
        alert('页面提交url不能为空');
        return false;
    }
	param = (typeof(param)=="undefined")?null:param;
	type = (typeof(type)=="undefined")?'post':type;//默认为post
	dataType = (typeof(dataType)=="undefined")?'json':dataType;//默认为json
	if(typeof(callBack)=="undefined"){
		$.ajax({  
	        type:type,  
	        url:url,  
	        data:param,  
	        dataType:dataType,  
	        complete:function(req,text){
	            if(text!='success'){
	            	alert('执行失败，请联系管理员');
	                //alert(text+" "+req.responseText);
	            }
	        }  
	    });
	}else{
		$.ajax({  
	        type:type,  
	        url:url,  
	        data:param,  
	        dataType:dataType,      
	        success:callBack,  
	        complete:function(req,text){
	            if(text!='success'){
	                //alert(text+" "+req.responseText);
	            	alert('执行失败，请联系管理员');
	            }
	        }  
	    });
	}
		               
}
/**
 * 校验是否为空 
 */
function checkNull(id,note,subBt)
{
	var val=$('#'+id).val();
	if(val==''){
		alert(note+'不能为空！');
		var subBt = (typeof(subBt)=="undefined")?'subBt':subBt;
		$("#"+subBt).attr('disabled',false);
		$('#'+id).focus();
		return false;
	}
	return true;
}

