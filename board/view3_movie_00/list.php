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
	<ul class="grid_list">
<?
	$list_page = 8;
	$page_per_list = 10;
	$start = ($view3_page - 1) * $list_page;
	page($total_data, $list_page, $page_per_list, $path_next, "img", $view3_page, $end_page_path);
	$sql = $main_sql.$view_order." limit ".$start.", ".$list_page;
	$out_sql = mysql_query($sql);
	$i = 1;
	while($list = mysql_fetch_assoc($out_sql)) {
		$option = view3_option(array($list['view3_file'],$list['view3_file_old'],$board),$list['view3_write_day'],$list['view3_notice'],$list['view3_main'],array($list["view3_code"],$list['view3_name']),array($list['view3_open'],$list['view3_close']));
?>
			<li<?if($i % 4 == 0){echo ' class="last_col"';}?>>
				<a href="#none" class="bindMovieModalOpen" data-vendor="<?=strtolower($list['view3_video'])?>" data-id="<?=$list['view3_link']?>">
					<div class="grid_img_area"><?=$option['user_list']?></div>
					<p class="grid_txt_area b_fs_l b_lh_m b_c_m ellipsis"><?=$option['notice'].$list['view3_title_01']?></p>
				</a>
			</li>
<?
		$i++;
	}
?>

	</ul>

	<!-- paging start -->
	<div class="paging fs_def">
		<?=$out_page?>
	</div>
	<!-- //paging end -->

<script type="text/javascript">
(function($) {
    doc.ready(function() {
        new Movie();
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