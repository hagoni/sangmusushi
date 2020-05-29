(function() {
	$(document).ready(function() {
        //인테리어모달
        (function($) {

        	'use strict';

        	window.IntModal = function() {

        		var _this = this,
        			body = $('body'),
        			container,
        			blockBg,
                    initTop,
                    modalSlider,
        			open = false;

        		this.initialize = function() {
        			body.on('click', '.int_btn', function(e) {
        				if(open === false) {
        					_this.modalOpen($(this).data('sca'), $(this).data('i')+0);//closest('li').index(); <-몇번인지 모름
        					open = true;
        				}
        				e.preventDefault();
        			});
        			body.on('click', '.int_pop_close', this.modalX);
        		};

        		this.modalOpen = function(sca, i) {
        			var requestUrl = CONST_ROOT + '/resource/interior.php';
        			$.post(requestUrl, {root: CONST_ROOT, sca: sca}, function(response) {
                        if($('#IntModalPopup').length === 0) {
                            body.append(response);
                            container = $('#IntModalPopup');
                            initTop = parseFloat(container.css('margin-top'), 10);
                            container.css({display: 'block', opacity: 0});
        					modalSlider = new Swiper(('.int_pop .swiper-container'), {
                                navigation: {
                                    nextEl: '.int_next',
                                    prevEl: '.int_prev',
                                },
                                pagination: {
                                    el: '.int_paging',
                                    type: 'fraction',
                                },
        					});
                            container.animate({opacity: 1}, 500);
                        }
        			});
        		};

        		this.modalX = function(e) {
        			container.animate({opacity: 0}, 300, function() {
        				if(typeof modalSlider.destroy === 'function'){
                            modalSlider.destroy();
                        }
        				$(this).remove();
        				open = false;
        			});
        			e.preventDefault();
        		};

        		this.initialize();
        	};

        }(jQuery));

        //메뉴모달
        (function($) {

        	'use strict';

        	window.MenuModal = function() {

        		var _this = this,
        			body = $('body'),
        			container,
        			blockBg,
                    initTop,
                    modalSlider,
        			open = false;

        		this.initialize = function() {
        			body.on('click', '.menu_btn', function(e) {
        				if(open === false) {
        					_this.modalOpen($(this).data('sca'), $(this).data('i')+0);//closest('li').index(); <-몇번인지 모름
        					open = true;
        				}
        				e.preventDefault();
        			});
        			body.on('click', '.menu_pop_close', this.modalX);
        		};

        		this.modalOpen = function(sca, i) {
        			var requestUrl = CONST_ROOT + '/resource/menu.php';
        			$.post(requestUrl, {root: CONST_ROOT, sca: sca}, function(response) {
                        if($('#MenuModalPopup').length === 0) {
                            body.append(response);
                            container = $('#MenuModalPopup');
                            container.css({display: 'block', opacity: 0});
        					modalSlider = new Swiper(('.menu_pop .swiper-container'), {
                                navigation: {
                                    nextEl: '.menu_next',
                                    prevEl: '.menu_prev',
                                },
                                pagination: {
                                    el: '.menu_paging',
                                    type: 'fraction',
                                },
        					});
                            container.animate({opacity: 1}, 500);
                        }
        			});
        		};

        		this.modalX = function(e) {
        			container.animate({opacity: 0}, 300, function() {
        				if(typeof modalSlider.destroy === 'function'){
                            modalSlider.destroy();
                        }
        				$(this).remove();
        				open = false;
        			});
        			e.preventDefault();
        		};

        		this.initialize();
        	};

        }(jQuery));

        new IntModal();
        new MenuModal();
    });
}())
