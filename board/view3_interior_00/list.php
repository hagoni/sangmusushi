<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
?>

<!-- board wrapper start -->
<div id="boardWrap">

    <ul class="tabmenu fs_def">
		<li<?if($view3_tab == '' || $view3_tab == 'interior'){echo ' class="on"';}?>><a href="<?=URL_PATH.'?'.get("tab","tab=interior");?>">인테리어</a></li>
		<li<?if($view3_tab == 'exterior'){echo ' class="on"';}?>><a href="<?=URL_PATH.'?'.get("tab","tab=exterior");?>">익스테리어</a></li>
	</ul>

<?
if($total_data > 0) {
?>

	<div class="interior_slider">
		<div class="slider-container">
			<ul class="slider-wrapper">
<?
	$sql = $main_sql.$view_order;
	$out_sql = mysql_query($sql);
	$file = array();
	while($list = mysql_fetch_assoc($out_sql)) {
        $list_file_array = explode('||', $list['view3_file']);
        $list_file = $pc.'/upload/'.$board.$list_file_array[2];
		$file[] = $list_file;
?>
				<li class="swiper-slide" data-src="<?=$list_file?>">
                    <img src="<?=$list_file?>" alt="" class="w100">
                </li>
<?
	}
?>
			</ul>
		</div>
        <button type="button" class="swiper-buttons swiper-button-prev">이전</button>
        <button type="button" class="swiper-buttons swiper-button-next">다음</button>
	</div>
	<ul class="interior_paging">
	</ul>

<script>
$(document).ready(function() {
    var $swiperItems = $('.interior_slider .swiper-slide');
    new Swiper('.interior_slider > .slider-container', {
		pagination: {
            el: '.interior_paging',
            type: 'bullets',
            clickable: true,
            renderBullet: function(index, className) {
                var html = '';
                html += '<li class="swiper-pagination-bullet">';
                html += '   <a href="#none">';
                html += '       <img src="" alt="'+ $swiperItems.eq(index).data('src') +'" class="w100">';
                html += '       <span></span>';
                html += '   </a>';
                html += '</li>';
                return html;
            }
        },
        navigation: {
            prevEl: '.interior_slider .swiper-button-prev',
            nextEl: '.interior_slider .swiper-button-next'
        }
    });
});
</script>

<?
} else {
    echo '<p class="nodata">게시물이 없습니다.</p>'.PHP_EOL;
}
?>

</div>
<!-- //board wrapper end -->