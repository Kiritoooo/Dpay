<template>
	<view class="">
		<view class="u-p-l-30 u-p-t-50 u-font-30">充值余额</view>
		<view class="u-p-30"><u-alert-tips type="warning" :description="config.rechargetips"></u-alert-tips></view>
		<view class="">
			<u-grid :col="3" :border="false">
				<u-grid-item v-for="(item, index) in config.moneylist" :key="index">
					<u-button throttle-time="0" type="primary" :plain="!(money == item)" style="width: 80%;" @click="selectMoney(item)" v-text="index"></u-button>
				</u-grid-item>
				<u-grid-item v-if="config.iscustommoney == 1">
					<view class="u-flex u-row-center"><input type="text" class="custom" :value="custom_money" @focus="inputInput" @blur="inputInput" @input="inputInput" /></view>
				</u-grid-item>
			</u-grid>
		</view>
		<view class="u-p-l-30 u-p-t-30 u-font-30">选择支付方式</view>

		<view class="u-m-t-30">
			<u-radio-group v-model="paytype" style="width: 100%;">
				<u-cell-item
					v-for="(item, index) in payList"
					:icon="item == 'wechat' ? 'weixin-circle-fill' : 'zhifubao-circle-fill'"
					:key="index"
					:icon-style="{ color: item == 'wechat' ? '#40BA49' : '#00AAEE' }"
					:arrow="false"
					:title="item == 'wechat' ? '微信支付' : '支付宝支付'"
					@click="selectPayType(item)"
				>
					<u-radio slot="right-icon" :name="item"></u-radio>
				</u-cell-item>
			</u-radio-group>
		</view>
		<view class="u-p-l-30 u-p-r-30 u-p-t-50"><u-button type="primary" @click="submit">立即充值</u-button></view>
		<u-modal v-model="show" :content="content" @confirm="confirm" confirm-text="返回"></u-modal>
	</view>
</template>


<script>
export default {
	onLoad() {
		this.getRechargeConfig();
	},
	data() {
		return {
			show: false,
			content: '请检查是否安装好充值插件哦！',
			config: {},
			paytype: 'wechat',
			custom_money: '自定义',
			money: 0,
			payList: []
		};
	},
	methods: {
		inputInput(e) {
			if (e.type == 'blur') {
				this.custom_money = !e.detail.value ? '自定义' : e.detail.value;
				return;
			}
			if (e.type == 'focus') {
				this.custom_money = e.detail.value == '自定义' ? '' : e.detail.value;
				return;
			}
			this.money = e.detail.value;
			this.custom_money = e.detail.value;
		},
		selectMoney(m) {
			this.money = m;
		},
		selectPayType(item){
			this.paytype = item;
		},
		getRechargeConfig: async function() {
			let res = await this.$u.api.getRechargeConfig();
			if (!res) {
				this.show = true;
				return;
			}
			this.config = res;
			this.money = res.defaultmoney;
			this.paytype = res.defaultpaytype;
			let payList = res.paytypelist.split(',');
			payList.forEach(item => {
				// #ifdef MP-WEIXIN
				if (item == 'wechat') {
					this.payList.push(item);
				}
				// #endif

				// #ifndef MP-WEIXIN
				console.log(this.$util.isWeiXinBrowser());
				if (this.$util.isWeiXinBrowser()) {
					if (item == 'wechat') {
						this.payList.push(item);
					}
				} else {
					this.payList.push(item);
				}
				// #endif
			});
		},
		confirm() {
			this.$u.route({
				type: 'back',
				delta: 1
			});
		},
		// #ifdef MP-WEIXIN
		submit: async function() {
			if (this.money < this.config.minmoney) {
				this.$u.toast(`最低充值金额为${this.config.minmoney}元`);
				return;
			}
			let res = await this.$u.api.goRechargeSubmit({
				money: this.money,
				paytype: this.paytype,
				method: 'miniapp'
			});
			if (!res) return;
			if(res=='bind'){
				this.$u.route('请先绑定账号！');
				return;
			}
			uni.requestPayment({
				provider: 'wxpay',
				timeStamp: res.timeStamp,
				nonceStr: res.nonceStr,
				package: res.package,
				signType: res.signType,
				paySign: res.paySign,
				success: res => {
					this.$u.toast('充值成功！');
				},
				fail: err => {
					this.$u.toast('fail:' + JSON.stringify(err));
				}
			});
		},

		// #endif

		// #ifdef H5
		submit: async function() {
			if (this.money < this.config.minmoney) {
				this.$u.toast(`最低充值金额为${this.config.minmoney}元`);
				return;
			}
			let data = {
				money: this.money,
				paytype: this.paytype,
				method: 'wap'
			};
			//在微信环境，且为微信支付
			if (this.$util.isWeiXinBrowser() && this.paytype == 'wechat') {
				data.method = 'mp';
				let res = await this.$u.api.goRechargeSubmit(data);
				if(!res) return;
				if (res=='bind') {
					this.$u.route('请先绑定账号！');
					return;
				};
				window.WeixinJSBridge.invoke(
					'getBrandWCPayRequest',
					{
						appId: res.appId, // 公众号名称，由商户传入
						timeStamp: res.timeStamp, // 时间戳，自1970年以来的秒数
						nonceStr: res.nonceStr, // 随机串
						package: res.package,
						signType: res.signType, // 微信签名方式：
						paySign: res.paySign // 微信签名
					},
					res => {
						console.log(res);
						if (res.err_msg === 'get_brand_wcpay_request:ok') {
							this.$u.toast('充值成功！');
						} else if (res.err_msg === 'get_brand_wcpay_request:cancel') {
							this.$u.toast('取消支付');
						} else {
							this.$u.toast('支付失败');
						}
					}
				);
			} else {
				//非微信环境的wap 支付方法，会返回orderid，再模拟表单提交
				data.returnurl = window.location.href;
				let res = await this.$u.api.goRechargeSubmit(data);
				if (!res) return;
				console.log(res);
				
				//URL地址
				if(res.toString().match(/^((?:[a-z]+:)?\/\/)(.*)/i)){
					location.href = res;
					return;
				}
				
				//Form表单
				document.getElementsByTagName("body")[0].innerHTML = res;
				let form = document.querySelector("form");
				if(form && form.length>0){
					form.submit();
					return;
				}
				
				//Meta跳转
				let meta = document.querySelector('meta[http-equiv="refresh"]');
				if(meta && meta.length>0){
					setTimeout(function(){
						location.href = meta.content.split(/;/)[1];
					}, 300);
					return;
				}
				return;
			}
		}

		// #endif

		// #ifdef APP-PLUS
		submit: async function() {
			if (this.money < this.config.minmoney) {
				this.$u.toast(`最低充值金额为${this.config.minmoney}元`);
				return;
			}
			let  appid = plus.runtime.appid;
			let res = await this.$u.api.goRechargeSubmit({
				money: this.money,
				paytype: this.paytype,
				method: 'app',
				appid:appid
			});
			if (!res) return;
			uni.requestPayment({
			    provider: this.paytype=='alipay'?'alipay':'wxpay',
			    orderInfo: res.orderInfo, //微信、支付宝订单数据
			    success: function (res) {
			        this.$u.toast('支付成功！');
			        this.$emit('success');
			        this.close()
			    },
			    fail: function (err) {
			        console.log('fail:' + JSON.stringify(err));
			    }
			});
		}
		// #endif
	}
};
</script>

<style>
.custom {
	text-align: center;
	width: 60%;
	color: #2979ff;
	background-color: rgb(255, 255, 255);
	border: 1px solid #a0cfff;
	height: 40px;
	border-radius: 5px;
	padding: 0 10%;
}
</style>
