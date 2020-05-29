<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
unset($_SESSION['data']);
$sql = $main_sql.$view_order.PHP_EOL;
$out_sql = @mysql_query($sql);
$list                             = @mysql_fetch_assoc($out_sql);
view3_hit($view3_table, $list['view3_idx']);
######################################################################################################################################################
// 이전글 다음글
######################################################################################################################################################
$sort = view3_prev_next($view3_table,$view3_idx);
$path_prev = view3_link("||idx","view&idx=".$temp_prev,"",$end_path);
$path_next = view3_link("||idx","view&idx=".$temp_next,"",$end_path);
######################################################################################################################################################
$_SESSION['idx'] = $view3_idx;
######################################################################################################################################################
if($list['view3_check_01'] == 1) {
    $status_text = '마감';
    $status = 'disable';
} else if($list['view3_open'] == '0000-00-00 00:00:00' && $list['view3_close'] == '0000-00-00 00:00:00') {
    $status_text = '상시';
} else if($list['view3_open'] != '0000-00-00 00:00:00' && $list['view3_close'] == '0000-00-00 00:00:00') {
    $status_text = '채용시 마감';
} else if(time() >= strtotime($list['view3_close']) + 86400) {
    $status_text = '마감';
    $status = 'disable';
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

$list_file_array = explode('||', $list['view3_file']);
?>

<link rel="stylesheet" href="/board/<?=$view3_skin;?>/css/iframe_mode.css?<?=$time;?>">

<div class="cont_top">
    <div class="inner">
        <h3 class="cont_tit">(주) 에스앤피프렌차이즈 <em>모집공고</em></h3>
        <p class="cont_txt">주식회사 에스앤피프렌차이즈에서 인재를 기다립니다</p>
    </div>
</div>

<!-- recruit_ad start -->
<div class="recruit_ad">
    <div class="inner">
        <div class="ad_info">
            <div class="w920">
                <div class="ad_info_top fs_def rel">
                    <div class="tit_area">
                        <p class="tit_text"><?=$list['view3_special_01']?></p>
                        <p class="lyr_tit"><?=$list['view3_title_01']?></p>
                    </div>
                    <?if($status != 'disable'){?>
                    <a href="<?=SELF.'?board='.$board.'&type=write&idx='.$list['view3_idx']?>" class="lyr_link">
                        <span class="d_day abs"><?=$status_text?></span>
                        지원하기
                    </a>
                    <?}?>
                </div>
                <div class="ad_info_s fs_def">
                    <?
                    $data = json_decode(html_entity_decode($list['view3_special_03']), true);
                    if(!empty($data)) {
                        foreach($data as $key => $val) {
                    ?>
                    <dl>
                        <dt><?=$key?></dt>
                        <dd><?=nl2br($val)?></dd>
                    </dl>
                    <?
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="ad_cont">
            <ul class="ad_cont_opt over_h">
                <!-- <li><a href="#none"><img src="<?=$root?>/img/page/recruit/03/share_ico.png" alt=""> 공유하기</a></li> -->
                <li>조회수 <span><?=$list['view3_hit']?></span></li>
            </ul>
            <div class="image w920">
                <?if($list_file_array[0]){?>
                <img src="<?=$pc.'/upload/'.$board.$list_file_array[0]?>" alt="" class="pc_image w100">
                <?}?>
                <?if($list_file_array[1]){?>
                <img src="<?=$pc.'/upload/'.$board.$list_file_array[1]?>" alt="" class="m_image w100">
                <?}?>
            </div>
            <div class="ad_conditions">
                <?
                $data = json_decode(html_entity_decode($list['view3_special_04']), true);
                $head = array_shift($data);
                if(!empty($head)) {
                ?>
                <div class="layer">
                    <p class="lyr_tit">01 모집부문</p>
                    <div class="table_wrap">
                        <table class="table">
                            <caption class="indent">모집부문 표</caption>
                            <colgroup>
                                <col class="col1">
                                <col class="col2">
                                <col class="col3">
                                <col class="col4">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th scope="col">모집<br class="mblock">부문</th>
                                    <th scope="col">담당업무</th>
                                    <th scope="col">자격요건</th>
                                    <th scope="col">인원</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="t_center"><?=nl2br($head['모집부문'])?></td>
                                    <td><?=nl2br($head['담당업무'])?></td>
                                    <td><?=nl2br($head['자격요건'])?></td>
                                    <td class="t_center"><?=nl2br($head['인원'])?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?
                }
                if(!empty($data)) {
                    $i = 2;
                    foreach($data as $key => $val) {
                ?>
                <div class="layer">
                    <p class="lyr_tit"><?=str_pad($i, 2, '0', STR_PAD_LEFT)?> <?=$key?></p>
                    <div class="lyr_cont">
                        <p><?=nl2br($val)?></p>
                    </div>
                </div>
                <?
                        $i++;
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- //recruit_ad end -->