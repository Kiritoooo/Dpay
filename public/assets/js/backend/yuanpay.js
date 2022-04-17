define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'yuanpay/index' + location.search,
                    edit_url: 'yuanpay/edit',
                    table: 'yuanpay',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'weigh',
                commonSearch: false,
                showExport: false,
                columns: [
                    [
                        // {checkbox: false},
                        // {field: 'id', title: __('ID')},
                        {
                            field: 'name', 
                            title: __('Name'), 
                            operate: false,
                            formatter:function(value,row,index){
                                if(value == '易支付'){
                                    return `<a target="_blank" style="color: #e74c3c; font-weight: 700;">【易支付】官方推荐</a>`;
                                }else{
                                    return value;
                                }
                            }
                            
                        },
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
                        // {field: 'type', title: __('Type'), operate: 'LIKE'},
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
                title: __('配置'),
                classname: 'btn btn-xs btn-success btn-editone'
            }
            

            // 为表格绑定事件
            Table.api.bindevent(table);
            
            
            
            //启用支付
            $(document).on("click", ".open-status", function () {
                var id = $(this).attr('data-id');
                layer.load();
                $.post("yuanpay/openStatus", {id:id, 'status': 1}, function(e){
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
                $.post("yuanpay/closeStatus", {id:id, 'status': 0}, function(e){
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