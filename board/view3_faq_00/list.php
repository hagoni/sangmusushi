<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
?>

<!-- board wrapper start -->
<div id="boardWrap">
<?
if($total_data > 0) {
?>

    <!-- board list start -->
    <ul class="board_list">
<?
    $list_page = 10;
    $page_per_list = 10;
    $start = ($view3_page - 1) * $list_page;
    page($total_data, $list_page, $page_per_list, $path_next, "img", $view3_page, $end_page_path);
    $sql = $main_sql.$view_order." limit ".$start.", ".$list_page;
    $out_sql = mysql_query($sql);
	$i = 0;
    while($list = mysql_fetch_assoc($out_sql)) {
        $next_command_01 = view3_html($list['view3_command_01']);
?>
        <li class="faq_list<?if($i == 0){echo ' on';}?>">
			<dl>
				<dt><a href="#none" class="ellipsis"><?=$list['view3_title_01']?></a></dt>
				<dd<?if($i == 0){echo ' style="display:block"';}?>>
					<?=$next_command_01?>
				</dd>
			</dl>
        </li>
<?
		$i++;
    }
?>
    </ul>
    <!-- //board list end -->

    <!-- paging start -->
	<div class="paging fs_def">
		<?=$out_page?>
	</div>
	<!-- //paging end -->

<script>
$(document).ready(function() {
	$('.faq_list a').on('click', function(e) {
		var _this = $(this).closest('li');
		var _prev = $('.faq_list.on');
		if(_this.index() !== _prev.index()) {
			_prev.removeClass('on').find('dd').stop().slideUp(100);
			_this.addClass('on').find('dd').stop().slideDown(200);
		}
		e.preventDefault();
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