(function($) {

    'use strict';

    window.SnsModal = function(options) {

        var _this = this;

        var opt = {modalImgPath: CONST_SKIN_PATH + '/img/snsModal'};

        for(var prop in options) {
			opt[prop] = options[prop];
		}

        var body = $('body'),
            containerId = '#snsModalContainer',
            containerH,
            container,
            contentId = '#snsContent',
            anchor = '.bindSnsModalOpen',
            xBtnId = '#snsModalX',
            spinId = '#snsSpinner',
            modalHtml = '',
            modalPosition,
            modalTop,
            blockBg,
            resizeTimer = null,
            changing = false;

        this.initialize = function() {
            this.setModalHtml();
            this.setHandler();
        };

        this.setModalHtml = function() {
            modalHtml += '<div id="snsModalContainer" style="display:none">\n';
            modalHtml += '  <div class="sns_modal_wrap">\n';
            modalHtml += '      <div id="snsContent">\n';
            modalHtml += '      </div>\n';
            modalHtml += '      <div id="snsSpinner"><img src="'+ opt.modalImgPath +'/spinner01.gif" alt="" /></div>\n';
            modalHtml += '  </div>\n';
            modalHtml += '  <button type="button" id="snsModalPrev" class="sns_modal_btns"><img src="'+ opt.modalImgPath +'/modal_prev.png" alt="이전"></button>\n';
            modalHtml += '  <button type="button" id="snsModalNext" class="sns_modal_btns"><img src="'+ opt.modalImgPath +'/modal_next.png" alt="다음"></button>\n';
            modalHtml += '  <button type="button" id="snsModalX"><img src="'+ opt.modalImgPath +'/modal_x.png" alt="닫기"></button>\n';
            modalHtml += '</div>';
        };

        this.setHandler = function() {
            body.on('click', anchor, this.modalOpen);
            body.on('click', xBtnId, this.modalX);
        };

        this.modalOpen = function(e) {
            if(changing === false) {
                var self = $(this);
                body.append('<div id="blockBg" style="position:fixed;left:0;top:0;z-index:999;width:100%;height:100%;background:#999"></div>');
                blockBg = $('#blockBg');
                blockBg.css('opacity', 0.6);
                body.append(modalHtml);
                container = $(containerId);
                _this.fixModalCss();
                container.css({display: 'block', opacity: 0, position: modalPosition, top: modalTop + 50});
                container.animate({opacity: 1, top: modalTop}, 500, function() {
                    blockBg.click(_this.modalX);
                    win.resize(_this.resize);
                    switch(self.data('type')) {
                        case 'iframe':
                            _this.iframe(self);
                            break;
                        default:
                            _this.modal(self);
                            break;

                    }
                    changing = false;
                });
                changing = true;
            }
            e.preventDefault();
        };

        this.iframe = function(el) {
            function urlChange() {
                $(iframeId).removeAttr('src');
                $(spinId).show(0);
                $(iframeId).attr('src', iframeList.eq(index).find(anchor).attr('href'));
                setTimeout(function() {
                    $(spinId).hide(0);
                    changing = false;
                }, 1000);
            }

            function paging() {
                if(index < length - 1) $(nextBtnId).show(0);
                else $(nextBtnId).hide(0);
                if(index > 0) $(prevBtnId).show(0);
                else $(prevBtnId).hide(0);
            }

            var iframeHtml = '<iframe id="iframeContent" width="100%" height="100%" frameborder="0" scrolling="yes"></iframe>',
                iframeId = '#iframeContent',
                nextBtnId = '#snsModalNext',
                prevBtnId = '#snsModalPrev',
                prevIndex = -1,
                index = el.closest('li').index();

            var iframeList = el.closest('li').parent().children(),
                length = iframeList.length;

            $(contentId).html(iframeHtml);
            $(iframeId).attr('src', el.attr('href'));
            $(spinId).hide();
            if(length > 1) {
                body.on('click', nextBtnId, function() {
                    if(changing === false) {
                        changing = true;
                        prevIndex = index;
                        index++;
                        index === length ? index = length - 1 : index;
                        urlChange();
                        paging();
                    }
                });
                body.on('click', prevBtnId, function() {
                    if(changing === false) {
                        changing = true;
                        prevIndex = index;
                        index--;
                        index < 0 ? index = 0 : index;
                        urlChange();
                        paging();
                    }
                });
                paging();
            }
        };

        this.modal = function(el) {
            var requestUrl = el.data('type') === 'facebook' ? CONST_ROOT + '/board/index.php?board=sns&sca=blog&tab=2&fbContainerId='+ encodeURIComponent('#') + 'snsContent' : CONST_ROOT + '/board/index.php?board=sns&sca=blog&tab=3&igContainerId='+ encodeURIComponent('#') + 'snsContent';
            $.get(requestUrl, function(response) {
                $(contentId).html(el.data('type') === 'facebook' ? $(response).find('.fb_wrap') : $(response).find('.ig_wrap'));
                $(contentId).css('overflow-y', 'scroll');
                $(spinId).hide();
            });
        };

        this.fixModalCss = function() {
			if(typeof containerH === 'undefined') containerH = parseFloat(container.css('height'), 10);
			if(win.innerHeight() > containerH) {
                modalPosition = 'fixed';
				modalTop = (win.innerHeight() / 2) - (containerH / 2);
			} else {
                modalPosition = 'absolute';
				modalTop = win.scrollTop() + 100;
			}
		};

        this.modalX = function() {
			container.animate({opacity: 0, top: modalTop - 50}, 200, function() {
				blockBg.unbind('click', _this.modalX);
                win.unbind('resize', _this.resize);
				container.remove();
				blockBg.remove();
			});
		};

		this.resize = function() {
			clearTimeout(resizeTimer);
			if(typeof container === 'object') {
				resizeTimer = setTimeout(function() {
					_this.fixModalCss();
					container.css({position: modalPosition, top: modalTop});
				}, 100);
			}
		};

        this.initialize();
    };
    doc.ready(function() {
        new SnsModal();
    });

}(jQuery));