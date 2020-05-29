<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
?>
<!-- layer1 start -->
<div class="layer1 over_h rel center chapters" data-motion-offset="1">
    <div class="lyr1_video bg">
        <div class="text_area v_mid t_center">
            <p class="lyr1_ttl1 el1_1">S&amp;P프랜차이즈는</p>
            <p class="lyr1_ttl2 el1_2">지역사회와 소통하며 발전과 번영을 공유하고 있습니다.</p>
            <p class="lyr1_text el1_3">정기적 외식산업 인재육성 장학금 전달과 각 매장 별 상권 청소봉사 등<br />따뜻함을 나눌수 있는 기업이 되기 위해 최선을 다하고 있습니다.</p>
        </div>
        <div class="lyr1_logo abs"><img src="<?=$root?>/img/page/fran/lyr1_logo.png" alt="상무"></div>
    </div>
</div>
<!-- board wrapper start -->

<div  data-motion-offset="2">
<?
if($total_data > 0) {
?>

    <!-- board list start -->
    <ul class="contrib_list fs_def center" id="contrib_list">
<?
    $list_page = 9;
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
                $thumb = $root.'/upload/'.$board.$currentFile;
            }
        }

?>
        <li>
            <a href="<?=$path_view?>" class="bindContentsModalOpen2" data-notice-idx="<?=$list['view3_idx']?>">
            <div class="img_wrap rel bg" style="background-image:url('<?=$thumb;?>');"></div>
                <div class="text_area rel">
                    <p class="contrib_title ellipsis"><?=$list['view3_title_01']?></p>
                    <p class="contrib_desc ellipsis text"><?=$next_command_01?></p>
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

<script src="<?=$root?>/js/YMotion.js?<?=$time?>"></script>
<script>
new YMotion([
    [
        {el: '.el1_1', set: {opacity: 0, y: 50}, to: {opacity: 1, y: 0}, d: 0.5},
        {el: '.el1_2', set: {opacity: 0, y: 50}, to: {opacity: 1, y: 0}, d: 0.5},
        {el: '.el1_3', set: {opacity: 0, y: 50}, to: {opacity: 1, y: 0}, d: 0.5},
    ],
    // [
    //     {el: '.contrib_list', set: {opacity: 0, y: 50}, to: {opacity: 1, y: 0}, d: 0.5},
    // ],
]).activate();
</script>
