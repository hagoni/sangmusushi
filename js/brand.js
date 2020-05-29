(function($) {
    doc.ready(function() {
        new Swiper('.lyr1_slide .swiper-container', {
            speed: 300,
                autoplay: {
                delay: 3000,
            },
            effect: 'fade',
            fadeEffect: {
            	crossFade: true
            },
        });
        new Swiper('.lyr5_slide .swiper-container', {
            loop:true,
            speed: 300,
                autoplay: {
                delay: 3000,
            },
            navigation: {
                nextEl: '.lyr5_btns.lyr5_next',
                prevEl: '.lyr5_btns.lyr5_prev',
            },
        });

        new Swiper('.lyr7_slide .swiper-container',{
            loop:true,
            navigation: {
                nextEl: '.lyr7_btns.lyr7_next',
                prevEl: '.lyr7_btns.lyr7_prev',
            },
            pagination: {
                el: '.lyr7_paging',
                type: 'fraction',
            },
        });


        var tl0 = gsap.timeline({paused: true});
        tl0.to(".lyr6_def img", {duration: 1, scale: 2, transformOrigin: "34% 46.8%"})
            .to(".lyr6_imgs li:first-child", {duration: 1, opacity: 1}, "-=0.4")

        var tl1 = gsap.timeline({paused: true});
        tl1.to(".lyr6_def img", {duration: 1, scale: 3, transformOrigin: "80% 34.6%"})
            .to(".lyr6_imgs li:nth-child(2)", {duration: 1, opacity: 1}, "-=0.4")

        var tl2 = gsap.timeline({paused: true});
        tl2.to(".lyr6_def img", {duration: 1, scale: 3, transformOrigin: "62% 43.8%"})
            .to(".lyr6_imgs li:nth-child(3)", {duration: 1, opacity: 1}, "-=0.4")

        var tl3 = gsap.timeline({paused: true});
        tl3.to(".lyr6_def img", {duration: 1, scale: 3, transformOrigin: "50%"})
            .to(".lyr6_imgs li:last-child", {duration: 1, opacity: 1}, "-=0.4")

        $('.lyr6_paging li').eq(0).click(function(){
            $('.lyr6_imgs li').css('opacity', '0');
            $('.lyr6_paging li').removeClass('on');
            $(this).addClass('on');
            tl1.pause(0);
            tl2.pause(0);
            tl3.pause(0);
            tl0.restart();
        });
        $('.lyr6_paging li').eq(1).click(function(){
            $('.lyr6_imgs li').css('opacity', '0');
            $('.lyr6_paging li').removeClass('on');
            $(this).addClass('on');
            tl0.pause(0);
            tl2.pause(0);
            tl3.pause(0);
            tl1.restart();
        });
        $('.lyr6_paging li').eq(2).click(function(){
            $('.lyr6_imgs li').css('opacity', '0');
            $('.lyr6_paging li').removeClass('on');
            $(this).addClass('on');
            tl0.pause(0);
            tl1.pause(0);
            tl3.pause(0);
            tl2.restart();
        });
        $('.lyr6_paging li').eq(3).click(function(){
            $('.lyr6_imgs li').css('opacity', '0');
            $('.lyr6_paging li').removeClass('on');
            $(this).addClass('on');
            tl0.pause(0);
            tl1.pause(0);
            tl2.pause(0);
            tl3.restart();
        });

        new YMotion([
            [
                {el: '.el1_1', set: {opacity: 0, y: 100}, to: {opacity: 1, y: 0}, d: 0.5},
                {el: '.el1_2', set: {opacity: 0, y: 100}, to: {opacity: 1, y: 0}, d: 0.5},
    		],
            [
                {el: '.el2_1', set: {opacity: 0, y: 50}, to: {opacity: 1, y: 0}, d: 0.4},
    		],
            [
                {el: '.el3_1', set: {opacity: 0, y: 100}, to: {opacity: 1, y: 0}, d: 0.4},
                {el: '.el3_2', set: {opacity: 0, y: 20}, to: {opacity: 1, y: 0}, d: 0.4},
                {el: '.el3_3', set: {opacity: 0, y: 20}, to: {opacity: 1, y: 0}, d: 0.4, t: '-=0.2'},
                {el: '.el3_4', set: {opacity: 0, y: 20}, to: {opacity: 1, y: 0}, d: 0.4, t: '-=0.2'},
                {el: '.el3_5', set: {opacity: 0, y: 20}, to: {opacity: 1, y: 0}, d: 0.4, t: '-=0.2'},
                {el: '.el3_6', set: {opacity: 0, y: 20}, to: {opacity: 1, y: 0}, d: 0.4, t: '-=0.2'},
    		],
            [
                {el: '.el4_1', set: {opacity: 0, y: 100}, to: {opacity: 1, y: 0}, d: 0.6},
                {el: '.el4_2', set: {opacity: 0, x: -60}, to: {opacity: 1, x: 0}, d: 0.4},
                {el: '.el4_3', set: {opacity: 0, y: 100}, to: {opacity: 1, y: 0}, d: 0.6},
                {el: '.el4_4', set: {opacity: 0, x: 60}, to: {opacity: 1, x: 0}, d: 0.4},
                {el: '.el4_5', set: {opacity: 0, y: 100}, to: {opacity: 1, y: 0}, d: 0.6},
                {el: '.el4_6', set: {opacity: 0, x: -60}, to: {opacity: 1, x: 0}, d: 0.4},
    		],
            [
                {el: '.layer7', set: {opacity: 0, y: 200}, to: {opacity: 1, y: 0}, d: 0.6},
    		],
            [
                {el: '.layer8', set: {opacity: 0, y: 200}, to: {opacity: 1, y: 0}, d: 0.6},
    		],
    	]).activate();
    });
}(jQuery));