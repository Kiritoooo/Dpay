//免登录接口
let noLoginUrl = [
	'/addons/recharge/api.recharge/config'
];

// 这里的vm，就是我们在vue文件里面的this，所以我们能在这里获取vuex的变量，比如存放在里面的token
// 同时，我们也可以在此使用getApp().globalData，如果你把token放在getApp().globalData的话，也是可以使用的
const install = (Vue, vm) => {
	Vue.prototype.$u.http.setConfig({
		baseUrl: 'http://www.fa.com',
		header: {
			'content-type': 'application/json; charset=utf-8'
		},
		originalData: true
	});
	// 请求拦截，配置Token等参数
	Vue.prototype.$u.http.interceptor.request = (config) => {
		console.log(config.url)
		//在需要登录的接口，请求前判断token 是否存在,不存在则到登录
		if (noLoginUrl.indexOf(config.url) == -1 && !vm.vuex_token) {
			console.log('未登录，在此跳转登录')
			return false;
		}
		config.header.token = vm.vuex_token;
		return config;
	}
	// 响应拦截，判断状态码是否通过
	Vue.prototype.$u.http.interceptor.response = (res) => {
		console.log('响应', res)
		let result = res.data;
		if (result.code == 1) {
			// 如果把originalData设置为了true，这里return回什么，this.$u.post的then回调中就会得到什么
			uni.showToast({
				icon: "none",
				title: result.msg || "操作成功！"
			})
			return result.data;
		} else if (result.code == 401) {
			//需要登录的接口，当token 过期时，到登录页面
			console.log('未登录，在此跳转登录')
			return 0;
		} else if (result.code == 0) {
			uni.showToast({
				icon: "none",
				title: result.msg || "操作失败！"
			})
			return 0;
		} else {
			if (res.statusCode == 200) {
				return res.data;
			}
		};
	}
}

export default {
	install
}
