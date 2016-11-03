function browserSupport(accept) {
	var ucSupport = ucSnoof(accept);
	if(ucSupport.support == "true"){
		return ucSupport;
	}
	// 通用判断
	var userAgent = navigator.userAgent.toLowerCase();
	// 到这里，uc已经不判断了
	if (plateformSnoof(userAgent) == "android") {
		if ((/360 aphone browser/.test(userAgent)) 
|| (/opera\//.test(userAgent) && /oupenghd/.test(userAgent)) || (/qqbrowser/.test(userAgent))) {
			return {
				'support' : 'true',
				'tag' : 'a'
			};
		}else{
			return {
				'support' : 'false',
			};
		}
	} else {
		return {
			'support' : 'false',
		};
	}
}

function creditSupport(accept){
	var ucSupport = ucSnoof(accept);
	if(ucSupport.support == "true"){
		return ucSupport;
	} else{
		return {
			'support' : 'false',
		};
	}
}

function ucSnoof(accept){
	if (!accept) {
		return;
	}
	// uc浏览器判断
	var ucIos = new RegExp("ios_plugin/1");
	var ucAndroid = new RegExp("plugin/1");
	if (ucIos.test(accept)) {
		return {
			'support' : 'true',
			'tag' : 'a'
		};
	} else if (ucAndroid.test(accept)) {
		return {
			'support' : 'true',
			'tag' : 'embed'
		};
	} else{
		return {
			'support' : 'false',
		};
	}
}

function plateformSnoof(userAgent) {
	var ios = new RegExp("iphone os");
	var android = new RegExp("android");
	if (ios.test(userAgent)) {
		return "ios";
	}
	if (android.test(userAgent)) {
		return "android";
	}
}