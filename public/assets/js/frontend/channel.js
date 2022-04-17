define(['jquery', 'bootstrap', 'frontend', 'form', 'template'], function ($, undefined, Frontend, Form, Template) {
    var Controller = {
        index: function () {
            
            function isMobile() {
                var userAgentInfo = navigator.userAgent;
                var mobileAgents = [ "Android", "iPhone", "SymbianOS", "Windows Phone", "iPad","iPod"];
                var mobile_flag = false;
                //根据userAgent判断是否是手机
                for (var v = 0; v < mobileAgents.length; v++) {
                    if (userAgentInfo.indexOf(mobileAgents[v]) > 0) {
                        mobile_flag = true;
                        break;
                    }
                }
                 var screen_width = window.screen.width;
                 var screen_height = window.screen.height;    
                 //根据屏幕分辨率判断是否是手机
                 if(screen_width < 500 && screen_height < 800){
                     mobile_flag = true;
                 }
                 return mobile_flag;
            }

            

            $(document).on("click", ".detail", function () {
                var id =  $(this).attr("data-id");
                layer.open({
                        type: 2,
                        title: '通道详情',
                        area: ['400px', '300px'],
                        closeBtn: 1, //不显示关闭按钮
                        anim: 2,
                        shadeClose: true, //开启遮罩关闭
                        content: 'detail.html?id='+id
                      });
            });

            $(document).on("click", ".update", function () {
                var id   =   $(this).attr("data-id");
                var type =   $(this).attr("data-type");
                var code =   $(this).attr("data-code");
                var login_id = 0;
                var q_id =0;
                //alert(type);
                layer.msg('云端登录加载中', {
                  icon: 16
                  ,shade: 0.01
                });
                if(type=='alipay')
                {
                    $.ajax({
                        url: 'ajax/cloud',
                        dataType: 'json',
                        data: {type: 'getqrcode'},
                        cache: false,
                        success: function (ret) {
                            var qc_img = '/qr.php?text='+ret.qrcodeurl+'&label=&logo=0&labelalignment=center&foreground=%23000000&background=%23ffffff&size=200&padding=10&logosize=50&labelfontsize=14&errorcorrection=medium';
                            layer.open({
                              type: 1,
                              title: '支付宝本地登录',
                              area: ['350px', '300px'],
                              closeBtn: 1, 
                              anim: 2,
                              shadeClose: true,
                              content: '<center><img align="center" id="qrcodeimg" alt="加载中..." src="' + qc_img +'" title="扫码登录" width="200" height="200" style=" position: relative;margin:20px;"></center>'
                            });
                            login_id = ret.loginid;
                            
                            //开启定时器检测
                            alipay_time =window.setInterval(function() {
                            	$.ajax({
                                    url: 'ajax/cloud',
                                    dataType: 'json',
                                    data: {type: 'getcookie',loginid:login_id},
                                    cache: false,
                                    success: function (res) {
                                        if(res.code==1)
                                        {
                                            window.clearInterval(alipay_time);
                                            layer.msg(res.msg, {icon: 1});
                                            //获取成功,执行保存代码
                                            Up_Qr(id,res.cookie);
                                            window.location.reload();
                                        }
                                    }, error: function () {
                                        Toastr.error(__('Network error'));
                                    }
                                });
                                
                            },
                            5000);
                            
                        }, error: function () {
                            Toastr.error(__('Network error'));
                        }
                    });
                    
                }
  
                if(type=='wxpay')
                {
                    
                    if(code=='wxpay_cloud')
                    {
                        $.ajax({
                            url: 'ajax/cloud',
                            dataType: 'json',
                            data: {type: 'getWeChatQr',qrlist_id:id},
                            cache: false,
                            success: function (ret) {
                                if(ret.code==0)
                                {
                                    layer.msg("出现错误,请删除此通道重新添加");
                                    return;
                                }
                                layer.open({
                                  type: 1,
                                  title: '微信云端登陆',
                                  area: ['350px', '300px'],
                                  closeBtn: 1, //不显示关闭按钮
                                  anim: 2,
                                  shadeClose: true, //开启遮罩关闭
                                  content: '<center><img align="center" id="qrcodeimg" alt="加载中..." src="' + ret.qr_url +'" title="扫码登录" width="200" height="200" style=" position: relative; margin:20px;"></center>'
                                });
                                q_id = ret.data.guid;
                                login_id=ret.data.data.uuid;
                                //开启定时器检测
                                wechatpay_time =window.setInterval(function() {
                                	$.ajax({
                                        url: 'ajax/cloud',
                                        dataType: 'json',
                                        data: {type: 'WXCheckLoginQrcode',qr_id:q_id,loginid:login_id},
                                        cache: false,
                                        success: function (res) {
                                            if(res.code==1)
                                            {
                                                window.clearInterval(wechatpay_time);
                                                layer.msg(res.msg, {icon: 1});
                                                //获取成功,执行保存代码
                                                Up_Qr(id,q_id);
                                                window.location.reload();
                                            }
                                        }, error: function () {
                                            Toastr.error(__('Network error'));
                                        }
                                    });
                                   
                                },
                                5000);
                                
                            }, error: function () {
                                Toastr.error(__('Network error'));
                            }
                         });
                    }
                    else
                    {
                        layer.open({
                        type: 2,
                        title: '微信店员添加',
                        area: ['500px', '300px'],
                        closeBtn: 1, //不显示关闭按钮
                        anim: 2,
                        shadeClose: true, //开启遮罩关闭
                        content: 'wx_accout.html'
                        });
                    }
                    
                }
                
                if(type=='qqpay')
                {
                   $.ajax({
                            url: 'ajax/cloud',
                            dataType: 'json',
                            data: {type: 'getqrpic',qrlist_id:id},
                            cache: false,
                            success: function (ret) {
                                if(ret.code==0)
                                {
                                    layer.msg("出现错误,请删除此通道重新添加");
                                    return;
                                }
                                layer.open({
                                  type: 1,
                                  title: 'QQ钱包本地登陆',
                                  area: ['350px', '300px'],
                                  closeBtn: 1, //不显示关闭按钮
                                  anim: 2,
                                  shadeClose: true, //开启遮罩关闭
                                  content: '<center><img align="center" id="qrcodeimg" alt="加载中..." src="' + ret.qr_url +'" title="扫码登录" width="200" height="200" style=" position: relative; margin:20px;"></center>'
                                });
                                login_id = ret.id;
                                q_id = ret.id;
                                //开启定时器检测
                                qqpay_time =window.setInterval(function() {
                                	$.ajax({
                                        url: 'ajax/cloud',
                                        dataType: 'json',
                                        data: {type: 'qrlogin',qr_id:q_id,loginid:login_id},
                                        cache: false,
                                        success: function (res) {
                                            if(res.code==1)
                                            {
                                                window.clearInterval(qqpay_time);
                                                layer.msg(res.msg, {icon: 1});
                                                //获取成功,执行保存代码
                                                Up_Qr(id,res.cookie);
                                                window.location.reload();
                                            }
                                        }, error: function () {
                                            Toastr.error(__('Network error'));
                                        }
                                    });
                                   
                                },
                                5000);
                                
                            }, error: function () {
                                Toastr.error(__('Network error'));
                            }
                         });
                }
                
                
                
            });
            
            $(document).on("click", ".del", function () {
                var id =  $(this).attr("data-id");
                layer.confirm('您确定要删除该通道吗？', {
                  btn: ['删除','取消']
                }, function(){
                  
                  $.ajax({
                        url: 'channel/delchannel',
                        dataType: 'json',
                        data: {id: id},
                        cache: false,
                        success: function (ret) {
                            location.reload();
                            layer.msg(ret.msg);
                        }, error: function () {
                            Toastr.error(__('Network error'));
                        }
                    });
                  window.location.reload();
                });
            });
            
            $(document).on("click", ".xiaxian", function () {
                var id =  $(this).attr("data-id");
                layer.confirm('您确定要更改该通道吗？', {
                  btn: ['确定','取消']
                }, function(){
                  
                  $.ajax({
                        url: 'ajax/offchannel',
                        dataType: 'json',
                        data: {id: id},
                        cache: false,
                        success: function (ret) {
                            location.reload();
                            layer.msg(ret.msg);
                        }, error: function () {
                            Toastr.error(__('Network error'));
                        }
                    });
                  window.location.reload();
                });
            });
            
            $(document).on("click", ".add_channel", function () {
                    var mobile_flag = isMobile();
                    var ar = ["500px", "350px"];
                    if(mobile_flag)
                    {
                        ar = ["98%", "80%"];
                    }
                    var id = "addctpl";
                    var zfbms =  $(this).attr("data-zfb");
                    var content = Template(id, {});
                    Layer.open({
                        type: 1,
                        title: "新增通道",
                        shadeClose: true,
                        area: ar,
                        content: content,
                        success: function (layero) {
                            var form = $("form", layero);
                            $("#wxqr").hide();
                            $("#qqqr").hide();
                            $("#zfb_pid").hide();
                            $("#ewm").hide();
                            $("#wxname").hide();
                            Form.api.bindevent(form, function (data) {
                                location.reload();
                                Layer.closeAll();
                            });
                        }
                    });
                });
                
            $(document).on('click', "input[name='type']", function () {
                var type=$('input:radio[name="type"]:checked').val();
                if(type=='alipay')
                {
                    $("#wxqr").hide();
                    $("#zfb_pid").hide();
                    $("#ewm").hide();
                    $("#wxname").hide();
                    $("#aliqr").show();
                    $("#qqqr").hide();
                }
                else if(type=='qqpay')
                {
                    $("#qqqr").show();
                    $("#wxqr").hide();
                    $("#aliqr").hide();
                    $("#zfb_pid").hide();
                    $("#ewm").hide();
                    $("#wxname").hide();
                }
                else
                {
                    $("#qqqr").hide();
                    $("#wxqr").show();
                    $("#aliqr").hide();
                    $("#zfb_pid").hide();
                    $("#ewm").hide();
                    $("#wxname").hide();
                }
                    
            });
            
            $(document).on('click', "input[name='channel_code']", function () {
                var channel_code=$('input:radio[name="channel_code"]:checked').val();
                if(channel_code=='alipay_app')
                {
                    $("#ewm").hide();
                    $("#zfb_pid").show();
                }
                else if(channel_code=='alipay_cloud')
                {
                    $("#ewm").hide();
                    $("#zfb_pid").hide();
                }
                else if(channel_code=='alipay_mg')
                {
                    $("#ewm").hide();
                    $("#zfb_pid").hide();
                }
                else if(channel_code=='wxpay_dy')
                {
                    $("#ewm").show();
                    $("#wxname").show();
                }
                else if(channel_code=='wxpay_cloud')
                {
                    $("#ewm").hide();
                    $("#wxname").hide();
                }
                else if(channel_code=='alipay_grmg')
                {
                    $("#ewm").hide();
                    $("#wxname").hide();
                    $("#zfb_pid").hide();
                }
                else
                {
                    $("#ewm").show();
                    $("#wxname").hide();
                }
                    
            });
            
                
            $(document).on("click", ".basic_channel", function () {
                    var id = "basicctpl";
                    var content = Template(id, {});
                    var mobile_flag = isMobile();
                    var ar = ["500px", "400px"];
                    if(mobile_flag)
                    {
                        ar = ["98%", "80%"];
                    }
                    Layer.open({
                        type: 1,
                        title: "通道配置",
                        shadeClose: true,
                        area: ar,
                        content: content,
                        success: function (layero) {
                            var form = $("form", layero);
                            Form.api.bindevent(form, function (data) {
                                location.reload();
                                Layer.closeAll();
                            });
                        }
                    });
                });
            
            function Up_Qr(id,cookie) { //更新二维码
            	var ii = layer.load(5, {
            		shade: [0.1, '#fff']
            	});
            	$.ajax({
                    url: 'ajax/upqrstatus',
                    dataType: 'json',
                    data: {id: id,cookie:cookie},
                    cache: false,
                    success: function (res) 
                    {
                        if(res.code==1)
                        {
                            location.reload();
                            Layer.closeAll();
                            layer.msg('更新成功', {icon: 1});
                        }
                        else
                        {
                            location.reload();
                            Layer.closeAll();
                            layer.msg('更新失败', {icon: 2});
                        }
                    }, error: function () {
                      Toastr.error(__('Network error'));
                    }
                });
            }
            
             
            
        }
    };
    return Controller;
});