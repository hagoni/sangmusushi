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
	$list_page = 10;
	$page_per_list = 5;
	$start = ($view3_page - 1) * $list_page;
	page($total_data, $list_page, $page_per_list, $path_next, "img", $view3_page, $end_page_path);
	$sql = $main_sql.$view_order." limit ".$start.", ".$list_page;
	$out_sql = mysql_query($sql);
	while($list = mysql_fetch_assoc($out_sql)) {
		$option = view3_option(array($list['view3_file'],$list['view3_file_old'],$board),$list['view3_write_day'],$list['view3_notice'],$list['view3_main'],array($list["view3_code"],$list['view3_name']),array($list['view3_open'],$list['view3_close']));
        $path_view = URL_PATH.'?'.view3_link('||idx||select||search','view&select='.$view3_select.'&search='.$view3_search.'&idx='.$list['view3_idx']);
?>
		<li>
			<a href="<?=$path_view?>">
				<div class="grid_img_area">
					<?=$option['user_list']?>
					<ul class="grid_ico">
<?
		$special_01_array = explode("||", $list['view3_special_01']);
		if(in_array("1", $special_01_array)) {
?>
							<li>
								<img src="<?=BOARD.'/'.$view3_skin.'/img/circle_box01.png'?>" alt="" class="w100" />
								<span>NEW</span>
							</li>
<?
		}
		if(in_array("2", $special_01_array)) {
?>
							<li>
								<img src="<?=BOARD.'/'.$view3_skin.'/img/circle_box02.png'?>" alt="" class="w100" />
								<span>BEST</span>
							</li>
<?
		}
?>
					</ul>
				</div>
				<p class="grid_txt_area b_fs_m b_c_l ellipsis"><?=$list['view3_title_01']?></p>
			</a>
		</li>
<?
	}
?>

	</ul>

	<!-- paging start -->
	<div class="paging fs_def">
		<?=$out_page?>
	</div>
	<!-- //paging end -->

<?
} else {
	echo '<p class="nodata">게시물이 없습니다.</p>'.PHP_EOL;
}
?>

</div>
<!-- //board wrapper end -->