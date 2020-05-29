(function() {

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
	                    _this.modalOpen($(this).data('sca'), $(this).data('idx'));
	                    open = true;
	                }
	                e.preventDefault();
	            });
	            body.on('click', '.menu_pop_close', this.modalX);
	        };

	        this.modalOpen = function(sca, i) {
	            $.post(location.href, {modal: true, sca: sca, idx:i}, function(response) {
	                if($('#menuModalPopup').length === 0) {
	                    body.append($(response).filter('#menuModalPopupParent').length > 0 ? $(response).filter('#menuModalPopupParent').html() : $(response).find('#menuModalPopupParent').html());
	                    container = $('#menuModalPopup');
	                    initTop = parseFloat(container.css('margin-top'), 10);
	                    container.css({display: 'block', opacity: 0, marginTop: initTop + 100});
	                    slider = new Swiper(container.find('.swiper-container')[0], {
	                        initialSlide: i,
	                        navigation : {
	                            prevEl: container.children('.pv-prev'),
	                            nextEl: container.children('.pv-next'),
	                        },
	                        repeat: false,
	                        loop: false,
	                        preloadImages: false,
	                        lazy: true
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



	$(document).ready(function() {
		new Swiper('.lyr2_slide .swiper-container', {
            loop:true,
            speed: 500,
                autoplay: {
                delay: 1500,
            },
            effect: 'fade',
            fadeEffect: {
            	crossFade: true
            },
            allowTouchMove: false,
        });

		$('.menu_tab').hide();
		$('body').on('click', '.tab_a', function () {
			$('.menu_tab').slideToggle();
		});

		$('body').on('click', '.menu_tab li', function () {
			$('.menu_tab li').removeClass('on');
			$(this).addClass('on');
		});

		$('body').on('click','.menu_tab a',function(){
	        $.post($(this).href,{sca:$(this).data('sca')},function(res){
				var title = $(res).find('.menu_tab li.on').text();
	            $('#menu').html($(res).find('#menu').html());
				$('#menu').find('.tab_a').text(title);
				$('.menu_tab').hide();
	        });
	    });

		new MenuModal();

    });
}())
