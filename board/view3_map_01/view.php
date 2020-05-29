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
$next_command_01 = view3_html($list['view3_command_01']);
if($list['view3_addr_road']) {
	$addr = $list['view3_addr_road']." ".$list['view3_addr_detail'];
} else {
	$addr = $list['view3_addr_number']." ".$list['view3_addr_detail'];
}
?>

<!-- board wrapper start -->
<div id="boardWrap">

	<div class="board_view_head">
		<p class="board_view_title b_fs_xl b_ff_h b_c_h ellipsis"><?=$option['notice']?><?=$list['view3_title_01']?></p>
		<ul class="board_view_sns">
			<li><a href="https://www.facebook.com/sharer/sharer.php?u=<?=urlencode('http://'.$_SERVER[SERVER_NAME].$_SERVER[REQUEST_URI]);?>" class="social-fb-share-btn"><img src="../img/board/sns_ico01.png" alt="페이스북 아이콘" /></a></li>
			<li><a href="http://blog.naver.com/openapi/share?url=<?=urlencode('http://'.$_SERVER[SERVER_NAME].$_SERVER[REQUEST_URI]);?>" class="social-bl-share-btn"><img src="../img/board/sns_ico02.png" alt="네이버 블로그 아이콘" /></a></li>
			<li><a href="https://story.kakao.com/share?url=<?=urlencode('http://'.$_SERVER[SERVER_NAME].$_SERVER[REQUEST_URI]);?>" class="social-ks-share-btn"><img src="../img/board/sns_ico03.png" alt="카카오스토리 아이콘" /></a></li>
		</ul>
	</div>

<?
if($option['user_map_view']) {
?>
	<div class="store_view_img">
		<div class="slider-container">
			<ul class="slider-wrapper">
				<?=$option['user_map_view'];?>
			</ul>
		</div>
		<button type="button" class="slider-btns slider-prev">이전</button>
		<button type="button" class="slider-btns slider-next">다음</button>
	</div>
<?
}
?>
	<div class="store_view_info">
		<ul class="store_info_list">
			<li class="store_info_li">
				<span class="store_info_ico store_info_ico01"></span>
				<div class="store_info_txt_area">
					<p class="b_fs_xxl b_lh_m b_c_m">매장주소</p>
					<p class="b_fs_m b_lh_m b_c_l m_t10"><?=$addr?></p>
				</div>
			</li>
<?
if($list['view3_special_04']) {
?>
			<li class="store_info_li">
				<span class="store_info_ico store_info_ico02"></span>
				<div class="store_info_txt_area">
					<p class="b_fs_xxl b_lh_m b_c_m">전화번호</p>
					<p class="b_fs_m b_lh_m b_c_l m_t10"><?=$list['view3_special_04']?></p>
				</div>
			</li>
<?
}
if($list['view3_special_02']) {
?>
			<li class="store_info_li">
				<span class="store_info_ico store_info_ico03"></span>
				<div class="store_info_txt_area">
					<p class="b_fs_xxl b_lh_m b_c_m">운영시간</p>
					<p class="b_fs_m b_lh_m b_c_l m_t10"><?=view3_html($list['view3_special_02'],'br')?></p>
				</div>
			</li>
<?
}
if($list['view3_special_05'] == 'on' || $list['view3_special_06'] == 'on' || $list['view3_special_07'] == 'on' || $list['view3_special_08'] == 'on' || $list['view3_special_09'] == 'on') {
?>
			<li class="store_info_li">
				<span class="store_info_ico store_info_ico04"></span>
				<div class="store_info_txt_area">
					<p class="b_fs_xxl b_lh_m b_c_m">서비스</p>
					<ul class="service_ico_area m_t10">
<?
######################################################################################################################################################
	if($list['view3_special_05'] == 'on') {
		echo '						<li class="service_ico service_ico01" title="주차 가능">주차 가능</li>'.PHP_EOL;
	}
	if($list['view3_special_06'] == 'on') {
		echo '						<li class="service_ico service_ico02" title="와이파이">와이파이</li>'.PHP_EOL;
	}
	if($list['view3_special_07'] == 'on') {
		echo '						<li class="service_ico service_ico03" title="신용 카드">신용 카드</li>'.PHP_EOL;
	}
	if($list['view3_special_08'] == 'on') {
		echo '						<li class="service_ico service_ico04" title="포장">포장</li>'.PHP_EOL;
	}
	if($list['view3_special_09'] == 'on') {
		echo '						<li class="service_ico service_ico05" title="배달">배달</li>'.PHP_EOL;
	}
######################################################################################################################################################
?>
					</ul>
				</div>
			</li>
<?
}
?>
		</ul>
	</div>
	<ul class="store_view_tabmenu">
		<li class="on"><a href="#none">지도보기</a></li>
		<li><a href="#none">로드뷰 보기</a></li>
	</ul>
	<div class="store_view_cont">
		<div id="roughMap" class="store_view_cont01"></div>
		<div id="roadView" class="store_view_cont02" style="display:none"></div>
	</div>
<?
######################################################################################################################################################
include_once(BOARD_INC.'/setup_bottom.php');
######################################################################################################################################################
?>
<script type="text/javascript">
(function($) {
	doc.ready(function() {
		new Tabbing($('.store_view_tabmenu'), $('.store_view_cont'));
		if($('.store_view_img li').length > 0) {
			new CommonSlider($('.store_view_img > .slider-container'), {
				prevBtn: $('.store_view_img > .slider-prev'),
				nextBtn: $('.store_view_img > .slider-next')
			});
		}
	});
}(jQuery));

<?
$markerImgPath = '/design/other/marker.png';
$markerImgSize = getImagesize(ROOT_INC.$markerImgPath);
?>

var marker = {
	src: '<?=$pc.$markerImgPath?>',
	offset: {x: <?=$markerImgSize[0] / 2?>, y: <?=$markerImgSize[1]?>},
	size: {x: <?=$markerImgSize[0]?>, y: <?=$markerImgSize[1]?>}
};
var placeInfo = {
	appkey: '<?=$settings_data['kakao_api_key'];?>',
	container: 'roughMap',
	geocode: {lat: '<?=$list['view3_addr_y']?>', lng: '<?=$list['view3_addr_x']?>'},
	scrollwheel: false,
	marker: marker,
	roadView: {
		container: 'roadView'
	}
};
</script>

</div>
<!-- //board wrapper end -->