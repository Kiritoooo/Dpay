define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'user_bak/index' + location.search,
                    add_url: 'user_bak/add',
                    edit_url: 'user_bak/edit',
                    del_url: 'user_bak/del',
                    multi_url: 'user_bak/multi',
                    import_url: 'user_bak/import',
                    table: 'user_bak',
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
                        {field: 'group_id', title: __('Group_id')},
                        {field: 'username', title: __('Username'), operate: 'LIKE'},
                        {field: 'nickname', title: __('Nickname'), operate: 'LIKE'},
                        {field: 'password', title: __('Password'), operate: 'LIKE'},
                        {field: 'salt', title: __('Salt'), operate: 'LIKE'},
                        {field: 'email', title: __('Email'), operate: 'LIKE'},
                        {field: 'mobile', title: __('Mobile'), operate: 'LIKE'},
                        {field: 'avatar', title: __('Avatar'), operate: 'LIKE', events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'level', title: __('Level')},
                        {field: 'gender', title: __('Gender')},
                        {field: 'birthday', title: __('Birthday'), operate:'RANGE', addclass:'datetimerange', autocomplete:false},
                        {field: 'bio', title: __('Bio'), operate: 'LIKE'},
                        {field: 'money', title: __('Money'), operate:'BETWEEN'},
                        {field: 'score', title: __('Score')},
                        {field: 'successions', title: __('Successions')},
                        {field: 'maxsuccessions', title: __('Maxsuccessions')},
                        {field: 'prevtime', title: __('Prevtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'logintime', title: __('Logintime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'loginip', title: __('Loginip'), operate: 'LIKE'},
                        {field: 'loginfailure', title: __('Loginfailure')},
                        {field: 'joinip', title: __('Joinip'), operate: 'LIKE'},
                        {field: 'jointime', title: __('Jointime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'token', title: __('Token'), operate: 'LIKE'},
                        {field: 'status', title: __('Status'), operate: 'LIKE', formatter: Table.api.formatter.status},
                        {field: 'verification', title: __('Verification'), operate: 'LIKE'},
                        {field: 'user_key', title: __('User_key'), operate: 'LIKE'},
                        {field: 'alipay_time', title: __('Alipay_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'wxpay_time', title: __('Wxpay_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'qqpay_time', title: __('Qqpay_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'order_out_time', title: __('Order_out_time'), operate: 'LIKE'},
                        {field: 'lixian_notity', title: __('Lixian_notity')},
                        {field: 'alipay_open', title: __('Alipay_open')},
                        {field: 'wxpay_open', title: __('Wxpay_open')},
                        {field: 'qqpay_open', title: __('Qqpay_open')},
                        {field: 'alipay_pid', title: __('Alipay_pid'), operate: 'LIKE'},
                        {field: 'feilv', title: __('Feilv'), operate: 'LIKE'},
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