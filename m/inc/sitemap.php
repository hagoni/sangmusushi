<!-- 사이트맵 start -->
<div id="sitemapWrap" class="sitemap_wrap" style="display:none">
	<div class="sitemap inner">
		<h1 class="stm_logo"><a href="<?=$root?>/"></a></h1>
		<ul class="stm_depth1_ul">
<?
$depth1_link_query = "SELECT * FROM `".TABLE_LEFT."group` WHERE view3_use_m = '1' AND view3_setup = '$html_idx' ORDER BY view3_order_m";
$depth1_result = @mysql_query($depth1_link_query);
while($depth1_list = @mysql_fetch_assoc($depth1_result)) {
    $depth2_link_query = "SELECT * FROM `".TABLE_LEFT."board` WHERE view3_use_m = '1' AND view3_setup = '$html_idx' AND view3_group_idx = '".$depth1_list['view3_idx']."' ORDER BY view3_order_m";
    $depth2_result = @mysql_query($depth2_link_query);
	$depth2_count = @mysql_num_rows($depth2_result);
	unset($depth1_link);
	while($depth2_list = mysql_fetch_assoc($depth2_result)) {
		switch($depth2_list['view3_style']) {
			case 'html':
				if(file_exists(ROOT_M_INC.'/html/'.$depth2_list['view3_link'])) {
					$depth1_link = $root.'/html/'.$depth2_list['view3_link'];
				}
				break;
			case 'board':
				$depth1_link = BOARD.'/index.php?board='.$depth2_list['view3_link'];
				break;
			case 'http':
				$depth1_link = $depth2_list['view3_link'].'" target="_blank';
				break;
			case 'url':
				$depth1_link = $depth2_list['view3_link'];
				break;
			default:
				if(file_exists(ROOT_M_INC.'/html/'.$depth2_list['view3_link'])) {
					$depth1_link = $root.'/html/'.$depth2_list['view3_link'];
				}
		}
		if($depth1_link) {
			if($depth2_list['view3_sca']) {
				if(strpos($depth1_link, '?') > -1) $depth1_link .= '&amp;sca='.$depth2_list['view3_sca'];
				else $depth1_link .= '?sca='.$depth2_list['view3_sca'];
			}
			break;
		}
	}
?>
			<li class="stm_depth1_li<?if($depth1_list['view3_order_css'] == $gnb_index){echo ' on';}?>">
				<a href="<?=$depth1_link?>" class="stm_depth1_a"><?=$depth1_list['view3_title_02']?></a>
			</li>
<?
}
?>
		</ul>
	</div>
	<a href="#none" class="bindSitemapFold stm_close">닫기</a>
</div>
<!-- //사이트맵 end -->
