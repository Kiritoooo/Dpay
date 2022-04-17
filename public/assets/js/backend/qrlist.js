define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'qrlist/index' + location.search,
                    add_url: 'qrlist/add',
                    edit_url: 'qrlist/edit',
                    del_url: 'qrlist/del',
                    multi_url: 'qrlist/multi',
                    import_url: 'qrlist/import',
                    table: 'qrlist',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'code', title: __('通道标识'), operate: 'LIKE',formatter: Table.api.formatter.label},
                        {field: 'user_id', title: __('User_id')},
                        {
                            field: 'type', 
                            title: __('支付类型'), 
                            operate: false,
                            formatter:function(value,row,index){
                                if(value=='alipay')
                                {
                                    return `<span style="color: red;font-weight:900;">支付宝</span>`;
                                }
                                else if(value=='wxpay')
                                {
                                    return `<span style="color: red;font-weight:900;">微信</span>`;
                                }
                                else
                                {
                                    return `<span style="color: red;font-weight:900;">钱包</span>`;
                                }
                            }
                        },
                        
                        {
                            field: 'code', 
                            title: __('通道类型'), 
                            operate: false,
                            formatter:function(value,row,index){
                                if(value=='alipay_mg')
                                {
                                    return `<span style="color: red;font-weight:900;">本地免挂</span>`;
                                }
                                else if(value=="alipay_gm")
                                {
                                    return `<span style="color: red;font-weight:900;">固码免挂</span>`;
                                }
                                else if(value=="alipay_app")
                                {
                                    return `<span style="color: red;font-weight:900;">APP监控</span>`;
                                }
                                else if(value=="alipay_cloud")
                                {
                                    return `<span style="color: red;font-weight:900;">PC云监控</span>`;
                                }
                                else if(value=="wxpay_dy")
                                {
                                    return `<span style="color: red;font-weight:900;">店员免挂</span>`;
                                }
                                else if(value=="wxpay_cloud")
                                {
                                    return `<span style="color: red;font-weight:900;">云端免挂</span>`;
                                }
                                else if(value=="wxpay_app")
                                {
                                    return `<span style="color: red;font-weight:900;">APP监控</span>`;
                                }
                                else if(value=="alipay_grmg")
                                {
                                    return `<span style="color: red;font-weight:900;">个人免挂</span>`;
                                }
                                else if(value=="qqpay_mg")
                                {
                                    return `<span style="color: red;font-weight:900;">本地免挂</span>`;
                                }
                                else
                                {
                                    return `<span style="color: red;font-weight:900;">PC云监控</span>`;
                                }
                            },
                        },
                        
                        {field: 'money', title: __('Money'), operate: 'LIKE'},
                        {field: 'succ_ordercount', title: __('Succ_ordercount')},
                        {
                            field: 'day_maxmoney', 
                            title: __('日收款上限'), 
                            operate: false,
                            formatter:function(value,row,index){
                                if(value==0)
                                {
                                    return `<span style="color: blue;font-weight:900;">无限制</span>`;
                                }
                                else
                                {
                                    return `<span style="color: blue;font-weight:900;">`+value+`%</span>`;
                                }
                            }
                        },
                        {
                            field: 'all_maxmoney', 
                            title: __('总收款上限'), 
                            operate: false,
                            formatter:function(value,row,index){
                                if(value==0)
                                {
                                    return `<span style="color: blue;font-weight:900;">无限制</span>`;
                                }
                                else
                                {
                                    return `<span style="color: blue;font-weight:900;">`+value+`%</span>`;
                                }
                            }
                        },
                        {
                            field: 'is_cloud', 
                            title: __('云端守护'), 
                            operate: false,
                            formatter:function(value,row,index)
                            {
                                if(row.code=='wxpay_cloud')
                                {
                                    if(value==1)
                                    {
                                        return `<a href="javascript:;" class="btn btn-xs btn-success close-status" data-id="${row.id}" data-toggle="tooltip" data-original-title="点击关闭">守护中</a>`;
                                    }
                                    else
                                    {
                                        return `<a href="javascript:;" class="btn btn-xs btn-danger open-status" data-id="${row.id}" data-toggle="tooltip" data-original-title="点击启用">未启用</a>`;
                                    }
                                }
                                else
                                {
                                    return `-`;
                                }
                            }
                        },
                        {field: 'is_status', title: __('是否启用'), operate: 'LIKE', formatter: Table.api.formatter.toggle},
                        {field: 'status', title: __('在线/离线'),formatter: Table.api.formatter.toggle},
                        {
                            field: 'operate',
                            width: "200px",
                            title: __('Operate'),
                            table: table,
                            events: Table.api.events.operate,
                            buttons: [
                               
                                {
                                    name: 'detail',
                                    text: '收款详情',
                                    icon: 'fa fa-pencil',
                                    extend: 'data-area=\'["380px", "310px"]\'' ,
                                    title: function (row) {
                                        return "通道收款详情";
                                    },
                                    classname: 'btn btn-xs btn-info btn-dialog',
                                    url: function (row) {
                                        return 'qrlist/detail/id/' + row['id'];
                                    }
                                },
                                
                                
                            ],
                            formatter: Table.api.formatter.operate
                        }
                        //{field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });
            Table.button.edit = {
                name: 'edit',
                text: __('配置账号'),
                icon: 'fa fa-pencil',
                title: __('配置账号'),
                classname: 'btn btn-xs btn-success btn-editone'
            }
            
            Table.button.del = {
                name: 'del',
                text: __('删除账号'),
                icon: 'fa fa-trash',
                title: __('删除账号'),
                classname: 'btn btn-xs btn-danger btn-delone'
            }

            // 为表格绑定事件
            Table.api.bindevent(table);
            
            //启用支付
            $(document).on("click", ".open-status", function () {
                var id = $(this).attr('data-id');
                layer.load();
                $.post("qrlist/openStatus", {id:id, 'status': 1}, function(e){
                    if(e.code == 200){
                        layer.closeAll();
                        Toastr.success(e.msg);
                        table.bootstrapTable('refresh', {});
                    }else{
                        layer.closeAll('loading');
                        Toastr.error(e.msg);
                    }
                }).error(function(){
                    layer.closeAll('loading');
                    Toastr.error('服务器错误！');
                })
            });
            $(document).on("click", ".close-status", function () {
                var id = $(this).attr('data-id');
                layer.load();
                $.post("qrlist/closeStatus", {id:id, 'status': 0}, function(e){
                    if(e.code == 200){
                        layer.closeAll();
                        Toastr.success(e.msg);
                        table.bootstrapTable('refresh', {});
                    }else{
                        layer.closeAll('loading');
                        Toastr.error(e.msg);
                    }
                }).error(function(){
                    layer.closeAll('loading');
                    Toastr.error('服务器错误！');
                })
            });
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        detail: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});