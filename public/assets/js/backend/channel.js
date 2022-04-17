define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'channel/index' + location.search,
                    add_url: 'channel/add',
                    edit_url: 'channel/edit',
                    //del_url: 'channel/del',
                    multi_url: 'channel/multi',
                    import_url: 'channel/import',
                    table: 'channel',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'weigh',
                columns: [
                    [
                        //{checkbox: true},
                        //{field: 'id', title: __('Id')},
                        {
                            field: 'name', 
                            title: __('Name'), 
                            operate: false,
                            formatter:function(value,row,index)
                            {
                                return `<a target="_blank" style="color: #e74c3c; font-weight: 700;">`+ value+`</a>`;
                            }
                        },
                        {
                            field: 'type', 
                            title: __('Type'), 
                            operate: false,
                            formatter:function(value,row,index)
                            {
                                if(value == 'alipay')
                                {
                                    return `<a target="_blank" style="color: blue; font-weight: 700;">支付宝</a>`;
                                }
                                else if(value == 'wxpay')
                                {
                                    return `<a target="_blank" style="color: green; font-weight: 700;">微信</a>`;
                                }
                                else
                                {
                                    return `<a target="_blank" style="color: red; font-weight: 700;">QQ钱包</a>`;
                                }
                            }
                            
                        },
                        {
                            field: 'code', 
                            title: __('通道标识'), 
                            operate: false,
                            formatter:function(value,row,index)
                            {
                                return `<a target="_blank" style="color:#ff9800; font-weight: 700;">`+ value+`</a>`;
                            }
                        },
                        {field: 'count', title: __('账号数量'), operate: 'LIKE'},
                        {field: 'max_account', title: __('账号上限'), operate: 'LIKE'},
                        {field: 'remark', title: __('通道简介'), operate: 'LIKE'},
                        //{field: 'is_hot', title: __('是否推荐'),table: table, formatter: Table.api.formatter.toggle},
                        {
                            field: 'status', 
                            title: __('状态'),
                            formatter:function(value,row,index){
                                if(value == 1){
                                    return `<a href="javascript:;" class="btn btn-xs btn-success close-status" data-id="${row.id}" data-toggle="tooltip" data-original-title="点击关闭">已启用</a>`;
                                }else if(value == 0){
                                    return `<a href="javascript:;" class="btn btn-xs btn-default open-status" data-id="${row.id}" data-toggle="tooltip" data-original-title="点击启用">已关闭</a>`;
                                }else{
                                    return `<a href="javascript:;" class="btn btn-xs btn-danger">状态有误</a>`;
                                }
                            }
                        },
                        
                        //{field: 'creat_time', title: __('Creat_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });
            
            Table.button.dragsort = {
                name: 'dragsort',
                text: __('排序'),
                icon: 'fa fa-arrows',
                title: __('排序'),
                classname: 'btn btn-xs btn-primary btn-dragsort'
            }
            
            Table.button.edit = {
                name: 'edit',
                text: __('配置'),
                icon: 'fa fa-pencil',
                extend: 'data-area=\'["380px", "350px"]\'' ,
                title: __('配置'),
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
            //启用支付
            $(document).on("click", ".open-status", function () {
                var id = $(this).attr('data-id');
                layer.load();
                $.post("channel/openStatus", {id:id, 'status': 1}, function(e){
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
            //关闭支付
            $(document).on("click", ".close-status", function () {
                var id = $(this).attr('data-id');
                layer.load();
                $.post("channel/closeStatus", {id:id, 'status': 0}, function(e){
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
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});