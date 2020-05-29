<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
?>

<!-- board wrapper start -->
<div id="boardWrap">

	<div class="tabmenu_wrap">
	    <ul class="tabmenu fs_def">
			<li<?if($view3_tab == '' || $view3_tab == 'interior'){echo ' class="on"';}?>><a href="<?=BOARD;?>/index.php?<?=get("tab","tab=interior");?>">INTERIOR</a></li>
			<li<?if($view3_tab == 'exterior'){echo ' class="on"';}?>><a href="<?=BOARD;?>/index.php?<?=get("tab","tab=exterior");?>">EXTERIOR</a></li>
		</ul>
	</div>

<?
if($total_data > 0) {
?>

	<div class="interior_slider rel">
		<div class="swiper-container">
			<ul class="swiper-wrapper">
<?
	$sql = $main_sql.$view_order;
	$out_sql = mysql_query($sql);
	while($list = mysql_fetch_assoc($out_sql)) {
		$temp_file_arr = explode('||', $list['view3_file']);
		for($i=0; $i<count($temp_file_arr); $i++) {
		    if($temp_file_arr[$i] == '') continue;
		    $list_img = $temp_file_arr[$i];
			break;
		}
        $file_size = getimagesize(ROOT_INC.'/upload/'.$board.$list_img);
        $list_html = '';
        $list_html .= '<li class="swiper-slide rel">'.PHP_EOL;
        $list_html .= '  <img src="'.BOARD.'/'.$view3_skin.'/img.php?x='.$file_size[0].'&amp;y='.$file_size[1].'" alt="" class="w100">'.PHP_EOL;
        $list_html .= '  <img data-src="'.$pc_upload.'/'.$board.$list_img.'" alt="" class="w100 swiper-lazy">'.PHP_EOL;
        $list_html .= '</li>'.PHP_EOL;
        echo $list_html;
	}
?>
			</ul>
		</div>
		<button type="button" class="interior_btns swiper-prev">이전</button>
		<button type="button" class="interior_btns swiper-next">다음</button>
		<ul class="swiper-paging"></ul>
	</div>

<script>
(function($) {
    doc.ready(function() {
        var swiper = new Swiper($('.interior_slider > .swiper-container'), {
            autoplay: {
				delay: 5000,
				disableOnInteraction: false
			},
            setWrapperSize: true,
			pagination: {
				el: '.interior_slider .swiper-paging',
				type: 'bullets',
				clickable: true,
				renderBullet: function(index, className) {
					return '<li class="swiper-pagination-bullet"><a href="#none">'+ index +'</a></li>';
			    }
		    },
			navigation: {
				prevEl: '.interior_btns.swiper-prev',
				nextEl: '.interior_btns.swiper-next'
		    },
            preloadImages: false,
            lazy: true
        });
    });
}(jQuery));
</script>

<?
} else {
    echo '<p class="nodata">게시물이 없습니다.</p>'.PHP_EOL;
}
?>

</div>
<!-- //board wrapper end -->