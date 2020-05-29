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
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?language=ko&amp;region=kr&amp;libraries=geometry"></script>
<script type="text/javascript" src="<?=$root?>/plug_in/mcustomscrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="<?=BOARD?>/<?=$view3_skin?>/js/Geomap.js"></script>

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
            <form class="placefindbyname" onsubmit="return false;">
                <fieldset>
                    <legend class="indent">매장 검색</legend>
                    <label for="placeName">매장명 또는 주소를 입력해주세요.</label>
                    <input type="text" name="placeName" id="placeName" class="place_name" />
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
		<ul class="store_ul">
<?
    $list_page = 8;
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
		if(strpos($option['user_list'],'/design/noimg') !== false || strpos($option['user_list'],'noimg_sub') !== false){
			if(trim(implode('',array_filter(explode('||',$list['view3_file']))))!==''){
				$temp_url = $root.'/upload/'.$board.current(array_filter(explode('||',$list['view3_file'])));
				$option['user_list'] = '<img src="'.$temp_url.'" class="w100" />';
			}else{
				$contentsImg = current(explode('"',next(explode('src="',htmlspecialchars_decode($list['view3_command_01'])))));
				if($contentsImg !== ''){
					if(strpos($contentsImg,'://') !== false){
						//이미지 resize 가능
						$option['user_list'] = '<img src="'.$contentsImg.'" class="w100" />';
					}else{
						$option['user_list'] = '<img src="'.$contentsImg.'" class="w100" />';
					}
				}
			}
		}
?>
			<li class="store_li">
				<div class="store_img">
                    <a href="<?=$path_view;?>"><?=$option['user_list'];?></a>
                </div>
				<div class="store_list_txt">
					<p class="store_tit"><?=$list['view3_title_01']?></p>
					<?
						$addr = '';
						if(trim($list['view3_addr_road'])!==''){
							$addr = $list['view3_addr_road'].' '.$list['view3_addr_detail'];
						}else if(trim($list['view3_addr_number'])!==''){
							$addr = $list['view3_addr_number'].' '.$list['view3_addr_detail'];
						}
					?>
					<? if(trim($addr)!==''){ ?>
					<p class="store_txt"><em class="store_list_ico01">주소</em><span class="ellipsis"><?=$addr?></span></p>
					<? } ?>
					<? if(trim($list['view3_special_04'])!==''){ ?>
					<p class="store_txt m_t20"><em class="store_list_ico02">전화</em><span> <?=$list['view3_special_04'];?></span></p>
					<? } ?>
					<a href="<?=$path_view;?>" class="store_more">더보기</a>
				</div>
                <div class="drawborder_wrap">
                    <span class="drawborder drawborder-top"></span>
                    <span class="drawborder drawborder-right"></span>
                    <span class="drawborder drawborder-bottom"></span>
                    <span class="drawborder drawborder-left"></span>
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

<script type="text/javascript">
(function($) {
	doc.ready(function() {
		var drawBorder = $('.drawborder_wrap');
		var tl = [];
		for(var i=0, tempEl; i<drawBorder.length; i++) {
			tempEl = drawBorder.eq(i).children('.drawborder');
			drawBorder.eq(i).data('index', i);
			tl[i] = new TimelineLite({paused: true});
			tl[i]
			.to(tempEl.eq(0), 0.2, {width: '100%'})
			.to(tempEl.eq(1), 0.15, {height: '100%'})
			.to(tempEl.eq(2), 0.2, {width: '100%'})
			.to(tempEl.eq(3), 0.15, {height: '100%'});
			drawBorder.eq(i).closest('li').mouseenter(function() {
				tl[$(this).find('.drawborder_wrap').data('index')].play();
				if($(this).find('.paging_thumb').length > 0) {
					TweenLite.to($(this).find('.store_img img'), 1.0, {scale: 1.1});
				}
			}).mouseleave(function() {
				tl[$(this).find('.drawborder_wrap').data('index')].reverse();
				if($(this).find('.paging_thumb').length > 0) {
					TweenLite.to($(this).find('.store_img img'), 1.0, {scale: 1});
				}
			});
		}
	});
}(jQuery));
</script>

<?
} else {
	echo '<p class="nodata">준비중 입니다.</p>'.PHP_EOL;
}
?>

</div>
<!-- //board wrapper end -->