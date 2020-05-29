<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
######################################################################################################################################################
$sql = $main_sql.$view_order;
$out_sql = mysql_query($sql);
$list = mysql_fetch_assoc($out_sql);
view3_hit($view3_table, $list['view3_idx']);
######################################################################################################################################################
// 이전글 다음글
######################################################################################################################################################
$sort = view3_prev_next($view3_table,$view3_idx);
$path_prev = view3_link("||idx","view&idx=".$temp_prev,"",$end_path);
$path_next = view3_link("||idx","view&idx=".$temp_next,"",$end_path);
######################################################################################################################################################
$_SESSION['idx'] = $view3_idx;
$option = view3_option(array($list['view3_file'],$list['view3_file_old'],$board),$list['view3_write_day'],$list['view3_notice'],$list['view3_main'],array($list["view3_code"],$list['view3_name']),array($list['view3_open'],$list['view3_close']));
$next_command_01 = preg_replace('/img(.+)src="/', 'img$1src="'.$pc, html_entity_decode($list['view3_command_01']));
?>

<!-- board wrapper start -->
<div id="boardWrap">

	<div class="board_view_head">
		<p class="board_view_title b_fs_l b_ff_h b_c_h ellipsis"><?=$option['notice']?><?=$list['view3_title_01']?></p>
	</div>
    <ul class="board_view_sns">
        <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?=urlencode('http://'.$_SERVER[SERVER_NAME].$_SERVER[REQUEST_URI]);?>" class="social-fb-share-btn"><img src="../img/board/sns_ico01.png" alt="페이스북 아이콘" class="w100"></a></li>
        <li><a href="http://blog.naver.com/openapi/share?url=<?=urlencode('http://'.$_SERVER[SERVER_NAME].$_SERVER[REQUEST_URI]);?>" class="social-bl-share-btn"><img src="../img/board/sns_ico02.png" alt="네이버 블로그 아이콘" class="w100"></a></li>
        <li><a href="https://story.kakao.com/share?url=<?=urlencode('http://'.$_SERVER[SERVER_NAME].$_SERVER[REQUEST_URI]);?>" class="social-ks-share-btn"><img src="../img/board/sns_ico03.png" alt="카카오스토리 아이콘" class="w100"></a></li>
    </ul>
    <div class="board_view_body">
		<div class="iframe_movie_wrap">
<?
if(strtolower($list['view3_video']) == 'vimeo') {
?>
			<iframe src="//player.vimeo.com/video/<?=$list['view3_link']?>?quality=1080p&autopause=0&playsinline=1&autoplay=1&loop=0&background=0" allow="autoplay" width="100%" height="100%" frameborder="0" playsinline webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
<?
} else {
?>
			<iframe src="//youtube.com/embed/<?=$list['view3_link']?>?vq=hd1080&rel=0&autoplay=1&loop=0&mute=0" allow="autoplay" width="100%" height="100%" frameborder="0" playsinline webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
<?
}
?>
		</div>
        <div class="board_view_text b_fs_m b_lh_l b_c_m"><?=$next_command_01?></div>
    </div>

<?
######################################################################################################################################################
include_once(BOARD_INC.'/setup_bottom.php');
######################################################################################################################################################
?>

</div>
<!-- //board wrapper end -->