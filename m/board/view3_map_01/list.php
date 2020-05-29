<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
if($view3_sca == 'all') {
?>
<link rel="stylesheet" href="<?=$pc?>/plug_in/mcustomscrollbar/jquery.mCustomScrollbar.css" />
<script>
var param_sca = '<?=$view3_sca?>';
var param_select = '<?=$view3_select?>';
var param_search = '<?=$view3_search?>';

<? #가끔 구글 지도 이미지가 업데이트 안되서 깨지는 경우가 있는데 handshake 해주면 나옴 ?>
<? #매장이 전국적으로 있으면 그냥 true//위치가 마음에 안들면 false로 바꾸고 스크립트 변경 ?>
window.geo_bound_mode = true;

if(param_search != ''){
	window.geo_bound_mode = true;
}
</script>
<script src="//maps.googleapis.com/maps/api/js?language=ko&amp;region=kr&amp;libraries=geometry<?if($settings_data['google_api_key']){echo '&key='.$settings_data['google_api_key'];}?>"></script>
<script src="<?=$pc?>/plug_in/mcustomscrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?=BOARD?>/<?=$view3_skin?>/js/Geomap.js?<?=$time?>"></script>

<div class="place_find_container">
    <div id="placeLoadMap"></div>
    <div id="placeFindWrap" class="place_find_wrap">
        <div class="cols select">
            <button type="button" id="local1Button">지역선택</button>
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
        <div class="cols input">
            <form method="post" class="placefindbyname">
                <fieldset>
                    <legend class="indent">매장 검색</legend>
                    <label for="placeName">매장명 또는 주소를 입력해주세요.</label>
                    <input type="text" name="search" id="placeName" class="place_name">
                    <button type="submit" id="btnFindSubmit" class="place_btn">검색</button>
                </fieldset>
            </form>
        </div>
    </div>
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
    $list_page = 10;
    $page_per_list = 5;
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
?>
            <li>
                <a href="<?=$path_view?>">
                    <p class="board_list_title b_fs_l b_ff_h b_c_h ellipsis"><?=$list['view3_title_01']?></p>
                    <p class="board_list_desc b_fs_m b_ff_m b_c_l"><?=$addr?></p>
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

    </div>
    <!-- //store list end -->

<?
} else {
	echo '<p class="nodata">게시물이 없습니다.</p>'.PHP_EOL;
}
?>


<script>
(function($) {
    doc.ready(function() {
        new HeightFix($('#placeLoadMap'), 4, 3);
    });
}(jQuery));
</script>

</div>
<!-- //board wrapper end -->