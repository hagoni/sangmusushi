<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
unset($_SESSION['data']);
$total_data = mysql_num_rows(mysql_query("SELECT view3_idx FROM `".TABLE_LEFT.$board."` WHERE view3_use = '1'"));
$list_page = 10;
$start = ($view3_page - 1) * $list_page;
page($total_data, $list_page, 5, $path_next, "img", $view3_page, $end_page_path);
?>

<div class="cont_top">
    <div class="inner">
        <h3 class="cont_tit">(주) 에스앤피프렌차이즈 <em>모집공고</em></h3>
        <p class="cont_txt">주식회사 에스앤피프렌차이즈에서 인재를 기다립니다</p>
    </div>
</div>

<!-- recruit_ad_list start -->
<div class="recruit_ad_list">
    <div class="inner">
<?
$ongoing_select_query = "SELECT view3_idx FROM `".TABLE_LEFT.$board."` WHERE view3_use = '1' AND (view3_open = '0000-00-00 00:00:00' || view3_open <= NOW())";
$ongoing_total_query = " AND (view3_close = '0000-00-00 00:00:00' OR view3_close >= NOW() - INTERVAL 1 DAY)";
$ongoing_cond1_query = " AND view3_special_02 LIKE '%신입%'";
$ongoing_cond2_query = " AND view3_special_02 LIKE '%경력%'";
$ongoing_total1 = mysql_num_rows(mysql_query($ongoing_select_query.$ongoing_total_query));
$ongoing_total2 = mysql_num_rows(mysql_query($ongoing_select_query.$ongoing_total_query.$ongoing_cond1_query));
$ongoing_total3 = mysql_num_rows(mysql_query($ongoing_select_query.$ongoing_total_query.$ongoing_cond2_query));
?>
        <div class="ad_state fs_def t_center">
            <p class="lyr_tit">진행중인 채용공고</p>
            <ul>
                <li>전체<span><?=$ongoing_total1?></span></li>
                <li>신입<span><?=$ongoing_total2?></span></li>
                <li>경력<span><?=$ongoing_total3?></span></li>
            </ul>
        </div>
        <div class="ad_listing over_h">
            <ul>
<?
$list_query = "SELECT * FROM `".TABLE_LEFT.$board."` WHERE view3_use = '1' AND (view3_open = '0000-00-00 00:00:00' OR view3_open <= NOW()) ORDER BY view3_write_day DESC";
$result = mysql_query($list_query);
while($list = mysql_fetch_assoc($result)) {
    $path_view = URL_PATH.'?'.view3_link('||idx||select||search','view&select='.$view3_select.'&search='.$view3_search.'&idx='.$list['view3_idx']);
    if($list['view3_check_01'] == 1) {
		$status_text = '마감';
    } else if($list['view3_open'] == '0000-00-00 00:00:00' && $list['view3_close'] == '0000-00-00 00:00:00') {
		$status_text = '상시';
	} else if($list['view3_open'] != '0000-00-00 00:00:00' && $list['view3_close'] == '0000-00-00 00:00:00') {
		$status_text = '채용시 마감';
	} else if(time() >= strtotime($list['view3_close']) + 86400) {
		$status_text = '마감';
	} else {
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
                    <a href="<?=$path_view?>">
                        <p class="ad_comp">
                            <span class="ellipsis"><?=$list['view3_special_01']?></span><span class="type"><?=str_replace('||', '·', $list['view3_special_02'])?></span>
                        </p>
                        <p class="ad_title"><?=$list['view3_title_01']?><?if($interval2->days < 3){?><span class="new"><img src="<?=$skin_path?>/img/new_lbl.jpg" alt="NEW"></span><?}?></p>
                        <p class="d_day"><?=$status_text?></p>
                    </a>
                </li>
<?
}
?>
            </ul>
        </div>
        <!-- paging start -->
      	<div class="paging">
      		<?=$out_page?>
      	</div>
      	<!-- //paging end -->
    </div>
</div>
<!-- //recruit_ad_list end -->