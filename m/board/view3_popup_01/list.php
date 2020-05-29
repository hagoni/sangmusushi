<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
$popup_table = 'popup_01';
$popup_type = 'm_type01';
$popup_skin = 'view3_popup_01';
if(isset($_COOKIE['popup_'.$popup_type]) == false || $_COOKIE['popup_'.$popup_type] != 'hide') {
    $popup_sql_query = 'SELECT * FROM '.TABLE_LEFT.$popup_table.' WHERE view3_use = "1" AND view3_check_10 = "1" AND (view3_open = "0000-00-00 00:00:00" OR view3_close = "0000-00-00 00:00:00" OR (view3_open <= NOW() AND view3_close >= DATE(DATE_ADD(NOW(), interval -1 day)))) ORDER BY CAST(view3_special_06 AS unsigned) DESC, view3_idx desc';
	$popup_result = mysql_query($popup_sql_query);
	$popup_count = mysql_num_rows($popup_result);
	if($popup_count > 0) {
?>
<style>
.popup_<?=$popup_type?>{position:absolute;left:0;top:10%;z-index:5000;width:100%}
.<?=$popup_type?>_title{position:relative;height:27px;padding-top:8px;background-color:#851518;font-weight:700;font-size:1em;color:#fff;text-align:center}
.popup_<?=$popup_type?> .swiper-container{overflow:hidden;position:relative;height:100%}
.popup_<?=$popup_type?> .swiper-wrapper{height:100%}
.popup_<?=$popup_type?> .swiper-wrapper:after{content:'';display:block;clear:both}
.popup_<?=$popup_type?> .swiper-slide{float:left;width:100%}
.popup_<?=$popup_type?> .swiper-slide img{width:100%}
.<?=$popup_type?>_btns{position:absolute;top:0;width:39px;height:36px;background-repeat:no-repeat;background-size:cover;font-size:0}
.<?=$popup_type?>_prev{left:0;background-image:url('<?=BOARD.'/'.$popup_skin?>/img/btn_prev.jpg')}
.<?=$popup_type?>_next{right:0;background-image:url('<?=BOARD.'/'.$popup_skin?>/img/btn_next.jpg')}
#popupX<?=$popup_type?>{position:absolute;right:0;top:-36px;width:39px;height:36px;background-image:url('<?=BOARD.'/'.$popup_skin?>/img/btn_x.jpg');background-repeat:no-repeat;background-size:cover;font-size:0}
#popup<?=$popup_type?>Block{position:fixed;left:0;top:0;z-index:4000;width:100%;height:100%;background-color:rgba(0,0,0,0.6)}
</style>
<?
		$popup_content = '';
		while($popup_list = mysql_fetch_assoc($popup_result)) {
			$popup_content .= '<li class="swiper-slide">';
			if($popup_list['view3_check_02'] == '1') { // 팝업 컨텐츠 1.이미지 2.동영상
				if($popup_list['view3_special_10']) { // 링크
					$link = preg_replace('#^[^:/.]*[:/]+#i', '', $popup_list['view3_special_10']);
					$popup_content .= '<a href="http://'.$link.'"';
					if($popup_list['view3_check_04'] == '2') { // 링크 타겟 1.현재창 2.새 창
						$popup_content .= ' target="_blank"';
					}
					$popup_content .= '>';
				}
				$temp_img = explode('||', $popup_list['view3_file']);
				$popup_content .= '<img src="'.$pc.'/upload/'.$popup_table.$temp_img[1].'" alt="'.$popup_list['view3_command_01'].'">';
				if($popup_list['view3_special_10']) {
					$popup_content .= '</a>';
				}
			} else {
				if($popup_list['view3_special_05'] != '') {$layer_y = (int)$popup_list['view3_special_05'];} else {$layer_y = 320;}
				if($popup_list['view3_check_05'] == '1') { // 동영상 벤더 1.유투브 2.비메오
					$popup_content .= '<iframe src="http://www.youtube.com/embed/'.$popup_list['view3_video'].'?autoplay=0&amp;rel=0" width="100%" height="'.$layer_y.'" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>';
				} else {
					$popup_content .= '<iframe src="//player.vimeo.com/video/'.$popup_list['view3_video'].'?autoplay=0&amp;loop=0" width="100%" height="'.$layer_y.'" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>';
				}
			}
			$popup_content .= '</li>'.PHP_EOL;
		}
?>
<div id="popup<?=$popup_type?>" class="popup_<?=$popup_type?>">
    <p class="<?=$popup_type?>_title">새 소식</p>
	<div class="swiper-container">
        <ul class="swiper-wrapper">
			<?=$popup_content?>
		</ul>
	</div>
    <button type="button" class="<?=$popup_type?>_prev <?=$popup_type?>_btns">이전</button>
    <button type="button" class="<?=$popup_type?>_next <?=$popup_type?>_btns">다음</button>
    <button type="button" id="popupX<?=$popup_type?>">닫기</button>
</div>
<?
	}
}
?>