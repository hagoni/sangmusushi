(function($) {

    'use strict';

    window.ContentsModal = function(anchor, options) {

        var _this = this;

        var opt = {contentsContainer: '#boardWrap', modalImgPath: CONST_ROOT + '/img/modal', skin: 'none'};

        for(var prop in options) {
			opt[prop] = options[prop];
		}

        var body = $('body'),
            containerId = '#contentsModalContainer',
            containerH,
            container,
            wrapperId = '#contentsModalWrap',
            contentId = '#contentsContent',
			prevBtnId = '#contentsModalPrev',
			nextBtnId = '#contentsModalNext',
            xBtnId = '#contentsModalX',
            spinId = '#contentsSpinner',
            modalHtml = '',
            modalPosition,
            modalTop,
            blockBg,
            resizeTimer = null,
            changing = false,
			cssLoad = false;

        this.initialize = function() {
            this.setModalHtml();
            this.setHandler();
        };

        this.setModalHtml = function() {
            modalHtml += '<div id="contentsModalContainer" style="display:none">\n';
            modalHtml += '  <div id="contentsModalWrap">\n';
            modalHtml += '      <div id="contentsContent">\n';
            modalHtml += '      </div>\n';
            modalHtml += '      <div id="contentsSpinner"><img src="'+ opt.modalImgPath +'/spinner01.gif" alt="" /></div>\n';
            modalHtml += '  </div>\n';
            modalHtml += '  <button type="button" id="contentsModalPrev" class="contents_modal_btns"><img src="'+ opt.modalImgPath +'/modal_prev.png" alt="이전"></button>\n';
            modalHtml += '  <button type="button" id="contentsModalNext" class="contents_modal_btns"><img src="'+ opt.modalImgPath +'/modal_next.png" alt="다음"></button>\n';
            modalHtml += '  <button type="button" id="contentsModalX"><img src="'+ opt.modalImgPath +'/modal_x.png" alt="닫기"></button>\n';
            modalHtml += '</div>';
        };

        this.setHandler = function() {
            body.on('click', anchor, this.modalOpen);
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
					$(xBtnId).click(_this.modalX);
                    blockBg.click(_this.modalX);
                    win.resize(_this.resize);
					if(opt.skin !== 'none' && cssLoad === false) _this.getCssSkins();
					_this.setContents(self.attr('href'));
					_this.pagination(self);
                    changing = false;
                });
                changing = true;
            }
            e.preventDefault();
        };

		this.getCssSkins = function() {
			var stylesheets = 'link[rel="stylesheet"]';
			var skin = typeof opt.skin === 'object' ? opt.skin : [opt.skin];
			var skip = [];
			for(var i=0; i<skin.length; i++) {
				skip[i] = false;
				for(var j=0; j<$(stylesheets).length; j++) {
					if($(stylesheets).eq(j).attr('href').split('?')[0] === skin[i]) {
						skip[i] = true;
						break;
					}
				}
				if(skip[i] === false) $('head').append('<link rel="stylesheet" href="'+ skin[i] +'" />');
			}
			cssLoad = true;
		};

		this.setContents = function(href) {
			$(contentId).empty();
			$(spinId).show(0);
			$.get(href, function(response) {
				$(contentId).html(typeof $(response).find(opt.contentsContainer).html() === 'string' ? $(response).find(opt.contentsContainer).html() : $(response).filter(opt.contentsContainer).html());
				$(wrapperId).css('overflow-y', 'scroll');
				$(spinId).hide(0);
				changing = false;
			});
		};

        this.pagination = function(el) {
            function btnToggle() {
                if(index < length - 1) $(nextBtnId).show(0);
                else $(nextBtnId).hide(0);
                if(index > 0) $(prevBtnId).show(0);
                else $(prevBtnId).hide(0);
            }

            var prevIndex = -1,
                index = el.closest('li').index();

            var contentsList = el.closest('li').parent().children(),
                length = contentsList.length;

            if(length > 1) {
                $(nextBtnId).click(function() {
                    if(changing === false) {
                        changing = true;
                        prevIndex = index;
                        index++;
                        index === length ? index = length - 1 : index;
                        _this.setContents(contentsList.eq(index).find(anchor).attr('href'));
                        btnToggle();
                    }
                });
                $(prevBtnId).click(function() {
                    if(changing === false) {
                        changing = true;
                        prevIndex = index;
                        index--;
                        index < 0 ? index = 0 : index;
                        _this.setContents(contentsList.eq(index).find(anchor).attr('href'));
                        btnToggle();
                    }
                });
                btnToggle();
            }
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
				$(prevBtnId).unbind('click');
				$(nextBtnId).unbind('click');
				$(xBtnId).unbind('click', _this.modalX);
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

}(jQuery));
