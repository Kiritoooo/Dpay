define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'superads_images/index/ids/'+Config.ads_ids + location.search,
                    add_url: 'superads_images/add',
                    edit_url: 'superads_images/edit',
                    del_url: 'superads_images/del',
                    multi_url: 'superads_images/multi',
                    import_url: 'superads_images/import',
                    table: 'superads_images',
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
                        {field: 'imgtitle', title: __('Imgtitle'), operate: 'LIKE'},
                        {field: 'superads_id', title: __('Superads_id')},
                        {field: 'isforeverdata', title: __('Isforeverdata'), searchList: {"1":__('Isforeverdata 1'),"0":__('Isforeverdata 0')}, formatter: Table.api.formatter.normal},
                        {field: 'clickhref', title: __('Clickhref'), operate: 'LIKE'},
                        {field: 'adsimage', title: __('Adsimage'), operate: false, events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'livestime', title: __('Livestime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'liveetime', title: __('Liveetime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'memo', title: __('Memo'), operate: 'LIKE'},
                        {field: 'status', title: __('Status'), searchList: {"1":__('Status 1'),"0":__('Status 0')}, formatter: Table.api.formatter.status},
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