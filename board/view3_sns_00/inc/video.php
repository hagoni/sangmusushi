<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
if($total_data > 0) {
	$list_page = 8;
	$page_per_list = 10;
	$start = ($view3_page - 1) * $list_page;
	if($_REQUEST['idx']) {
		$view3_idx = $_REQUEST['idx'];
		$top_sql = $main_sql." and view3_idx='".$view3_idx."'".$view_order;
	} else {
		$top_sql = $main_sql.$view_order." limit ".$start.", 1";
	}
	$top_out_sql = mysql_query($top_sql);
	$top_list = mysql_fetch_assoc($top_out_sql);
	$view3_table = TABLE_LEFT.$board;
	if(!$view3_idx) {
		$view3_idx = $top_list['view3_idx'];
	}
	view3_prev_next($view3_table,$view3_idx);
?>

		<div id="videoViewContainer" class="video_view_container b_bc_m">
			<div class="videoIncludeWrap">
				<div class="videoIncludeWrapInner">
<?
	switch(strtolower($top_list['view3_video'])) {
		case 'youtube':
			echo '<iframe src="//youtube.com/embed/'.$top_list['view3_link'].'?vq=hd1080&rel=0&autoplay=1&loop=0&mute=0" allow="autoplay" width="100%" height="100%" frameborder="0" playsinline webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
			break;
		case 'kakaotv':
			echo '<iframe width="100%" height="100%" src="https://play-tv.kakao.com/embed/player/cliplink/'.$top_list['view3_link'].'?service=daum_searchview" allowfullscreen frameborder="0" scrolling="no" allow="autoplay"></iframe>';
			break;
		default:
			echo '<iframe src="//player.vimeo.com/video/'.$top_list['view3_link'].'?quality=1080p&autopause=0&playsinline=1&autoplay=1&loop=0&background=0" allow="autoplay" width="100%" height="100%" frameborder="0" playsinline webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
			break;
	}
?>
				</div>
			</div>
			<p class="video_title b_fs_xxl b_ff_h b_c_h ellipsis"><?=$top_list['view3_title_01']?></p>
<?
	if($temp_prev) {
?>
			<a href="#none" id="videoPrevBtn" class="video-btns video-prev" data-idx="<?=$temp_prev?>" data-page="<?=$view3_page - 1?>">이전</a>
<?
	}
	if($temp_next) {
?>
			<a href="#none" id="videoNextBtn" class="video-btns video-next" data-idx="<?=$temp_next?>" data-page="<?=$view3_page + 1?>">다음</a>
<?
	}
?>
		</div>

		<ul id="videoListContainer" class="grid_list">
<?
	page($total_data, $list_page, $page_per_list, $path_next, "img", $view3_page, $end_page_path);
	$sql = $main_sql.$view_order." limit ".$start.", ".$list_page;
	$out_sql = mysql_query($sql);
	$i = 1;
	while($list = mysql_fetch_assoc($out_sql)) {
		$option = view3_option(array($list['view3_file'],$list['view3_file_old'],$board),$list['view3_write_day'],$list['view3_notice'],$list['view3_main'],array($list["view3_code"],$list['view3_name']),array($list['view3_open'],$list['view3_close']));
		if($list['view3_idx'] == $view3_idx && $i % 4 == 0) {
			$class_attr = ' class="on last_col"';
		} else if($list['view3_idx'] == $view3_idx) {
			$class_attr = ' class="on"';
		} else if($i % 4 == 0) {
			$class_attr = ' class="last_col"';
		} else {
			$class_attr = '';
		}
?>
			<li<?=$class_attr?> data-idx="<?=$list['view3_idx']?>">
				<a href="#none" class="bindVideoPlay">
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

<script src="<?=BOARD.'/'.$view3_skin?>/js/VideoPlay.js"></script>

<?
} else {
	echo '<p class="nodata">게시물이 없습니다.</p>'.PHP_EOL;
}
?>