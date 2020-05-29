<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
if($total_data > 0) {
?>

		<p class="sns_title b_fs_m b_lh_m b_c_l t_center"><em>NAVER</em> <?=$board_name?> 검색결과입니다. :: 검색건수 : <?=$total_data;?>건</p>
		<ul id="snsListContainer" class="sns_list">
<?
	$list_page = 10;
	$page_per_list = 5;
	$start = ($view3_page - 1) * $list_page;
	page($total_data, $list_page, $page_per_list, $path_next, "img", $view3_page, $end_page_path);
	$sql = $main_sql.$view_order.' limit '.$start.','.$list_page;
	$out_sql = mysql_query($sql);
	while($list = mysql_fetch_assoc($out_sql)) {
		$temp_title = htmlspecialchars_decode(str_replace($list['view3_search'],'<em class="color b_ff_h">'.$list['view3_search'].'</em>',$list['view3_title']));
	    $temp_sub = htmlspecialchars_decode(str_replace($list['view3_search'],'<em class="color b_ff_h">'.$list['view3_search'].'</em>',$list['view3_description']));
        $write_day = date('Y-m-d', strtotime($list['view3_pubdate']));
?>
			<li>
				<div class="sns_type"><p class="b_fs_m b_ff_h b_c_h t_center"><?=$board_name?></p></div>
				<a href="<?=$list['view3_link']?>" target="_blank" class="sns_cont">
					<p class="board_list_title b_fs_m b_ff_h b_c_h ellipsis"><?=$temp_title?></p>
					<p class="board_list_desc b_fs_s b_ff_m b_lh_m b_c_l"><?=$temp_sub?></p>
<?
		if($list['view3_pubdate']) {
?>
					<p class="board_list_right board_list_date b_fs_m b_ff_l b_c_l"><?=$write_day?></p>
<?
		}
?>
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