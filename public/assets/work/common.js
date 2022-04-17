$(function () {
    // 预约咨询弹窗
    // var show_service = "{$show_service}";
    var show_service = 2; //默认是否显示咨询弹窗  1-显示 2不显示

    //判断是否有引入某个js/css文件
    function isInclude(name) {
        var js = /js$/i.test(name);
        var es = document.getElementsByTagName(js ? 'script' : 'link');
        for (var i = 0; i < es.length; i++)
            if (es[i][js ? 'src' : 'href'].indexOf(name) != -1) return true;
        return false;
    }
    if (isInclude('wow.min.js')) {
        if (!(/msie [6|7|8|9]/i.test(navigator.userAgent))) {
            new WOW().init();
        }
    }
    setScrollNav();
    $(window).scroll(function () {
        setScrollNav();
    });
    function setScrollNav() {
        if ($('.swiper-category').length && $(window).width() < 1024) {
            if ($(window).scrollTop() > 0) {
                $('.header').removeClass('header-fixed');
            } else {
                $('.header').addClass('header-fixed');
            }
        } else {
            if ($(window).scrollTop() > 0) {
                $('.header').addClass('header-fixed');
            } else {
                $('.header').removeClass('header-fixed');
            }
        }
    }
    if ($('.swiper-category').length && $(window).width() < 1024) {
        var skip_nav_position = $('.swiper-category').offset().top;
        //滚动条事件
        if (!$('.swiper-category').hasClass("category2")) {
            $(window).scroll(function () {
                $('.swiper-category').css({ 'position': 'fixed' });
                if ($(window).scrollTop() < skip_nav_position) {
                    $('.swiper-category').css({ 'position': 'absolute' });
                }
            });
        }
    }
    var slidesPerView = 7;
    if ($(window).width() < 768) {
        slidesPerView = 3;
        var simpleSwiper = new Swiper('.simple-swiper', {
            slidesPerView: slidesPerView,
            spaceBetween: 10,
            loop: true,
            autoplay: true
        });
    }
    // 轮播菜单
    if ($(window).width() < 1024) {
        if (($(".swiper-category").length && !$(".swiper-category").hasClass("category2")) || ($(".swiper-category").hasClass("category2") && $(window).width() < 768)) {
            new Swiper('.swiper-category', {
                slidesPerView: slidesPerView,
                initialSlide: $('.skip-item .on').index() >= 0 ? $('.skip-item .on').index() : $('.swiper-category .on').index(),
                navigation: {
                    nextEl: '.skip-next',
                    prevEl: '.skip-prev'
                },
                on: {
                    init: function () {
                        if (this.isBeginning) {
                            $(".swiper-category .skip-prev").hide()
                        } else {
                            $(".swiper-category .skip-prev").show()
                        }
                        if (this.isEnd) {
                            $(".swiper-category .skip-next").hide()
                        } else {
                            $(".swiper-category .skip-next").show()
                        }
                    },
                    slideChange: function () {
                        if (this.isBeginning) {
                            $(".swiper-category .skip-prev").hide()
                        } else {
                            $(".swiper-category .skip-prev").show()
                        }
                        if (this.isEnd) {
                            $(".swiper-category .skip-next").hide()
                        } else {
                            $(".swiper-category .skip-next").show()
                        }
                    },
                },
            });
        }
        var slidePerView02 = 5, spaceBetween = 0;
        if ($(window).width() < 850 && $(window).width() > 640) {
            slidePerView02 = 4; spaceBetween = 0
        } else if ($(window).width() < 640) {
            slidePerView02 = 2; spaceBetween = 0;
        }
        var swiperfz02 = new Swiper('.fz02-container', {
            slidesPerView: slidePerView02,
            spaceBetween: spaceBetween,
            autoplay: $(window).width() < 1024,
        });
    }

    /* banner */
    if ($('.banner').length) {
        if ($('.banner').find("li").length >= 2) {
            var banner = new Swiper('.banner', {
                loop: true,
                effect: 'fade',
                autoplay: {
                    delay: 3000
                },
                watchSlidesProgress: !0,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    renderBullet: function (index, className) {
                        return '<span class="' + className + '"><i></i></span>';
                    }
                },
                on: {
                    init: function () {
                        swiperAnimateCache(this); //隐藏动画元素 
                        swiperAnimate(this); //初始化完成开始动画
                    },
                    slideChangeTransitionEnd: function () {
                        swiperAnimate(this); //每个slide切换结束时也运行当前slide动画
                        //this.slides.eq(this.activeIndex).find('.ani').removeClass('ani'); 动画只展现一次，去除ani类名
                    },
                    autoplayStop: function () {
                        $('.banner').addClass('autoplayStop')
                    }
                },
            });
            if (banner.slides.length - 2 < 2) {
                $('.swiper-pagination').hide();
            }
        }
    }

    /* 解决方案 */
    var slidePerView02 = 5, spaceBetween = 0;
    if ($(window).width() < 850 && $(window).width() > 640) {
        slidePerView02 = 4; spaceBetween = 0
    } else if ($(window).width() < 640) {
        slidePerView02 = 2; spaceBetween = 0;
    }
    var swiper02 = new Swiper('.jiejue-container', {
        slidesPerView: slidePerView02,
        spaceBetween: spaceBetween,
        loop: true,
        autoplay: $(window).width() < 1024,
        navigation: {
            nextEl: '.skip-next',
            prevEl: '.skip-prev'
        }
    });
    /* 聚合支付 */
    if ($(window).width() >= 1024) {
        var maodian = window.location.hash.split("#")[1];   // 锚点
        var $maodian = $("a[name=" + maodian + "]")
        var maodianIndex = $maodian.parent().index() > -1 ? $maodian.parent().index() : 0;
        $maodian.length && $("html,body").animate({scrollTop: $maodian.offset().top - "60" + "px"}, 0);
        var $swiperSlide = $(".mobile-container .swiper-slide");
        var swiper03 = new Swiper('.mobile-container', {
            initialSlide: 0,
            loop: true,
            autoplay: {
                disableOnInteraction: false,
            },
            direction: 1000,
            direction: 'vertical',
            on: {
                slideChangeTransitionStart: function () {
                    var activeIndex = this.$(".mobile-container .swiper-slide-active").data("index");
                    $('.info-juhe li').eq(activeIndex).children(".zhijiao-box").addClass("active").parent().siblings().children(".zhijiao-box").removeClass("active");
                },
            },
        });
        function setSwiper(mySwiper, index){
            mySwiper.removeAllSlides();
            $swiperSlide.each(function(i, el){
                if(index == $(el).data("index")){
                    mySwiper.appendSlide(el);
                }
            })
            if(mySwiper.slides.length > 3){
                mySwiper.autoplay.start()
                mySwiper.allowSlidePrev = mySwiper.allowSlideNext = true;
                mySwiper.slideToLoop(0, 0, true);
            } else {
                mySwiper.autoplay.stop();
                mySwiper.slideToLoop(0, 0, true);
                mySwiper.allowSlidePrev = mySwiper.allowSlideNext = false;
            }
        }
        if($swiperSlide.length){
            setSwiper(swiper03, maodianIndex);
        }
        $('.info-juhe .zhijiao-box').click(function () {
            setSwiper(swiper03, $(this).parent().index());
        })
        $('.mobile-container').mouseenter(function () {
            swiper03.autoplay.stop();
        }).mouseleave(function () {
            swiper03.autoplay.start();
        })
    }

    if ($(window).width() < 1024) {
        $('.nav>li').click(function (e) {
            if ($(this).find('.sub').length) {
                e.preventDefault();
                $(this).toggleClass("active");
                $(this).find('.sub').slideToggle();
            }
        });
        $('.sub li').click(function (e) {
            e.stopPropagation();
        })
    } else {
        $('.nav>li').hover(function () {
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
        }).mouseleave(function () {
            $('.nav>li').removeClass('active');
        })
    }

    $('#menu-btn').click(function () {
        if ($(this).hasClass('menu-btn-close')) {
            $(this).removeClass('menu-btn-close');
            $('.nav').hide()
            $('.header').css('height', 50);
        } else {
            $(this).addClass('menu-btn-close');
            $('.nav').show();
            $('.header').css({
                'height': '100%',
                'backgroundColor': 'rgba(255,255,255,.98)'
            });
        }

    });

    // 侧边固定栏
    if ($(window).width() <= 768) {
        $('.right-fix-kf').removeClass("expand");
    }
    $('.online-show>a').click(function () {
        $(this).parents('.right-fix-kf').toggleClass('expand');
    })

    $('.appoint').click(function () {
        $('#fix-appoint-btn').addClass('hide');
        $('#fix-appoint').animate({ 'bottom': 0 });
    })
    $('#close-appoint').click(function () {
        $('#appoint-item').css('bottom', '-100%')
    })
    // 预约咨询弹窗
    // var show_service = "{$show_service}";
    // var show_service = 1;
    if (show_service == 1) {
        $('#fix-appoint-btn').addClass('hide');
        $('#fix-appoint').animate({ 'bottom': 0 });
    }



    $('#service_submit').click(function () {
        var company = $('#company').val();
        var username = $('#username').val();
        var mobile = $('#mobile').val();
        var address = $('#address').val();
        // $.post("{:url('activity/submit_service')}",{address:address,mobile:mobile,username:username,company:company},function(e){
        //     shwo_tips(e);
        // });
    });


    $('.select-title input').click(function () {
        $(this).closest('.select-skin').addClass('active').find('.pre_server_select-list').slideToggle();
    });

    $('.pre_server_select-list dd').click(function () {

        $('.select-title input').closest('.select-skin').removeClass('active').find('.pre_server_select-list').slideUp();
        var v = $(this).text();
        $(this).closest('.select-skin').find('.select-input').val(v);
        if ($('.pre_server_select-list dd').text() == '之后提醒') {
            $('.pre_server_select-list dd').text('不需要');
        } else {
            $('.pre_server_select-list dd').text('之后提醒');
        }
    })

    $("#service_close").click(function () {
        if ($(".select-input").val() == '不需要') {
            $.get("{:url('index/show_preserver_box')}");
        }
        //$.post("{:url('activity/close_service')}",{},function(e){});

    });
    $('#fix-appoint .close').click(function () {
        $('.fix-appoint-btn').removeClass('hide');
        $('#fix-appoint').animate({ 'bottom': '-100%' });
    });
    function shwo_tips(e) {
        $('#tips-c').text(e.msg);
        $('#tips-f').show();
        var code = e.code;
        setTimeout(function () {
            $('#tips-f').hide();
            if (code == 1) {
                $("#service_close").click();
            }
        }, 3000)
    }

    // 边框加直角
    $(".zhijiao-box").append('<div class="zhijiao"><i></i><i></i><i></i><i></i></div>')


    // 输入框-下划线
    // input-underline focused
    $(".input-underline input").focus(function () {
        $(this).parent().addClass("focused")
    }).blur(function () {
        $(this).parent().removeClass("focused")
    })


    var ticking = false; // rAF 触发锁
    function onScroll() {
        if (!ticking) {
            requestAnimationFrame(realFunc);
            ticking = true;
        }
    }
    function realFunc() {
        windowScroll();
        ticking = false;
    }
    // 滚动事件监听
    window.addEventListener('scroll', onScroll, false);

    var bool, flag = true, wave;
    if ($('#skip-nav').length) {
        // var skip_nav_position = $('#skip-nav').offset().top;
        var skip_nav_position = $('.skip-div-wrapper').offset().top;
    }

    if ($('[data-skip-nav]').length) {
        var nav_position = $('[data-skip-nav]').offset().top;
    }

    //用户在当前界面刷新时，导航条fixed
    windowScroll();

    function windowScroll() {
        var wscrollT = $(window).scrollTop();
        if ($('#banner').length || $('#banner-cdn').length) {
            var scrollH = $('#banner').height() || $('#banner-cdn').height();
            // if(wscrollT > 0){
            //     $('.header').css({
            //         'background-color':'#193456'
            //     });
            // }else{
            //     $('.header').css({
            //         'background-color':'rgba(0,0,0,0)'
            //     });
            // }
        }
        //云服务器及解决方案的滑动导航有id为skip-nav时固定nav-skip
        if ($('#skip-nav').length) {
            //console.log(skip_nav_position)
            var block_name = $('#skip-nav').attr('data-block-name');
            var li_num = $('.animate-skip li:not(.outlink)').length;
            $('.header').css({ 'position': 'absolute' });
            $('#skip-nav').css({ 'position': 'fixed' });
            !$('#skip-nav').hasClass('outNav') ? $('#skip-nav').find('.on').removeClass('on') : '';
            if (wscrollT <= skip_nav_position) {
                !$('#skip-nav').hasClass('outNav') ? $('.animate-skip').find('li').eq(0).addClass('on') : '';
                $('.animate-skip').css({ 'position': 'relative' })
            } else {
                for (var i = 0; i < li_num; i++) {
                    if (wscrollT > $('.' + block_name + '0' + i).offset().top - 60) {
                        $('.animate-skip li:not(.outlink)').eq(i).prevAll().removeClass('on');
                        $('.animate-skip li:not(.outlink)').eq(i).addClass('on');
                    }
                }
            }
        }

        if ($('[data-skip-nav]').length) {
            if (wscrollT > 50) {
                $('[data-skip-nav]').css('top', wscrollT < $('.document-r')[0].offsetHeight - 300 ? wscrollT - 50 : $('.document-r')[0].offsetHeight - 300);
            }

            var li_num = $('.document-skip li').length;
            for (var i = 0; i < li_num; i++) {
                var attrName = '[data-item=' + $('.document-skip li').eq(i).data('id') + ']';
                if (wscrollT > $(attrName).offset().top - 300) {
                    $('.document-skip li').siblings().removeClass('on');
                    $('.document-skip li').eq(i).addClass('on');
                }
            }
        }

        var scrollHeight = $(document).height();
        var windowHeight = $(window).height();

        bool = (wscrollT + windowHeight + 720 > scrollHeight);


        if (bool) {
            if (flag) {
                if (wave) wave.play();
            }
        } else {
            flag = true;
            if (wave) wave.pause();
        }

    }

    //点击滚动条跳转
    $('.animate-skip li').click(function () {
        if ($(this).closest('.animate-skip').data('switch')) {
            var id = $(this).data('id');
            $(this).siblings().removeClass('on');
            $(this).addClass('on');
            $('[data-item-id]').hide();
            $('[data-item-id=' + id + ']').fadeIn()
        } else {
            var space = $(this).height() - 1;
            var block_name = $(this).parents('#skip-nav').attr('data-block-name');
            $("html, body").animate({ scrollTop: $('.' + block_name + '0' + $(this).index()).offset().top - space });
        }
    });

    /* 新本页跳转 */
    $('[data-skip=true] li').click(function () {
        $(this).siblings().removeClass('on');
        $(this).addClass('on');
        $("html, body").animate({ scrollTop: $('[data-item=' + $(this).data('id') + ']').offset().top - 75 });
    });

    // 微信分账
    if ($(".weixinfz-tabs li").length) {
        $(".section-weixinfz-03").slide({ titCell: ".weixinfz-tabs li", mainCell: ".tabs-content", interTime: 6000, trigger: 'click', autoPlay: true });
    }

    // 表单
    $(".input-wrap .input-skin").on("focus", function () {
        var $clear = $(this).siblings(".btn-clear");
        var $eyes = $(this).siblings(".btn-eyes");
        if ($clear && !!$(this).val()) {
            $clear.show()
        }
        if ($eyes) {
            if ($(this).attr("type") == 'password') {
                $(this).siblings(".btn-hide").show().siblings('.btn-eyes').hide();
            } else {
                $(this).siblings(".btn-show").show().siblings('.btn-eyes').hide();
            }
        }
    }).on("blur", function () {
        var $clear = $(this).siblings(".btn-clear");
        var $eyes = $(this).siblings(".btn-eyes");
        if ($clear) {
            $clear.fadeOut(50);
        }
        if ($eyes && !$(this).val()) {
            $eyes.fadeOut(50);
        }
    }).on("input propertychange", function () {
        var $clear = $(this).siblings(".btn-clear");
        $(this).parent().removeClass('err')
        var $tip = $(this).siblings(".tip");
        $tip.remove();
        if ($clear && !!$(this).val()) {
            $clear.show()
        }else if($clear){
            $clear.hide()
        }
    })
    $(".btn-clear").on("click", function () {
        var $input = $(this).siblings(".input-skin");
        if ($input) {
            $input.val('');
            $input.trigger("input");
            $input.focus();
        }
    })
    $(".btn-eyes").on("click", function () {
        var $input = $(this).siblings(".input-skin");
        $(this).hide().siblings('.btn-eyes').show();
        if ($input.attr('type') == 'password') {
            $input.prop("type", 'text');
        } else {
            $input.prop("type", 'password');
        }
        $input.focus();
    })
})

/* 帮助中心*/
function show_help(div_name, obj) {
    $('.helper li').removeClass('on');
    $(obj).addClass('on');
    $('.detail').hide();
    $('.buypage').hide();
    $('.' + div_name).show();
    window.location.href = "#content_top";
}

function show_page(div_name, obj) {
    $('.animate-skip li').removeClass('on');
    $(obj).addClass('on');
    if (div_name != 'sec01' && div_name != 'sec02' && div_name != 'sec03') {
        $('.section').hide();
        $('.buypage').hide();
        $('#' + div_name).show();
        window.location.href = "#content_top";
    } else {
        $('.section').show();
        $('#sec04').hide();
        $('#sec05').hide();
        $('.buypage').hide();
        window.location.href = "#" + div_name;
    }
}

/*购买套餐和价格明细*/
function show_buypage(div_name) {
    $('.section').hide();
    $('.buypage').show();
    window.location.href = "#"+div_name;
}

// 显示提示信息
function show_msg(content, time){
    var time = time || 3000;
    if(content === ''){return;}
    $(".pop").remove();
    var $pop = $('<div class="pop"></div>').appendTo('body');
    $pop.html('<div class="pop-content">'+ content +'</div>');
    var w_w = $(window).width();
    var w_h = $(window).height();
    var p_w = $pop.width();
    var p_h = $pop.height();
    $pop.css({
        left: (w_w - p_w) / 2,
        top: (w_h - p_h) / 2
    });
    $pop.addClass("pop-show-anim");
    setTimeout(function(){
        $pop.addClass("pop-hide-anim");
        setTimeout(function(){
            $pop.remove();
        },200);
    }, time);
}

//唤起QQ聊天
function evoke_chat(qq) {
    //判断手机端还是电脑端
    if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent) || /(Android)/i.test(navigator.userAgent)) {

        if (window.navigator.userAgent.toLowerCase().match(/MicroMessenger/i) == 'micromessenger') {
            //微信浏览器 （qq推广方式）
            window.location.href = "http://wpa.qq.com/msgrd?v=3&uin="+qq+"&site=qq&menu=yes";
        }
        else {
            //手机app（url schema方式）
            window.location.href = "mqqwpa://im/chat?chat_type=wpa&uin="+qq+"&version=1&src_type=web&web_src=oicqzone.com";
        }
    }
    else {
        window.location.href = "tencent://message/?uin="+qq+"&Site=www.kk30.com&Menu=yes";
    }

}