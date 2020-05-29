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
$view_img_array = explode('||', $list['view3_file']);
$view_img = array();
for($i=0; $i<count($view_img_array); $i++) {
	if($i < 3 || $view_img_array[$i] == '') continue;
	$view_img[] = $pc.'/upload/'.$board.$view_img_array[$i];
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
if(count($view_img) > 0) {
?>
	<div class="store_view_img">
		<div class="swiper-container">
			<ul class="swiper-wrapper">
<?
	for($i=0; $i<count($view_img); $i++) {
?>
				<li class="swiper-slide"><img src="<?=$view_img[$i]?>" alt="" class="w100"></li>
<?
	}
?>
			</ul>
		</div>
		<button type="button" class="slider-btns slider-prev">이전</button>
		<button type="button" class="slider-btns slider-next">다음</button>
	</div>
<?
}
?>
<?
if($list['view3_video'] == "Vimeo" && trim($list['view3_link'])!='') {
?>
	<div class="store_view_video">
		<iframe src="//player.vimeo.com/video/<?=$list['view3_link']?>?autoplay=1&amp;loop=1" width="100%" height="566px" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>
	</div>
<?
} else if($list['view3_video'] == "YouTube" && trim($list['view3_link'])!='') {
?>
	<div class="store_view_video">
		<iframe src="http://www.youtube.com/embed/<?=$list['view3_link']?>?autoplay=1&amp;rel=0" width="100%" height="566px" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>
	</div>
<?
}
?>

	<div class="store_info_wrap">
		<!-- store_info_left start -->
		<div class="store_info_left f_left">
			<div class="store_tab_wrap">
				<ul class="store_tabmenu">
					<li class="on"><a href="#none">지도보기</a></li>
					<li><a href="#none">로드뷰보기</a></li>
				</ul>
			</div>
			<div class="store_tab_conts">
				<div class="store_tab_cont01">
					<div id="roughMap" class="store_map01">
					</div>
				</div>
				<div class="store_tab_cont02" style="display:none">
					<div id="roadView" class="store_map01">
					</div>
				</div>
			</div>
		</div>
		<!-- //store_info_left end -->
		<!-- store_info_right start -->
		<div class="store_info_right f_right">
			<p class="store_info_tit"><?=$list['view3_title_01']?></p>
			<span class="store_line"></span>
			<ul class="store_info_ul">
				<li class="store_info1">
					<p class="store_info_txt01">매장주소</p>
					<p class="store_info_txt02"><?=$addr?></p>
				</li>
<?
if($list['view3_special_04']) {
?>
				<li class="store_info2">
					<p class="store_info_txt01">전화번호</p>
					<p class="store_info_txt02"><?=$list['view3_special_04']?></p>
				</li>
<?
}
if($list['view3_special_02']) {
?>
				<li class="store_info3">
					<p class="store_info_txt01">운영시간</p>
					<p class="store_info_txt02"><?=view3_html($list['view3_special_02'],'br')?></p>
				</li>
<?
}
?>
			</ul>
		</div>
		<!-- //store_info_right end -->
	</div>
<?
######################################################################################################################################################
include_once(BOARD_INC.'/setup_bottom.php');
######################################################################################################################################################
?>

<script src="//dapi.kakao.com/v2/maps/sdk.js?appkey=<?=$settings_data['kakao_api_key'];?>&libraries=services"></script>
<script src="<?=$skin_path?>/js/KakaoMap.js"></script>
<script>
$(document).ready(function() {
	<?
	$markerImgPath = '/design/other/marker.png';
	$markerImgSize = getImagesize(ROOT_INC.$markerImgPath);
	?>

	new KakaoMap('roughMap', {
		geocode: {lat: '<?=$list['view3_addr_y']?>', lng: '<?=$list['view3_addr_x']?>'},
		scrollwheel: false,
		marker: {
			src: '<?=$pc.$markerImgPath?>',
			offset: {x: <?=$markerImgSize[0] / 2?>, y: <?=$markerImgSize[1]?>},
			size: {x: <?=$markerImgSize[0]?>, y: <?=$markerImgSize[1]?>}
		},
		roadView: {
			container: 'roadView'
		},
	});

	new Tabbing($('.store_tabmenu'), $('.store_tab_conts'));
	if($('.store_view_img li').length > 0) {
		new Swiper($('.store_view_img > .swiper-container'), {
			autoplay: {
				delay: 4000
			},
			autoHeight: true,
			navigation: {
				prevEl: $('.store_view_img > .slider-prev'),
				nextEl: $('.store_view_img > .slider-next')
			}
		});
	}

	/*ChromeRoadViewFix*/
	var roadViewFlashMSG = function(bindEl) {
        var _this = this;
        this.init = function() {
            var roadmapChecker = setInterval(function() {
                $(bindEl).each(function() {
                    if ($(this).find('object, embed, canvas').length > 0) {
                        $('.roadViewFlashMSG').remove();
                        clearInterval(roadmapChecker);
                    }
                });
            }, 1000);
            $(bindEl).each(function() {
                var thisMapWrap = this;
                if ($(this).html().trim() !== '') return;
                _this.insertMSG($(this));
            });
        }
        this.insertMSG = function(el) {
            var wrap = $('<div class="roadViewFlashMSG"><p style="position: relative; z-index: 1; margin-top: 235px; text-align: center; line-height: 40px; font-size: 16px; color: rgb(255, 255, 255);">FlashPlayer를 사용하기 위해 권한 허용 또는 설치가 필요합니다.<br><a target="_blank" href="http://get.adobe.com/flashplayer/" style="position: relative; display: inline-block; line-height: 38px; padding: 0px 23px; font-size: 18px; background-color: rgb(255, 255, 255); text-align: center; color: rgb(122, 122, 122);">승인</a></p></div>');
            wrap.css({
                position: 'absolute',
                left: 0,
                top: 0,
                height: (el.height() > 0 ? el.height() : '100%'),
                width: (el.width() > 0 ? el.width() : '100%'),
                backgroundColor: 'rgba(0,0,0,0.5)'
            });
            $('p', wrap).css({
                position: 'relative',
                zIndex: 1,
                marginTop: parseInt((el.height() / 2) - 40, 10),
                textAlign: 'center',
                lineHeight: '40px',
                fontSize: '16px',
                color: '#FFFFFF'
            });
            $('a', wrap).css({
                position: 'relative',
                display: 'inline-block',
                lineHeight: '38px',
                padding: '0 23px',
                fontSize: '18px',
                backgroundColor: 'rgba(255,255,255,1)',
                textAlign: 'center',
                color: '#7A7A7A'
            });
            $('a', wrap).attr('target', '_blank');
            $('a', wrap).attr('href', 'http://get.adobe.com/flashplayer/');
            el.append(wrap);
        };
        this.init();
    }

	new roadViewFlashMSG('#roadView');
});
</script>

</div>
<!-- //board wrapper end -->