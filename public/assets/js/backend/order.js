define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            
            $(document).on("click", ".btn-qlwzf", function () {
                layer.confirm('您确定清理所有未支付的订单吗？', {
                  btn: ['确定','取消']
                }, function(){
                  $.ajax({
                        url: 'order/delorder',
                        dataType: 'json',
                        cache: false,
                        success: function (ret) {
                            layer.msg("清理成功!");
                            table.bootstrapTable('refresh', {});
                        }, error: function () {
                            Toastr.error(__('Network error'));
                        }
                    });
                });
            });
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'order/index' + location.search,
                    add_url: 'order/add',
                    edit_url: 'order/edit',
                    del_url: 'order/del',
                    multi_url: 'order/multi',
                    import_url: 'order/import',
                    table: 'order',
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
                        {field: 'user_id', title: __('User_id')},
                        {field: 'typedata', title: __('Typedata'), searchList: {"alipay":__('Typedata alipay'),"wxpay":__('Typedata wxpay'),"qqpay":__('Typedata qqpay')}, formatter: Table.api.formatter.normal},
                        {field: 'qr_id', title: __('Qr_id')},
                        {field: 'trade_no', title: __('Trade_no'), operate: 'LIKE'},
                        {field: 'out_trade_no', title: __('Out_trade_no'), operate: 'LIKE'},
                        {field: 'name', title: __('Name'), operate: 'LIKE'},
                        {field: 'money', title: __('Money'), operate:'BETWEEN'},
                        {field: 'truemoney', title: __('Truemoney'), operate:'BETWEEN'},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'end_time', title: __('End_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        //{field: 'api_memo', title: __('返回值'), operate: 'LIKE'},
                        {field: 'status', title: __('Status'), searchList: {"0":__('Status 0'),"1":__('Status 1')}, formatter: Table.api.formatter.status},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });
            
            

            // 为表格绑定事件
            Table.api.bindevent(table);
            
            
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