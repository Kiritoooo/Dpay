define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'vippack/index' + location.search,
                    add_url: 'vippack/add',
                    edit_url: 'vippack/edit',
                    //del_url: 'vippack/del',
                    multi_url: 'vippack/multi',
                    import_url: 'vippack/import',
                    table: 'vippack',
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
                        {checkbox: true},
                        //{field: 'id', title: __('Id')},
                        {
                            field: 'vip_nametext', 
                            title: __('Vip_nametext'), 
                            operate: false,
                            formatter:function(value,row,index)
                            {
                                return `<span style="color: red;font-weight: 700;">`+value+`</span>`;
                            }
                            
                        },
                        // {field: 'vip_type', title: __('Vip_type'), searchList: {"alipay":__('Vip_type alipay'),"wxpay":__('Vip_type wxpay'),"qqpay":__('Vip_type qqpay')}, formatter: Table.api.formatter.normal},
                        // {
                        //     field: 'vip_feilvtext', 
                        //     title: __('Vip_feilvtext'), 
                        //     operate: false,
                        //     formatter:function(value,row,index){
                        //         if(value==0)
                        //         {
                        //             return `<span style="color: red;font-weight: 700;">免费率</span>`;
                        //         }
                        //         else
                        //         {
                        //             return `<span style="color: red;font-weight: 700;">`+value+`%</span>`;
                        //         }
                        //     }
                        // },
                        {field: 'create_time', title: __('创建时间'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'status', title: __('Status'), searchList: {"0":__('Status 0'),"1":__('Status 1')}, formatter: Table.api.formatter.status},
                        {field: 'weigh', title: __('Weigh'), operate: false},
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
                text: __('配置套餐'),
                icon: 'fa fa-pencil',
                title: __('配置套餐'),
                classname: 'btn btn-xs btn-success btn-editone'
            }

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            
            Controller.api.bindevent();
            $(document).on("fa.event.appendfieldlist", ".btn-append", function(){
                Form.events.selectpage($(".fieldlist"));
            });
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});