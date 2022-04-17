
/**
 *
 *  判断是否在微信浏览器 true是
 */
function isWeiXinBrowser() {
	// #ifdef H5	
	let ua = window.navigator.userAgent.toLowerCase()	
	if (ua.match(/MicroMessenger/i) == 'micromessenger') {
		return true
	} else {
		return false
	}
	// #endif
	return false
}



export {
	isWeiXinBrowser
}
