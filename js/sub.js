(function($) {
    $(document).ready(function() {
        (function() {
            function scrollHandler() {
                var scrollTop = win.scrollTop();
                if(fixed === false && scrollTop >= offset) {
                    $topElement.addClass('scroll');
                    fixed = true;
                } else if(fixed === true && scrollTop < offset) {
                    $topElement.removeClass('scroll');
                    fixed = false;
                }
            }

            var $topElement = $('.lnb_wrap'),
                offset = $('.lnb_wrap').offset().top,
                fixed = false;
            win.scroll(scrollHandler);
            scrollHandler();
        }());

        (function() {
			if($('.chapters').length === 0) return false;

            function setAnchorsOffset() {
                var limit = doc.innerHeight() - win.innerHeight();
                for(var i=0, j=0; i<length; i++) {
                    if($chapters.eq(i).length > 0) offsets[i] = $chapters.eq(i).offset().top - diff;
                    else offsets[i] = i > 0 ? offsets[i - 1] : 0;
                    if(offsets[i] > limit) {
                        offsets[i] = limit - length + j;
                        j++;
                    }
                    offsets[i] = Math.floor(offsets[i]);
                }
                offsets[length] = limit + 1;
            }

            function scrollHandler() {
                var scrollTop = win.scrollTop();
                if(scrollTop < offsets[0]) {
                    $anchors.parent('li').filter('.on').removeClass('on');
                    index = -1;
                    return false;
                }
                for(var i=0; i<length; i++) {
                    if((i !== index) && (scrollTop >= offsets[i] && scrollTop < offsets[i + 1])) {
                        $anchors.parent('li').filter('.on').removeClass('on');
						$anchors.parent('li').eq(i).addClass('on');
                        index = i;
                        break;
                    }
                }
            }

			function hashHandler() {
				if(location.hash) {
					var hash = parseInt(location.hash.split('#')[1], 10);
					if(isNaN(hash) === true) return false;
					if($anchors.eq(hash - 1).length > 0) {
                        if($('#sitemapWrap').is(':visible') === true) $('.bindSitemapSpread').trigger('click');
                        $anchors.eq(hash - 1).trigger('click');
                    }
				}
			}

            function scrollAnim(e) {
                TweenLite.to('html, body', 0.5, {scrollTop: offsets[$(this).parent('li').index()], ease: Expo.easeOut});
                e.preventDefault();
            }

			var $chapters = $('.chapters'),
                $anchors = $('.lnb a');

            var length = $anchors.length,
                offsets = [],
                index = -1,
                diff = $('.lnb_wrap').height(),
                resizeTimer = null;

            $anchors.click(scrollAnim);
            win.scroll(scrollHandler);
            win.resize(function() {
                clearTimeout(resizeTimer);
				resizeTimer = setTimeout(function() {
					setAnchorsOffset();
                    scrollHandler();
				}, 100);
            });
			win.on('hashchange load', function() {
				hashHandler();
			});
            win.on('load', function() {
                setAnchorsOffset();
                scrollHandler();
            });

            setAnchorsOffset();
            scrollHandler();
		}());
        (function() {
            function scrollHandler() {
                var scrollTop = win.scrollTop(),
                    fixOffset = doc.innerHeight() - win.innerHeight() - $diffElems.height();

                if(scrollTop > fixOffset) $headElems.css({bottom: scrollTop - fixOffset + $headElems.bottom});
                else $headElems.css({bottom: $headElems.bottom});

                if(show === false && scrollTop >= showOffset) {
                    $headElems.addClass('scroll');
                    show = true;
                } else if(show === true && scrollTop < showOffset) {
                    $headElems.removeClass('scroll');
                    show = false;
                }
            }


            var $headElems = $('.main_left'),
                $diffElems = $('.footer_wrap');

            $headElems.heigth = parseInt($headElems.css('height'), 10);
            $headElems.bottom = parseInt($headElems.css('bottom'), 10);

            var showOffset = doc.innerHeight() - win.innerHeight() >= 200 ? 200 : 0,
                show = false;

            win.scroll(scrollHandler).load(scrollHandler);
            scrollHandler();
        }());
    });
}(jQuery));
