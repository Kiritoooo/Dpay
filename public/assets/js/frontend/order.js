define(['jquery', 'bootstrap', 'frontend'], function ($, undefined, Frontend) {
    var Controller = {
        index: function () {
             $(document).on("click", ".callback", function () {
                var id =  $(this).attr("data-id");
                layer.confirm('此操作将会给对接系统充值到账，是否确定？', {
                  btn: ['确定','取消']
                 }, function(){
                     $.ajax({
                        url: 'order/notity_order',
                        dataType: 'json',
                        data: {id: id},
                        cache: false,
                        success: function (ret) {
                            layer.msg(ret.msg);
                        }, error: function () {
                            Toastr.error(__('Network error'));
                        }
                    });
                     
                  
                });
            });
            
            $(document).on("click", ".order_del", function () {
                var id =  $(this).attr("data-id");
                layer.confirm('删除后不可恢复，是否确定？', {
                  btn: ['删除','取消']
                 }, function(){
                  $.ajax({
                        url: 'order/delorder',
                        dataType: 'json',
                        data: {id: id},
                        cache: false,
                        success: function (ret) {
                            layer.msg(ret.msg);
                        }, error: function () {
                            Toastr.error(__('Network error'));
                        }
                    });
                });
            });
            
            
            
        },
        vip: function () {
            $(document).on("click", ".price-list a", function () {
                var form = $(this).closest("form");
                if (!$(this).hasClass("active")) {
                    $(this).closest(".price-list").find("a").removeClass("active");
                    $(this).addClass("active");
                    $("input[name='days']", form).val($(this).data("days"));
                }
                
                return false;
            });

            $(document).on("click", ".row-paytype label", function () {
                var form = $(this).closest("form");
                $(".row-paytype label", form).removeClass("active");
                $(this).addClass("active");
                $("input[name=paytype]", form).val($(this).data("value"));
            });

            $(document).on("click", "a.price-item", function () {
                var form = $(this).closest("form");
                $(".row-pricelist a", form).removeClass("active");
                $(this).addClass("active");
                $("input[name=days]", form).val($(this).data("days"));
               // alert(0);
            });
        },
    };
    return Controller;
});