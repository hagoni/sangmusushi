<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
?>
<!-- layer1 start -->
<div class="layer1 inner">
    <img src="<?=BOARD;?>/<?=$view3_skin;?>/img/contrib_bnr.png" class="w100" />
</div>
<!-- board wrapper start -->

<div  data-motion-offset="2">
<?
if($total_data > 0) {
?>

    <!-- board list start -->
    <ul class="contrib_list fs_def inner" id="contrib_list">
<?
    $list_page = 6;
    $page_per_list = 10;
    $start = ($view3_page - 1) * $list_page;
    page($total_data, $list_page, $page_per_list, $path_next, "img", $view3_page, $end_page_path);
    $sql = $main_sql.$view_order." limit ".$start.", ".$list_page;
    $out_sql = mysql_query($sql);
    $img_exts = ['jpg','png','gif','jpeg'];
    while($list = mysql_fetch_assoc($out_sql)) {
        $option = view3_option(array($list['view3_file'],$list['view3_file_old'],$board),$list['view3_write_day'],$list['view3_notice'],$list['view3_main'],array($list["view3_code"],$list['view3_name']),array($list['view3_open'],$list['view3_close']));
        $path_view = URL_PATH.'?'.view3_link('||idx||select||search','view&select='.$view3_select.'&search='.$view3_search.'&idx='.$list['view3_idx']);
        $next_command_01 = cut($list['view3_command_01'], 126);
        $write_day = date('Y-m-d', strtotime($list['view3_write_day']));
        $fileList = explode('||', $list['view3_file']);
        $fileList = array_filter($fileList);
        $thumb = '';//default image
        if(current($fileList)!=''){
            $ext = explode('.', current($fileList));
            $ext = strtolower(end($ext));
            if($ext!='' && in_array($ext, $img_exts)){
                $currentFile = current($fileList);
                $thumb = $pc.'/upload/'.$board.$currentFile;
            }
        }

?>
        <li>
            <a href="<?=$path_view?>" class="bindContentsModalOpen2" data-notice-idx="<?=$list['view3_idx']?>">
            <div class="img_wrap rel bg" style="background-image:url('<?=$thumb;?>');"></div>
                <div class="text_area rel">
                    <p class="contrib_title ellipsis"><?=$list['view3_title_01']?></p>
                    <!-- <p class="contrib_desc ellipsis text"><?=$next_command_01?></p> -->
                </div>
            </a>
        </li>
<?
    }
?>
    </ul>
    <!-- //board list end -->

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
<script>
$(document).ready(function(){
    $('.lnb_wrap .swiper-slide-active').addClass('on');
});
</script>