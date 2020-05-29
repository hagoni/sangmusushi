<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
if($view3_sca == 'all') {
?>
<link rel="stylesheet" href="<?=$root?>/plug_in/mcustomscrollbar/jquery.mCustomScrollbar.css" />
<script type="text/javascript">
var placeSearch = '<?=$view3_search?>';
var fieldList = '<?=$view3_select_list?>';
</script>
<script src="//maps.googleapis.com/maps/api/js?language=ko&amp;region=kr&amp;libraries=geometry<?if($settings_data['google_api_key']){echo '&key='.$settings_data['google_api_key'];}?>"></script>
<script src="<?=$root?>/plug_in/mcustomscrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?=BOARD?>/<?=$view3_skin?>/js/Geomap.js"></script>

<div class="place_find_container">
    <div id="placeFindWrap" class="place_find_wrap fs_def">
        <div class="cols select">
            <button type="button" id="local1Button">광역시/도</button>
            <div id="local1ListWrap" class="local_list_wrap">
                <ul id="local1" class="local_select">
                    <li><a href="#none">전체</a></li>
                    <li><a href="#none" data-value="서울">서울</a></li>
                    <li><a href="#none" data-value="부산">부산</a></li>
                    <li><a href="#none" data-value="대구">대구</a></li>
                    <li><a href="#none" data-value="인천">인천</a></li>
                    <li><a href="#none" data-value="광주">광주</a></li>
                    <li><a href="#none" data-value="대전">대전</a></li>
                    <li><a href="#none" data-value="울산">울산</a></li>
                    <li><a href="#none" data-value="세종">세종</a></li>
                    <li><a href="#none" data-value="경기">경기</a></li>
                    <li><a href="#none" data-value="강원">강원</a></li>
                    <li><a href="#none" data-value="충북">충북</a></li>
                    <li><a href="#none" data-value="충남">충남</a></li>
                    <li><a href="#none" data-value="전북">전북</a></li>
                    <li><a href="#none" data-value="전남">전남</a></li>
                    <li><a href="#none" data-value="경북">경북</a></li>
                    <li><a href="#none" data-value="경남">경남</a></li>
                    <li><a href="#none" data-value="제주">제주</a></li>
                </ul>
            </div>
        </div>
        <div class="cols select">
            <button type="button" id="local2Button">시/군/구</button>
            <div id="local2ListWrap" class="local_list_wrap">
                <ul id="local2" class="local_select"></ul>
            </div>
        </div>
        <div class="cols input">
            <form method="post" class="placefindbyname">
                <fieldset>
                    <legend class="indent">매장 검색</legend>
                    <label for="placeName">매장명 또는 주소 입력</label>
                    <input type="text" name="search" id="placeName" class="place_name" />
                    <input type="submit" id="btnFindSubmit" class="place_btn" />
                </fieldset>
            </form>
        </div>
    </div>
    <div id="placeLoadMap"></div>
</div>
<?
}
?>

<!-- board wrapper start -->
<div id="boardWrap" class="list">
<?
if($total_data > 0) {
?>
    <!-- store list start -->
    <div id="storeListWrap" class="store_list_wrap">
        <ul class="board_list">
<?
    $list_page = 12;
    $page_per_list = 10;
    $start = ($view3_page - 1) * $list_page;
    page($total_data, $list_page, $page_per_list, $path_next, "img", $view3_page, $end_page_path);
    $sql = $main_sql.$view_order." limit ".$start.", ".$list_page;
    $out_sql = mysql_query($sql);
    while($list = mysql_fetch_assoc($out_sql)) {
        $option = view3_option(array($list['view3_file'],$list['view3_file_old'],$board),$list['view3_write_day'],$list['view3_notice'],$list['view3_main'],array($list["view3_code"],$list['view3_name']),array($list['view3_open'],$list['view3_close']));
        $path_view = URL_PATH.'?'.view3_link('||idx||select||search','view&select='.$view3_select.'&search='.$view3_search.'&idx='.$list['view3_idx']);
        if($list['view3_addr_road']) {
    		$addr = $list['view3_addr_road']." ".$list['view3_addr_detail'];
    	} else {
    		$addr = $list['view3_addr_number']." ".$list['view3_addr_detail'];
    	}
        $list_type_img = '';
        if($list['view3_special_01'] == 2) {
            $list_type_img = ' <img src="'.$pc.'/design/other/new.png" /> ';
        } else if($list['view3_special_01'] == 3) {
            $list_type_img = ' <img src="'.$pc.'/design/other/open.png" /> ';
        }
?>
            <li>
                <div>
                    <div class="board_list_thumb">
                        <a href="<?=$path_view?>"><?=$option['user_list']?></a>
                    </div>
                    <div class="board_list_text">
                        <p class="board_list_title b_fs_xl b_ff_h b_c_h ellipsis"><?=$list['view3_title_01'].$list_type_img?></p>
                        <dl class="board_list_desc b_fs_m b_ff_m b_c_m">
                            <dt>주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소 :</dt>
                            <dd><?=$addr?></dd>
                        </dl>
<?
        if($list['view3_special_04']) {
?>
    					<dl class="board_list_desc b_fs_m b_ff_m b_c_m">
    						<dt>전화번호 :</dt>
    						<dd><?=$list['view3_special_04']?></dd>
    					</dl>
<?
        }
        if($list['view3_special_02']) {
?>
    					<dl class="board_list_desc b_fs_m b_ff_m b_c_m">
    						<dt>영업시간 :</dt>
    						<dd><?=$list['view3_special_02']?></dd>
    					</dl>
<?
        }
        if($list['view3_open'] != '0000-00-00 00:00:00' && $list['view3_open'] != '1970-01-01 00:00:00') {
?>
    					<dl class="board_list_desc b_fs_m b_ff_m b_c_m">
    						<dt>매장오픈 :</dt>
    						<dd><?=date( "Y-m-d", strtotime($list['view3_open']));?></dd>
    					</dl>
<?
        }
        if($list['view3_special_03']) {
?>
    					<dl class="board_list_desc b_fs_m b_ff_m b_c_m">
    						<dt>휴일 :</dt>
    						<dd>&nbsp;<?=$list['view3_special_03']?></dd>
    					</dl>
<?
        }
        if($list['view3_command_01']) {
?>
    					<dl class="board_list_desc b_fs_m b_ff_m b_c_m">
    						<dt>매장 소개 :</dt>
    						<dd class="b_lh_m"><?=view3_html($list['view3_command_01'],"1");?></dd>
    					</dl>
<?
        }
?>
                    </div>
                    <a href="<?=$path_view?>" class="board_list_right board_list_more">자세히 보기</a>
                </div>
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

    </div>
    <!-- //store list end -->

<?
} else {
	echo '<p class="nodata">게시물이 없습니다.</p>'.PHP_EOL;
}
?>

</div>
<!-- //board wrapper end -->