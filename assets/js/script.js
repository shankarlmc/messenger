(function ($) {
    "use strict";

    /*=====================
      01. Tooltip js
      ==========================*/
      tippy('.sidebar-main .icon-btn', {
        theme: 'tooltiprad',
        placement: 'right-end',
        arrow: false
    });
      tippy('.user-popup', {
        content: "Status",
        theme: 'gradienttooltip',
        placement: 'right-end',
        arrow: false
    });
      tippy('.calls  > li > .icon-btn', {
        placement: 'bottom-end',
        arrow: true
    });
      tippy('.clfooter a', {
        placement: 'top-end',
        arrow: true
    });
      tippy('.audiocall2 a', {
        placement: 'top-end',
        arrow: true
    });
      tippy('.videocall a', {
        placement: 'top-end',
        arrow: true
    });

      $(".bg-img").parent().addClass('bg-size');
      $('.bg-img').each(function () {
        var el = $(this),
        src = el.attr('src'),
        parent = el.parent();
        parent.css({
            'background-image': 'url(' + src + ')',
            'background-size': 'cover',
            'background-position': 'center',
            'display': 'block'
        });
        el.hide();
    });

    /*=====================
      03. OwlCarousel js
      ==========================*/
      var owl_carousel_custom_recent = {
        init: function () {
            var recent = $('.recent-slider');
            recent.owlCarousel({
                items: 3,
                dots: false,
                loop: true,
                margin: 15,
                nav: false,
                autoplay: true,
                autoplayTimeout: 2000,
                autoplayHoverPause: true,
                responsive: {
                    768: {
                        items: 7
                    },
                    800: {
                        items: 7
                    },
                    801: {
                        items: 2
                    },
                    1366: {
                        items: 2
                    },
                    1600: {
                        items: 3
                    }
                }
            })
        }
    };
    owl_carousel_custom_recent.init();

    /*=====================
         04. Chitchat Loder js
         ==========================*/
         $('.chitchat-loader').slideUp('slow', function () {
            $(this).remove();
        });

    /*=====================
         05. Search js
         ==========================*/
         $('.search').on('click', function (e) {
            $(this).siblings().toggleClass("open");
        });
         $('.close-search').on('click', function (e) {
            $(this).parent().parent().removeClass("open");
        });
        //  $('.search-right').on('click', function (e) {
        //     $(this).parent().parent().parent().parent().parent().parent().find(".form-inline").toggleClass("open");
        // });
         $('.close-search').on('click', function (e) {
            $(this).parent().parent().removeClass("open");
        });



    /*=====================
         08. Collapse Title js
         ==========================*/
         $('.block-title').on('click', function (e) {
            e.preventDefault;
            var speed = 300;
            var thisItem = $(this).parent(),
            nextLevel = $(this).next('.block-content');
            if (thisItem.hasClass('open')) {
                thisItem.removeClass('open');
                nextLevel.slideUp(speed);
            } else {
                thisItem.addClass('open');
                nextLevel.slideDown(speed);
            }
        });

    /*=====================
         09. Refresh Request information next & previous button
         ==========================*/
         $('.req-info').on('click', function (e) {
            $(this).addClass('disabled');
        });
         $('.next').on('click', function (e) {
            $(this).parent().parent().siblings().addClass('open');
        });
         $('.previous').on('click', function (e) {
            $(this).parent().parent().parent().removeClass('open');
        });

         $('.chat-cont-toggle').on('click', function (e) {
            $('.chat-cont-setting ').toggleClass('open');
        });


    /*=====================
          11.Header fix
          ==========================*/
          $(window).scroll(function () {
            var scroll = $(window).scrollTop();
            if (scroll >= 60) {
                $(".landing-header").addClass("fixed");
            } else {
                $(".landing-header").removeClass("fixed");
            }
        });
    /*=====================
      12.Tap on Top
      ==========================*/
      $(window).on('scroll', function () {
        if ($(this).scrollTop() > 600) {
            $('.tap-top').fadeIn();
        } else {
            $('.tap-top').fadeOut();
        }
    });
      $('.tap-top').on('click', function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });


    /*=====================
    14 footer responsive js
    ==========================*/
    var contentwidth = jQuery(window).width();
    if ((contentwidth) < '768') {
        jQuery('.footer-title h3').append('<span class="according-menu"></span>');
        jQuery('.footer-title').on('click', function () {
            jQuery('.footer-title').removeClass('active');
            jQuery('.footer-contant').slideUp('normal');
            if (jQuery(this).next().is(':hidden') == true) {
                jQuery(this).addClass('active');
                jQuery(this).next().slideDown('normal');
            }
        });
        jQuery('.footer-contant').hide();
    } else {
        jQuery('.footer-contant').show();
    }



    /*=====================
        18 custom tab
        ==========================*/
        $(".contact-log-main li , .call-log-main li").on('click', function () {
            $(this).parent().find("li").removeClass("active");
            $(this).addClass("active");
        });
        $("#myTab1 li a").on('click', function () {
            var active_class = $(this).attr("data-to");
            $('.messages.custom-scroll').removeClass("active");
            $('#' + active_class).addClass("active");
        });
        $(".chat-tabs .nav-tabs li[data-to]").on('click', function () {
            $('.chitchat-main .tabto').removeClass("active");
            var active_class = $(this).attr("data-to");
            $('.' + active_class).addClass("active");
        });
        $(".sidebar-top  a").on('click', function () {
            $(".sidebar-top  a").removeClass("active");
            $(this).addClass("active");
            $('.dynemic-sidebar').removeClass("active");
            var active_class = $(this).attr("href");
            $('#' + active_class).addClass("active");
        });


    /*=====================
      22. toggle classes
      ==========================*/
      $('.chat-main .chat-box').on('click', function () {
        $('.chitchat-container').toggleClass("mobile-menu");
    });
      $('.group-main .group-box').on('click', function () {
        $('.chitchat-container').toggleClass("mobile-menu");
    });
      $('.call-log-main .call-box').on('click', function () {
        $('.chitchat-container').toggleClass("mobile-menu");
    });
      $('.contact-log-main .contact-box').on('click', function () {
        $('.chitchat-container').toggleClass("mobile-menu");
    });

      $('.mobile-back').on('click', function () {
        $('.chitchat-container').toggleClass("mobile-menu");
        $('.main-nav').removeClass("on");
    });


      $('.chat-friend-toggle').on('click', function () {
        $('.chat-frind-content').toggle();
    });

      $('.gr-chat-friend-toggle').on('click', function () {
        $('.gr-chat-frind-content').toggle();
    });
      $('.msg-setting').on('click', function () {
        $(this).siblings('.msg-dropdown').toggle();
    });
      $(".favourite").on('click', function () {
        $(this).toggleClass("btn-outline-primary").toggleClass("btn-primary");
    });
      $(".edit-btn").on('click', function () {
        $(this).parent().parent().toggleClass("open");
    });



    /*=====================
           27. profile open close
           ==========================*/
           $('.menu-trigger, .close-profile').on('click', function (e) {
            $('body').toggleClass('menu-active'); //add class
            $('.app-sidebar').toggleClass('active'); //remove
            $('.chitchat-main').toggleClass("small-sidebar"); //remove
            if($( window ).width() <= 1440 ) {
                $('.chitchat-container').toggleClass('sidebar-overlap');
              $('.chitchat-main').addClass("small-sidebar"); //remove
          }
          if ($('body').hasClass('menu-active')) {
            $('body').addClass('sidebar-active main-page');
            $('.app-sidebar').removeClass('active');
            $('.chitchat-main').removeClass("small-sidebar");
        }

    });
    /*=====================
           28. dropdown
           ==========================*/

           $('.dropdown').click(function () {
            $(this).attr('tabindex', 1).focus();
            $(this).toggleClass('active');
            $(this).find('.dropdown-menu').slideToggle(300);
        });
           $('.dropdown').focusout(function () {
            $(this).removeClass('active');
            $(this).find('.dropdown-menu').slideUp(300);
        });
           $('.dropdown .dropdown-menu li').click(function () {
            $(this).parents('.dropdown').find('span').text($(this).text());
            $(this).parents('.dropdown').find('input').attr('value', $(this).attr('id'));
        });

        $('.message__area').keypress(function (e) {
          var key = e.which;
          if(key == 13)
           {
             $('#__send__message').click();
             return false;
           }
          });

        $(".emojis-sub-contain ul li").click(function () {
            var number = $(this).html();
            $(".message__area").focus().val(function() {
               return this.value + number;
               $(".messages").animate({
                scrollTop: $(document).height()
            }, "fast");

           });
            $('#__send__message').removeClass('disabled').removeAttr("disabled")
        });


        $('#__send__message').addClass('disabled').attr("disabled", "disabled")

        $(".message__area").keyup(function(e){
            if(!e.target.value){
                $('#__send__message').addClass('disabled').attr("disabled","disabled")
            } else {
                $('#__send__message').removeClass('disabled').removeAttr("disabled")
            }
        });

      //   function newMessage() {
      //       var message = $('.message-input input').val();
      //       if($.trim(message) == '') {
      //           return false;
      //       }
      //       $('<li class="replies"> <div class="media"> <div class="profile mr-4 bg-size" style="background-image: url(&quot;../assets/images/contact/1.jpg&quot;); background-size: cover; background-position: center center;"></div><div class="media-body"> <div class="contact-name"> <h5>Alan josheph</h5> <h6>01:42 AM</h6> <ul class="msg-box"> <li> <h5>' + message + '</h5> </li></ul> </div></div></div></li>').appendTo($('.messages .chatappend'));
      //       $('.message-input input').val(null);
      //       $('.chat-main .active .details h6').html('<span>You : </span>' + message);
      //       $(".messages").animate({ scrollTop: $(document).height() }, "fast");
      //   };
      //
      //   function typingMessage() {
      //     $('<li class="sent last typing-m"> <div class="media"> <div class="profile mr-4 bg-size" style="background-image: url(&quot;../assets/images/contact/2.jpg&quot;); background-size: cover; background-position: center center; display: block;"><img class="bg-img" src="../assets/images/contact/2.jpg" alt="Avatar" style="display: none;"></div><div class="media-body"> <div class="contact-name"> <h5>Josephin water</h5> <h6>01:42 AM</h6> <ul class="msg-box"> <li> <h5> <div class="type"> <div class="typing-loader"></div></div></h5> </li></ul> </div></div></div></li>').appendTo($('.messages .chatappend'));
      //     $(".messages").animate({ scrollTop: $(document).height() }, "fast");
      //     setTimeout(function() {
      //       $('.typing-m').hide();
      //       $('<li class="sent"> <div class="media"> <div class="profile mr-4 bg-size" style="background-image: url(&quot;../assets/images/contact/2.jpg&quot;); background-size: cover; background-position: center center; display: block;"></div><div class="media-body"> <div class="contact-name"> <h5>Josephin water</h5> <h6>01:35 AM</h6> <ul class="msg-box"> <li> <h5> Sorry I busy right now, I will text you later </h5> <div class="badge badge-success sm ml-2"> R</div></li></ul> </div></div></div></li>').appendTo($('.messages .chatappend'));
      //       $(".messages").animate({ scrollTop: $(document).height() }, "fast");
      //   }, 2000);
      // }
      // user register


    // Toggle sticker
    $('.toggle-sticker').on('click', function () {
        $(this).toggleClass("active");
        $('.sticker-contain').toggleClass("open");
        $('.emojis-contain').removeClass("open");
        $(".toggle-emoji").removeClass("active");
        $('.contact-poll-content').css('display', 'none');
    });

    // Toggle emoji
    $('.toggle-emoji').on('click', function (e) {
        e.stopPropagation();
        $(this).toggleClass("active");
        $('.emojis-contain').toggleClass("open");
        // $(".sticker-contain").removeClass("open");
        // $(".toggle-sticker").removeClass("active");
        // $('.contact-poll-content').css('display', 'none');
        // $('#linkPlaceholder').css('display', 'none');
        // $('#setemoj').css('display', 'block');

    });


    $('.file-uploader').on('click', function (e) {
        e.stopPropagation();
        $(this).toggleClass("active");
        $('#myMedia').click();
    });
    $("#myMedia").change(function(){
      var file =  this.files[0].name;
      $(".message__area").focus().val(file);
      $('.file-uploader').removeClass('active');
      $('#__send__message').removeClass('disabled').removeAttr("disabled");
    });

    $('#file-selector').on('click', function (e) {
        e.stopPropagation();
        $(this).toggleClass("active");
        $('#profile_pic').click();

    });

    // Toggle poll
    $('.contact-poll').on('click', function (e) {
        $('.contact-poll-content').toggle();
    });

    // Outside click
    $(document).on('click', function (e) {
        var outside_space = $(".outside");
        if (!outside_space.is(e.target) &&
            outside_space.has(e.target).length === 0) {
            $(".sticker-contain").removeClass("open");
        $(".emojis-contain").removeClass("open");
        $(".toggle-emoji, .toggle-sticker").removeClass("active");
        $('.contact-poll-content').css('display', 'none');
        $('.chat-frind-content').css('display', 'none');
    }
})

    $(".mode").on("click", function () {
        $('.mode i').toggleClass("fa-moon-o").toggleClass("fa-lightbulb-o");
        $('body').toggleClass("dark");
        // $(".chat-cont-setting").removeClass("open");
    });

    $(".mainnav").on("click", function () {
        $('.theme-title .icon-btn').toggleClass("btn-outline-light").toggleClass("btn-outline-primary");
        $('.main-nav').toggleClass("on");
    });



})(jQuery);
