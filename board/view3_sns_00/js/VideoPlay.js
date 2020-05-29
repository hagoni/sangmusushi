(function($) {

    'use strict';

    window.VideoPlay = function() {

        var _this = this,
            body = $('body'),
            boardWrapperId = '#boardWrap',
            containerId = '#videoViewContainer',
            anchor = $('.bindVideoPlay'),
            prevBtnId = '#videoPrevBtn',
            nextBtnId = '#videoNextBtn',
            lists = $('#videoListContainer > li'),
            prevIndex = -1,
            index = lists.filter('.on').index(),
			offsetTop = $(containerId).offset().top - parseFloat($('#headerWrap').css('height'), 10),
            changing = false;

        var LENGTH = lists.length;

        this.initialize = function() {
            this.setHandler();
        };

        this.setHandler = function() {
            anchor.click(function(e) {
                if(changing === false) {
                    changing = true;
                    prevIndex = index;
                    index = $(this).closest('li').index();
                    if(index !== prevIndex) _this.videoReload();
                    else _this.notice('현재 재생 중인 영상입니다.');
                }
                e.preventDefault();
            });
            body.on('click', prevBtnId, function(e) {
                if(changing === false) {
                    changing = true;
                    prevIndex = index;
                    index--;
                    if(index > -1) _this.videoReload();
                    else _this.pageReload(this);
                }
                e.preventDefault();
            });
            body.on('click', nextBtnId, function(e) {
                if(changing === false) {
                    changing = true;
                    prevIndex = index;
                    index++;
                    if(index < LENGTH) _this.videoReload();
                    else _this.pageReload(this);
                }
                e.preventDefault();
            });
        };

        this.videoReload = function() {
            $.post(location.href, {idx: lists.eq(index).data('idx')}, function(response) {
                $('html, body').animate({scrollTop: offsetTop}, 200, function() {
                    changing = false;
                });
                $(containerId).html($(response).find(containerId).html());
            }, 'html').error(function(e) {
                _this.notice(e.statusText);
            });
        };

        this.pageReload = function(s) {
            $.post(location.href, {page: $(s).data('page')}, function(response) {
                $(boardWrapperId).html($(response).find(boardWrapperId).html());
                changing = false;
            }, 'html').error(function(e) {
                _this.notice(e.statusText);
            });
        };

        this.notice = function(msg) {
            changing = false;
            alert(msg);
        };

        this.initialize();
    };

    doc.ready(function() {
        new VideoPlay();
    });

}(jQuery));