new WOW().init();

$(function () {
    "use strict";

    $('.toggle-info').click(function(){
        $(this).toggleClass('selected').parent().next('.card-body').fadeToggle( 100);
        if($(this).hasClass('selected')){
            $(this).html(' <i class="fa fa-plus fa-lg"></i>');
        }else{
            $(this).html(' <i class="fa fa-minus fa-lg"></i>');
        }
    });
    // hide placeholder from inputs
    $("[placeholder]").focus(function () {
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    }).blur(function () {
        $(this).attr('placeholder', $(this).attr('data-text'));
    })

    // add asterisk to input required
    $('input').each(function () {
        if ($(this).attr('required') === 'required') {
            $(this).after('<span class ="asterisk">*</span>');
        }
    });
    // show and hidden password
    var passFiled = $('.password');
    $('.show-pass').hover(function () {
        passFiled.attr('type', 'text');
    }, function () {
        passFiled.attr('type', 'password');
    });
    //confirmation you want delete recurde or no
    $('.confrim').click(function () {
        return confirm('ARE YOU SURE');
    });
    // toggle in JQ
    $('.cat h3').click(function(){
        $(this).next('.fullView').fadeToggle(200);
    });
    //
    // $('.option span').click(function(){
    //     $(this).addClass('active').siblings('span').removeClass('active');
    //     if($(this).data('view')=== 'full'){
    //         $('.cat .fullView').fadeIn(200);
    //     }else{
    //         $('.cat .fullView').fadeOut(200);
    //     }
    // })
    $('.live-name').keyup(function(){
        $('.live-preview .caption h5').text($(this).val());
    });
    $('.live-desc').keyup(function(){
        $('.live-preview .caption p').text($(this).val());
    });
    $('.live-price').keyup(function(){
        $('.live-preview  span').text($(this).val());
    })
});