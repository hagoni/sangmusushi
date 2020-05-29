<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
if($total_data > 0) {
?>

		<p class="sns_title b_fs_l b_lh_m b_c_l t_center">
			<img src="<?=BOARD.'/'.$view3_skin?>/img/text_naver_<?=$view3_sca?>.png" />&nbsp;검색결과입니다. :: 검색건수 : <?=$total_data;?>건
		</p>
		<ul id="snsListContainer" class="board_list">
<?
	$list_page = 10;
	$page_per_list = 10;
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
				<a href="<?=$list['view3_link']?>" target="_blank" class="bindSnsModalOpen" data-type="iframe">
					<p class="board_list_title b_fs_xl b_ff_h b_c_h ellipsis"><?=$temp_title?></p>
					<p class="board_list_desc b_fs_m b_ff_m b_lh_l b_c_m"><?=$temp_sub?></p>
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

<script type="text/javascript" src="<?=BOARD.'/'.$view3_skin?>/js/SnsModal.js"></script>
<script type="text/javascript">
(function($) {
	doc.ready(function() {
        new SnsModal();
	});
}(jQuery));
</script>

<?
} else {
	echo '<p class="nodata">게시물이 없습니다.</p>'.PHP_EOL;
}
?>