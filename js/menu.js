(function($) {

    'use strict';

    window.MenuModal = function() {

        var _this = this,
            body = $('body'),
            container,
            blockBg,
            initTop,
            slider,
            open = false;

        this.initialize = function() {
            body.on('click', '.bindMenuModalOpen', function(e) {
                if(open === false) {
                    _this.modalOpen($(this).data('sca'), $(this).data('i')+0);//closest('li').index(); <-몇번인지 모름
                    open = true;
                }
                e.preventDefault();
            });
            body.on('click', '.menu_pop_close', this.modalX);
        };

        this.modalOpen = function(sca, i) {
            var requestUrl = CONST_ROOT+'/resource/menu.php';
            $.post(requestUrl, {sca: sca}, function(response) {
                if($('#menuModalPopup').length === 0) {
                    body.append(response);
                    container = $('#menuModalPopup');
                    initTop = parseFloat(container.css('margin-top'), 10);
                    container.css({display: 'block', opacity: 0, marginTop: initTop + 100});                    
                    slider = new CommonSlider(container.children('.slider-container'), {
                        startIndex: i,
                        prevBtn: container.children('.slider-prev'),
                        nextBtn: container.children('.slider-next'),
                    });
                    container.animate({opacity: 1, marginTop: initTop}, 800);
                } else {
                    slider.toIdx(i);
                }
            });
        };

        this.modalX = function(e) {
            container.animate({opacity: 0, marginTop: initTop - 100}, 300, function() {
                if(typeof slider.kill === 'function') slider.kill();
                $(this).remove();
                open = false;
            });
            e.preventDefault();
        };

        this.initialize();
    };

}(jQuery));

$(document).ready(function(){
    new Swiper('.lyr1_slide .swiper-container', {
        speed: 300,
            autoplay: {
            delay: 3000,
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
    });

    $('body').on('click','.tabmenu a',function(){
        $.post($(this).href,{sca:$(this).data('sca')},function(res){
            $('#menu').html($(res).find('#menu').html());
        });
    });

    new MenuModal();

    new YMotion([
        [
            {el: '.el1_1', set: {opacity: 0, y: 100}, to: {opacity: 1, y: 0}, d: 0.5},
            {el: '.el1_2', set: {opacity: 0, y: 100}, to: {opacity: 1, y: 0}, d: 0.5},
        ],
    ]).activate();
});
