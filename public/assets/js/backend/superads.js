define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'superads/index' + location.search,
                    add_url: 'superads/add',
                    edit_url: 'superads/edit',
                    del_url: 'superads/del',
                    multi_url: 'superads/multi',
                    import_url: 'superads/import',
                    table: 'superads',
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
                        {field: 'adsname', title: __('Adsname'), operate: 'LIKE'},
                        {field: 'adstag', title: __('Adstag'), operate: 'LIKE'},
                        {field: 'adswidth', title: __('Adswidth')},
                        {field: 'adsheight', title: __('Adsheight')},
                        {field: 'typedata', title: __('Typedata'), searchList: {"1":__('Typedata 1'),"2":__('Typedata 2'),"3":__('Typedata 3')}, formatter: Table.api.formatter.normal},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'memo', title: __('Memo'), operate: 'LIKE'},
                        {field: 'status', title: __('Status'), searchList: {"1":__('Status 1'),"0":__('Status 0')}, formatter: Table.api.formatter.status},
                        {field:'buttons',width: "120px",title: __('管理'),table: table,events: Table.api.events.operate,
                        buttons: [   
                            {
                                name: 'addtabs',
                                text: __('广告管理'),
                                title: __('广告管理'),
                                classname: 'btn btn-xs btn-warning btn-addtabs',
                                icon: 'fa fa-folder-o',
                                url: 'superads_images/index'
                            },
                            {
                                name: 'codeget',
                                extend:'data-area=\'["70%","500px"]\'',
                                text: __('js快捷调用'),
                                title: __('js快捷调用'),
                                classname: 'btn btn-xs btn-success btn-dialog',
                                icon: '',
                                url: 'superads/getjscode',
                                callback: function (data) {
                                    Layer.alert("接收到回传数据：" + JSON.stringify(data), {title: "回传数据"});
                                },
                                visible: function (row) {
                                    //返回true时按钮显示,返回false隐藏
                                    return true;
                                }
                            }
                        ],
                        formatter: Table.api.formatter.buttons},
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
        getjscode:function(){
            
            $(document).on("click", "#copybtn", function () {
                    
                   var contents =  $('#copycontent').html();
                   var input = document.createElement('input');
                    document.body.appendChild(input);
                    input.setAttribute('value', contents);
                    input.select();
                    if (document.execCommand('copy')) {
                        document.execCommand('copy');
                        layer.msg('复制成功');
                    }
                    document.body.removeChild(input);

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

