(function() {
	$(document).ready(function() {
        // 내비게이션 제어
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
			var lnbSwiper = new Swiper('.lnb_wrap.swiper-container', {
				initialSlide: $('.lnb li.on').index(),
				slidesPerView: 'auto',
				centeredSlides: true,
			});
			var gnbSetView = $('.gnb li.on').index();
			if(gnbSetView<=1)gnbSetView=2;
			if(gnbSetView+1>=$('.gnb li').length)gnbSetView=$('.gnb li').length-2;			
			var gnbSwiper = new Swiper('.gnb_wrap.swiper-container', {
				initialSlide: gnbSetView,
				slidesPerView: 'auto',
				centeredSlides: true,
			});
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
                        lnbSwiper.slideTo(i);
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
                diff = $('.lnb_wrap').innerHeight(),
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
    });
}())
