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

	<div class="interior_slider_wrap">
		<div class="interior_slider">
			<div class="slider-container">
				<ul class="slider-wrapper">
<?
	$sql = $main_sql.$view_order;
	$out_sql = mysql_query($sql);
	$file = array();
	while($list = mysql_fetch_assoc($out_sql)) {
		$option = view3_option(array($list['view3_file'],$list['view3_file_old'],$board),$list['view3_write_day'],$list['view3_notice'],$list['view3_main'],array($list["view3_code"],$list['view3_name']),array($list['view3_open'],$list['view3_close']));
		$file[] = $option['user_list'];
?>
					<li class="slider-items"><?=$option['user_list']?></li>
<?
	}
?>
				</ul>
			</div>
		</div>
		<div class="interior_paging_wrap">
			<ul class="interior_paging">
<?
	for($i=0; $i<count($file); $i++) {
?>
				<li<?if($i == 0){echo ' class="on"';}?> data-idx="<?=$i?>">
            		<a href="#none">
                		<?=$file[$i]?>
						<span class="shadow"></span>
                		<span class="border"></span>
            		</a>
        		</li>
<?
	}
?>
			</ul>
		</div>
        <button type="button" class="slider-btns slider-prev">이전</button>
        <button type="button" class="slider-btns slider-next">다음</button>
	</div>

<script type="text/javascript">
(function($) {
	doc.ready(function() {
		var mainItems = $('.interior_slider .slider-items'),
			thumbnail = $('.interior_paging li');
		thumbnail.last().prependTo($('.interior_paging'));
		var prevIndex = 0, index = 0, length = thumbnail.length;
		var slider = new CommonSlider($('.interior_paging_wrap'), {
			itemsPerView: 3,
			axis: 'y',
			prevBtn: $('.interior_slider_wrap > .slider-prev'),
			nextBtn: $('.interior_slider_wrap > .slider-next'),
			before: function(i, prevI, method) {
				prevIndex = index;
				if(method === 'toNext') index = index + 1 < length ? index + 1 : 0;
				else index = index - 1 > -1 ? index - 1 : length - 1;
				thumbnail.filter('[data-idx="'+ prevIndex +'"]').removeClass('on');
				thumbnail.filter('[data-idx="'+ index +'"]').addClass('on');
				var prevItem = mainItems.eq(prevIndex),
					item = mainItems.eq(index);
				var value = method === 'toNext' ? 1 : -1;
				TweenLite.fromTo(prevItem, 0.6, {top: 0}, {top: -100 * value + '%'});
				TweenLite.fromTo(item, 0.6, {top: 100 * value + '%'}, {top: 0});
			}
		});
		thumbnail.children('a').click(function(e) {
			if($(this).parent('li').hasClass('on') === false) {
				$(this).parent('li').index() - thumbnail.filter('.on').index() > 0 ? slider.toNext() : slider.toPrev();
			}
			e.preventDefault();
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