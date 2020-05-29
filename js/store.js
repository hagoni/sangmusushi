function boxloop(index) {
	$('.lyr1_imgs li').each(function(i) {
		var box = $(this);
		// var $elements = $('.section3 .box');
		setTimeout(function() {
			box.addClass('on');
			box.siblings().removeClass('on');
			// boxloop((index + 1) % $elements.length);
		}, 500 * i);
	});
}
var storeMotion = new YMotion(
	[
	    [
	        {el: $('.box_bg1'), set: {width: $('.box_wrap').width(), x:0}, to: {width: $('.box_wrap').width()/2, ease: Expo.easeInOut}, d: 2,t:0},
	        {el: $('.box_bg2'), set: {width: $('.box_wrap').width(), x:0}, to: {width: $('.box_wrap').width()/2, ease: Expo.easeInOut}, d: 2,t:0},
	        {el: $('.box_bg1'), set: {}, to: {width: $('.box_wrap').width(), ease: Expo.easeInOut}, d: 3,t:2.5},
	        {el: $('.box_bg2'), set: {}, to: {width: $('.box_wrap').width(), ease: Expo.easeInOut}, d: 3,t:2.5},
	        {method: 'call', fx: function() {
				$(window).on('resize',function(){
					$('.box_bg').width($('.box_wrap').width());
				});
	            $('.box_wrap .box').off();
				$('.box_wrap .box').mouseenter(function(){
	                var setWidth = 0;
	                if($(this).hasClass('box1')){
	                    setWidth = ($('.box_wrap').width()-$('.visual_ttl2').position().left-$('.visual_ttl2').width())*2+$('.visual_ttl2').width();//ttl2_right_padding * 2 + ttl2_Width
	                }else{
	                    setWidth = $('.box_wrap').width()-($('.visual_ttl1').position().left*2+$('.visual_ttl1').width());//wrap_width - (ttl1_left_padding * 2 + ttl1_width)
	                }
	                TweenMax.to('.box_wrap .box2', 1,{width:setWidth, ease: Expo.easeInOut});
	            });
				$('.box_wrap .box').mouseleave(function(){
	                TweenMax.to('.box_wrap .box2', 1,{width:'50%', ease: Expo.easeInOut});
	            });
	            if(lastOverBox)$(lastOverBox).trigger('mouseenter');
			}},
	    ],
	    [
	        {method: 'call', fx: function() {
				boxloop(0);
				setInterval(function() {
			        boxloop(0);
			    }, 6500);
			}}
	    ],
	]
);
var lastOverBox = false;
$('.box_wrap .box').mouseenter(function(){
    //마우스 over 이벤트 개선
    //마지막 으로 올렸던 박스 저장
    lastOverBox = this;
});
$(document).ready(function(){
    $('.box_bg').width($('.box_wrap').width());
});
$(window).load(function(){
	storeMotion.activate();
});


new ContentsModal('.bindContentsModalOpen2', {
	viewContainer: '#boardWrap',
	modalImgPath: CONST_REQUEST_ROOT + '/board/view3_sns_00/img'
});
