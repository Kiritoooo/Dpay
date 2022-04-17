define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'user/user/index',
                    add_url: 'user/user/add',
                    edit_url: 'user/user/edit',
                    del_url: 'user/user/del',
                    multi_url: 'user/user/multi',
                    table: 'user',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'user.id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id'), sortable: true},
                        //{field: 'group.name', title: __('Group')},
                        {field: 'username', title: __('Username'), operate: 'LIKE'},
                        //{field: 'nickname', title: __('Nickname'), operate: 'LIKE'},
                        {field: 'email', title: __('Email'), operate: 'LIKE'},
                        //{field: 'mobile', title: __('Mobile'), operate: 'LIKE'},
                        {field: 'user_key', title: __('用户密钥'), operate: 'LIKE'},
                        {field: 'money', title: __('用户余额'), operate: 'BETWEEN', sortable: true},
                        {field: 'successions', title: __('Successions'), visible: false, operate: 'BETWEEN', sortable: true},
                        {field: 'maxsuccessions', title: __('Maxsuccessions'), visible: false, operate: 'BETWEEN', sortable: true},
                        {
                            field: 'alipay_feilv', 
                            title: __('支付宝费率'), 
                            operate: false,
                            formatter:function(value,row,index){
                                if(value==0)
                                {
                                    return `<span style="color: blue;">免费率</span>`;
                                }
                                else
                                {
                                    return `<span style="color: blue;">`+value+`%</span>`;
                                }
                            }
                        },
                        {
                            field: 'wxpay_feilv', 
                            title: __('微信费率'), 
                            operate: false,
                            formatter:function(value,row,index){
                                if(value==0)
                                {
                                    return `<span style="color: blue;">免费率</span>`;
                                }
                                else
                                {
                                    return `<span style="color: blue;">`+value+`%</span>`;
                                }
                            }
                        },
                        {
                            field: 'alipay_time', 
                            title: __('支付宝会员'), 
                            operate: false,
                            formatter:function(value,row,index){
                                var timestamp = Date.parse(new Date()) / 1000;
                                if(value<timestamp)
                                {
                                    return `<span style="color: red;">未开通或已过期</span>`;
                                }
                                else
                                {
                                    return new Date(parseInt(value) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');
                                }
                            }
                        },
                        {
                            field: 'wxpay_time', 
                            title: __('微信会员'), 
                            operate: false,
                            formatter:function(value,row,index){
                                var timestamp = Date.parse(new Date()) / 1000;
                                if(value<timestamp)
                                {
                                    return `<span style="color: red;">未开通或已过期</span>`;
                                }
                                else
                                {
                                    return new Date(parseInt(value) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');
                                }
                            }
                        },
                        {field: 'allmoney', title: __('总流水'), operate: 'LIKE'},
                        {field: 'yearmoney', title: __('昨日流水'), operate: 'LIKE'},
                        {field: 'daymoney', title: __('今日流水'), operate: 'LIKE'},
                        {field: 'status', title: __('Status'), formatter: Table.api.formatter.status, searchList: {normal: __('Normal'), hidden: __('Hidden')}},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });
            Table.button.edit = {
                name: 'edit',
                text: __('修改'),
                icon: 'fa fa-pencil',
                title: __('修改会员'),
                classname: 'btn btn-xs btn-success btn-editone'
            }
            
            Table.button.del = {
                name: 'del',
                text: __('删除'),
                icon: 'fa fa-trash',
                title: __('删除'),
                classname: 'btn btn-xs btn-danger btn-delone'
            }

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            
            $(document).on('click', ".rankey", function () {
                
                $.ajax({
                    url: 'user/user/creat_uuid',
                    dataType: 'json',
                    cache: false,
                    success: function (ret) {
                        if(ret.code==1)
                        {
                            $("#c-user_key").val(ret.user_key);
                        }
                        layer.msg('密钥生成成功,请保存');
                    }, error: function () {
                        Toastr.error(__('Network error'));
                    }
                });
            });
            
            
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