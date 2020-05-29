<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
?>

<!-- board wrapper start -->
<div id="boardWrap">

    <ul class="tabmenu fs_def">
		<li<?if($view3_tab == '' || $view3_tab == '1'){echo ' class="on"';}?>><a href="<?=URL_PATH.'?'.get("page||type||tab||idx","tab=1");?>">진행 중 이벤트</a></li>
		<li<?if($view3_tab == '2'){echo ' class="on"';}?>><a href="<?=URL_PATH.'?'.get("page||type||tab||idx","tab=2");?>">완료된 이벤트</a></li>
		<li<?if($view3_tab == '3'){echo ' class="on"';}?>><a href="<?=URL_PATH.'?'.get("page||type||tab||idx","tab=3");?>">전체 이벤트</a></li>
	</ul>

<?
if($total_data > 0) {
?>

    <!-- board list start -->
    <ul class="board_list">
<?
    $list_page = 10;
    $page_per_list = 10;
    $start = ($view3_page - 1) * $list_page;
    page($total_data, $list_page, $page_per_list, $path_next, "img", $view3_page, $end_page_path);
    $sql = $main_sql.$view_order." limit ".$start.", ".$list_page;
    $out_sql = mysql_query($sql);
    while($list = mysql_fetch_assoc($out_sql)) {
        $option = view3_option(array($list['view3_file'],$list['view3_file_old'],$board),$list['view3_write_day'],$list['view3_notice'],$list['view3_main'],array($list["view3_code"],$list['view3_name']),array($list['view3_open'],$list['view3_close']));
        $path_view = URL_PATH.'?'.view3_link('||idx||select||search','view&select='.$view3_select.'&search='.$view3_search.'&idx='.$list['view3_idx']);
        $write_day = date('Y-m-d', strtotime($list['view3_write_day']));
?>
        <li>
            <a href="<?=$path_view?>">
                <div class="board_list_thumb"><?=$option['user_list']?></div>
                <div class="board_list_text">
                    <p class="board_list_title b_fs_xl b_ff_h b_lh_m b_c_h"><?=$option['notice'].$list['view3_title_01']?></p>
                    <p class="board_list_desc b_fs_m b_ff_m b_lh_l b_c_m">
<?
        echo $option['user_event_icon'];
        echo $option['event'];
?>
                    </p>
                </div>
                <p class="board_list_right board_list_hit b_fs_s b_ff_l b_c_l">HIT : <?=$list['view3_hit']?></p>
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
    switch($view3_tab){
        case '2':$no_data_text = '완료된 이벤트가 없습니다.';break;
        case '3':$no_data_text = '등록된 이벤트가 없습니다.';break;
        default:$no_data_text = '진행 중인 이벤트가 없습니다.';break;
    }
	echo '<p class="nodata">'.$no_data_text.'</p>'.PHP_EOL;
}
?>

</div>
<!-- //board wrapper end -->