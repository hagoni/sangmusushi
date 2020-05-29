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
	<div id="menuInfoContainer" class="menu_info"<?if(isset($_REQUEST['idx']) == false){echo ' style="display:none"';}?>>
<?
	if($_REQUEST['idx']) {
		$view3_idx = $_REQUEST['idx'];
		$top_sql = $main_sql." and view3_idx='".$view3_idx."'".$view_order;
		$out_top_sql = mysql_query($top_sql);
		$top_list = mysql_fetch_assoc($out_top_sql);
		view3_prev_next($view3_table,$view3_idx);
		$top_option = view3_option(array($top_list['view3_file'],$top_list['view3_file_old'],$board),$top_list['view3_write_day'],$top_list['view3_notice'],$top_list['view3_main'],array($top_list["view3_code"],$top_list['view3_name']),array($top_list['view3_open'],$top_list['view3_close']));
		$next_command_01 = view3_html($top_list['view3_command_01']);
?>

			<div class="slider-container">
				<ul class="slider-wrapper">
					<li class="slider-items">
						<div class="menu_img_area"><?=$top_option['user_view']?></div>
						<div class="menu_txt_area">
							<p class="menu_title b_lh_m b_c_h"><?=$top_list['view3_title_01']?></p>
							<div class="menu_txt b_fs_l b_lh_l b_c_l"><?=$next_command_01?></div>
						</div>
					</li>
				</ul>
			</div>
			<button type="button" id="menuInfoPrev" class="slider-btns slider-prev" data-idx="<?=$temp_prev?>">이전</button>
			<button type="button" id="menuInfoNext" class="slider-btns slider-next" data-idx="<?=$temp_next?>">다음</button>
			<button type="button" id="menuInfoX" class="menu_close">닫기</button>
<?
	}
?>
	</div>
	<ul class="grid_list">
<?
	$list_page = 12;
	$page_per_list = 10;
	$start = ($view3_page - 1) * $list_page;
	page($total_data, $list_page, $page_per_list, $path_next, "img", $view3_page, $end_page_path);
	$sql = $main_sql.$view_order." limit ".$start.", ".$list_page;
	$out_sql = mysql_query($sql);
	$i = 1;
	while($list = mysql_fetch_assoc($out_sql)) {
		$option = view3_option(array($list['view3_file'],$list['view3_file_old'],$board),$list['view3_write_day'],$list['view3_notice'],$list['view3_main'],array($list["view3_code"],$list['view3_name']),array($list['view3_open'],$list['view3_close']));
?>
		<li<?if($i % 4 == 0){echo ' class="last_col"';}?> data-idx="<?=$list['view3_idx']?>">
			<a href="#none">
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
				<p class="grid_txt_area b_fs_l b_c_m ellipsis"><?=$list['view3_title_01']?></p>
				<div class="grid_hover_wrap">
					<span class="grid_hover_ico"></span>
				</div>
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

<script type="text/javascript" src="<?=BOARD.'/'.$view3_skin?>/js/ResponsiveMenu.js"></script>

<?
} else {
	echo '<p class="nodata">게시물이 없습니다.</p>'.PHP_EOL;
}
?>

</div>
<!-- //board wrapper end -->