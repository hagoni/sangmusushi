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
                TweenLite.to('html, body', 0.4, {scrollTop: container.offset().top - headerH});
            }
            $.post(this.href, {idx: idx}, function(response) {
                if(container.children().length > 0) {
                    container.find('.slider-wrapper').append($(response).find(containerId).find('.slider-wrapper').html());
                    var tempEl = $(containerId).find('.slider-items:last-child');
                    if(dir === 'next') tempEl.css({position: 'absolute', left: '100%', top: 0});
                    else tempEl.css({position: 'absolute', left: '-100%', top: 0});
                    var src = tempEl.find('.menu_img_area > img').attr('src');
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
                    var src = $(containerId).find('.slider-items:eq(0) .menu_img_area > img').attr('src');
                    if(typeof src === 'undefined') src = noImage;
                    var img = new Image();
                    img.onload = function() {
                        container.slideDown(400, function() {
                            changing = false;
                            _this.paging();
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
                $(containerId).find('.slider-items:last-child').css({position: 'relative'});
                $(containerId).find('.slider-items').not(':last-child').remove();
                changing = false;
            }});
        };

        this.paging = function() {
            if(index < LENGTH - 1) $(nextBtnId).data('idx', gridList.eq(index + 1).data('idx')).show(0);
            else $(nextBtnId).hide(0);
            if(index > 0) $(prevBtnId).data('idx', gridList.eq(index - 1).data('idx')).show(0);
            else $(prevBtnId).hide(0);
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