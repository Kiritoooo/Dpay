const install = (Vue, vm) => {

	let getRechargeConfig = async (params = {}) => await vm.$u.get('/addons/recharge/api.recharge/config', params);
	let goRechargeSubmit = async (params = {}) => await vm.$u.get('/addons/recharge/api.recharge/submit', params);

	// 将各个定义的接口名称，统一放进对象挂载到vm.$u.api(因为vm就是this，也即this.$u.api)下
	vm.$u.api = {
		getRechargeConfig,
		goRechargeSubmit

	};
}

export default {
	install
}
