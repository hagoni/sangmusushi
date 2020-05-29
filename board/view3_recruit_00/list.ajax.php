<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
unset($_SESSION['data']);
$total_data = mysql_num_rows(mysql_query("SELECT view3_idx FROM `".TABLE_LEFT.$board."` WHERE view3_use = '1'"));
$list_page = 4;
$start = ($view3_page - 1) * $list_page;
page($total_data, $list_page, 5, $path_next, "img", $view3_page, $end_page_path);
?>
<?

$ongoing_select_query = "SELECT view3_idx FROM `".TABLE_LEFT.$board."` WHERE view3_use = '1' AND view3_check_01 != 1  AND (view3_open = '0000-00-00 00:00:00' || view3_open <= NOW())";
$ongoing_total_query = " AND (view3_close = '0000-00-00 00:00:00' OR view3_close >= NOW() - INTERVAL 1 DAY)";
$ongoing_cond1_query = " AND view3_special_02 LIKE '%신입%'";
$ongoing_cond2_query = " AND view3_special_02 LIKE '%경력%'";
$ongoing_total1 = mysql_num_rows(mysql_query($ongoing_select_query.$ongoing_total_query));
$ongoing_total2 = mysql_num_rows(mysql_query($ongoing_select_query.$ongoing_total_query.$ongoing_cond1_query));
$ongoing_total3 = mysql_num_rows(mysql_query($ongoing_select_query.$ongoing_total_query.$ongoing_cond2_query));
?>
<!-- layer4 start -->
<div class="layer4 chapters">
    <!-- <?=date('Y-m-d H:i:s').' // '.$ongoing_select_query.$ongoing_total_query;?> -->
    <div class="inner fs_def">
        <div class="lyr4_left">
            <p class="title t_center">인재채용</p>
            <p class="stitle t_center">진행중인 채용공고</p>
            <ul class="left_list fs_def t_center">
                <li>
                    <div class="text_wrap">
                        <p class="left_ttl">전체</p>
                        <p class="left_value"><?=$ongoing_total1?></p>
                    </div>
                </li>
                <li>
                    <div class="text_wrap">
                        <p class="left_ttl">신입</p>
                        <p class="left_value"><?=$ongoing_total2?></p>
                    </div>
                </li>
                <li>
                    <div class="text_wrap">
                        <p class="left_ttl">경력</p>
                        <p class="left_value"><?=$ongoing_total3?></p>
                    </div>
                </li>
            </ul>
        </div>
        <div class="lyr4_right">
            <ul class="right_list">
<?
$list_query = "SELECT * FROM `".TABLE_LEFT.$board."` WHERE view3_use = '1' AND (view3_open = '0000-00-00 00:00:00' OR view3_open <= NOW()) ORDER BY view3_write_day DESC";
$result = mysql_query($list_query);
while($list = mysql_fetch_assoc($result)) {
    $status_class = '';
    $path_view = URL_PATH.'?'.view3_link('||idx||select||search','view&select='.$view3_select.'&search='.$view3_search.'&idx='.$list['view3_idx']);
    if($list['view3_check_01'] == 1) {
		$status_text = '마감';
    } else if($list['view3_open'] == '0000-00-00 00:00:00' && $list['view3_close'] == '0000-00-00 00:00:00') {
		$status_text = '상시';
        $status_class = 'ing';
	} else if($list['view3_open'] != '0000-00-00 00:00:00' && $list['view3_close'] == '0000-00-00 00:00:00') {
		$status_text = '채용시 마감';
        $status_class = 'ing';
	} else if(time() >= strtotime($list['view3_close']) + 86400) {
		$status_text = '마감';
	} else {
        $status_class = 'ing';
        $write_day = new DateTime($list['view3_write_day']);
        $close_day = new DateTime($list['view3_close']);
        $today = new DateTime('NOW');
        $interval1 = date_diff($today, $close_day);
        $interval2 = date_diff($write_day, $today);
        if($interval1->days > 0) {
            $status_text = 'D-'.($interval1->days);
        } else if($interval1->days == 0) {
            $status_text = 'D-DAY';
        }
	}
?>
                <li>
                    <p class="state <?=$status_class;?> text t_center"><?=$status_text?></p>
                    <p class="list_ttl ellipsis t_left"><a href="<?=$path_view?>" class="bindRecruitModalOpen" data-type="iframe" target="_blank"><?=$list['view3_title_01']?></a></p>
                    <p class="list_three t_center"><?=$list['view3_special_01']?></p>
                    <p class="career t_center"><?=str_replace('||', '·', $list['view3_special_02'])?></p>
                </li>
<?
}
?>
            </ul>
            <!-- paging start -->
          	<div class="paging">
          		<?=$out_page?>
          	</div>
          	<!-- //paging end -->
        </div>
    </div>
</div>
<!-- //layer4 end -->