(function($) {

    'use strict';

    window.ResponsiveMenu = function() {

        var _this = this;

        var containerId = '#menuInfoContainer',
            container = $(containerId),
            gridList = $('.grid_list > li'),
            prevBtnId = '#menuInfoPrev',
            nextBtnId = '#menuInfoNext',
            prevIndex = -1,
            index = -1,
            changing = false,
            slider,
            headerH = parseFloat($('#headerWrap').css('height'), 10),
            noImage = CONST_SKIN_PATH + '/img/noimage_view.png';

        var body = $('body');

        var LENGTH = gridList.length;

        this.initialize = function() {
            this.setHandler();
        };

        this.setHandler = function() {
            body.on('click', '.grid_list > li > a', function(e) {
                if(changing === false) {
                    changing = true;
                    var self = $(this).parent('li');
                    prevIndex = index;
                    index = self.index();
                    if(index !== prevIndex) _this.appendMenu(self.data('idx'), index - prevIndex > 0 ? 'next' : 'prev');
                    else changing = false;
                    _this.paging();
                }
                e.preventDefault();
            });
            body.on('click', '#menuInfoPrev', function() {
                if(changing === false) {
                    changing = true;
                    _this.appendMenu($(this).data('idx'), 'prev');
                    prevIndex = index;
                    index--;
                    index === 0 ? index = 0 : index;
                    _this.paging();
                }
            });
            body.on('click', '#menuInfoNext', function() {
                if(changing === false) {
                    changing = true;
                    _this.appendMenu($(this).data('idx'), 'next');
                    prevIndex = index;
                    index++;
                    index === LENGTH ? index = LENGTH - 1 : index;
                    _this.paging();
                }
            });
            $('body').on('click', '#menuInfoX', function() {
                container.stop().slideUp(300, function() {
                    container.empty();
                });
                prevIndex = -1;
                index = -1;
            });
        };

        this.appendMenu = function(idx, dir) {
            function goToTop() {
                TweenLite.to('html, body', 0.4, {scrollTop: container.offset().top - 70});
            }
            $.post(this.href, {idx: idx}, function(response) {
                if(container.children().length > 0) {
                    container.find('.slider-wrapper:not(.nested)').append($(response).find(containerId).find('.slider-wrapper:not(.nested)').html());
                    var tempEl = $(containerId).find('.slider-items:not(.nested):last-child');
                    if(dir === 'next') tempEl.css({position: 'absolute', left: '100%', top: 0});
                    else tempEl.css({position: 'absolute', left: '-100%', top: 0});
                    var src = tempEl.find('.menu_best_wrap .slider-wrapper li:first-child img').attr('src');
                    if(typeof src === 'undefined') src = noImage;
                    var img = new Image();
                    img.onload = function() {
                        _this.move(tempEl);
                        goToTop();
                    };
                    img.onerror = function() {
                        _this.notice('이미지를 불러올 수 없습니다.');
                    };
                    img.src = src;
                } else {
                    container.html($(response).find(containerId).html());
                    var src = $(containerId).find('.slider-items:not(.nested):eq(0) .menu_best_wrap .slider-wrapper li:first-child img').attr('src');
                    if(typeof src === 'undefined') src = noImage;
                    var img = new Image();
                    img.onload = function() {
                        container.slideDown(400, function() {
                            changing = false;
                            _this.paging();
                            _this.slide();
                        });
                        goToTop();
                    };
                    img.onerror = function() {
                        _this.notice('이미지를 불러올 수 없습니다.');
                    };
                    img.src = src;
                }
            }, 'html').error(function(e) {
    			_this.notice(e.statusText);
    		});
        };

        this.move = function(el) {
            TweenLite.to(el, 0.4, {left: 0, onComplete: function() {
                $(containerId).find('.slider-items:not(.nested):last-child').css({position: 'relative'});
                $(containerId).find('.slider-items:not(.nested)').not(':last-child').remove();
                _this.slide();
                changing = false;
            }});
        };

        this.paging = function() {
            if(index < LENGTH - 1) $(nextBtnId).data('idx', gridList.eq(index + 1).data('idx')).show(0);
            else $(nextBtnId).hide(0);
            if(index > 0) $(prevBtnId).data('idx', gridList.eq(index - 1).data('idx')).show(0);
            else $(prevBtnId).hide(0);
        };

        this.slide = function() {
            if(typeof slider === 'object' && typeof slider.kill === 'function') slider.kill();
            $('.menu_best_wrap .slider-container').find('img').css({position: 'relative'});
            slider = new CommonSlider($('.menu_best_wrap .slider-container'), {
                interval: 3000,
                pagination : $('.menu_best_wrap .mb_paging_area .mb_paging')
            });
			if($('.review_con_wrap li').length > 0) {
				new CommonSlider($('.review_con_wrap .slider-container'), {
					interval : 4000,
					axis : 'y',
					itemsPerView : 5,
					autoPlay: true,
					prevBtn: $('.review_con_wrap .btn_prev'),
					nextBtn: $('.review_con_wrap .btn_next')
				});
			}
			new Movie();
			$('.grid_list li a').removeClass('on');
			$('.grid_list li[data-idx="'+$('#menuInfoContainer .slider-items:not(.nested):last-child').data('idx')+'"] a').addClass('on');
        };

        this.notice = function(msg) {
            container.empty();
            changing = false;
            alert(msg);
        };

        this.initialize();
    };

    doc.ready(function() {
        new ResponsiveMenu();
    });

}(jQuery));