(function() {
	$(document).ready(function() {
		var lyr1Slide = new Swiper('.lyr1_slide .swiper-container', {
			allowTouchMove: false,
			speed: 0,
			autoplay: {
			    delay: 500,
				stopOnLastSlide: true,
			},
			effect: 'fade',
			fadeEffect: {
				crossFade: true
			},
        });
		lyr1Slide.on('reachEnd', function () {
			setTimeout(function(){
				lyr1Slide.slideTo(0);
				lyr1Slide.autoplay.start();
			}, 3000);
		});

        (function (){

			var requestUrl = CONST_ROOT + '/board/view3_map_00/resource' + '/place_check.php';

			$('body .store_tab li').each(function(){
				var _this = $(this);
				var a_tag = $(this).find('a');
				var value = a_tag.data('value');

				var data = {board: 'map_01', sca : 'all', select : 'addr_road||addr_number', search: value};
				$.post(requestUrl,data,function(res){
					var len = $(res)[0].data.length;
					_this.find('span').html(len);
				});
			});

            $('body').on('click', '.tab_a', function () {
                $('.store_tab').slideToggle();
            });

            $('body').on('click', '.store_tab li', function () {
				var aTag = $(this).find('a');
                $('.store_tab').slideToggle();
                $('.store_tab li').removeClass('on');
                $(this).addClass('on');

				var text = $(this).text();
				$.post(aTag.href,{loc: aTag.data('value')},function(res){
					var data = $(res).find('#store_conts').html();
					$('#store_conts').html(data);
					$('.tab_a').text(text);
				});
            });

        }());

		$('body').on('click','.more_button',function(){
			var cnt = $(this).data('cnt') + 4;
			var loc = $(this).data('loc');
			$.post($(this).href, {limit:cnt, loc:loc}, function(res){
				var data = $(res).find('#store_conts').html();
				$('#store_conts').html(data);
			});
		});


    });
}())
