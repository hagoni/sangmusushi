(function() {
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

        var lyr6Slide = new Swiper('.lyr6_slide .swiper-container', {
			loop: true,
            navigation: {
                nextEl: '.lyr6_btns.lyr6_next',
                prevEl: '.lyr6_btns.lyr6_prev',
            },
        });

        var lyr7Slide = new Swiper('.lyr7_slide .swiper-container', {

        });
        var lyr7thumb = new Swiper('.lyr7_thumb .swiper-container', {
            slidesPerView: 'auto',
            centeredSlides: true,
            slideToClickedSlide: true,
        });
        lyr7Slide.controller.control = lyr7thumb;
		lyr7thumb.controller.control = lyr7Slide;

        var lyr8Slide = new Swiper('.lyr8_slide .swiper-container', {
			loop: true,
            navigation: {
                nextEl: '.lyr8_btns.lyr8_next',
                prevEl: '.lyr8_btns.lyr8_prev',
            },
            pagination: {
                el: '.lyr8_paging',
                type: 'fraction',
            },
        });
    });
}())
