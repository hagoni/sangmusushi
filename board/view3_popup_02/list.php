<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
$popup_type = 'type02';
$popup_skin = 'view3_popup_02';
?>
<style type="text/css">
.popup_<?=$popup_type?>{display:none;opacity:0;position:absolute;left:50%;padding:10px;background:#fff;box-shadow:2px 2px 4px rgba(0,0,0,.5);
-ms-filter:"progid:DXImageTransform.Microsoft.Shadow(Strength=5, Direction=135, Color='#000000')";
filter:progid:DXImageTransform.Microsoft.Shadow(Strength=5, Direction=135, Color='#000000');
}
.popup_<?=$popup_type?> div.pop_footer{height:25px;margin-top:8px;font-size:0;line-height:1.8em;color:#000;text-align:right}
.popup_<?=$popup_type?> div.pop_footer label{display:inline-block;font-size:13px;zoom:1;*display:inline}
.popup_<?=$popup_type?> div.pop_footer a.popup_x{display:inline-block;width:50px;height:19px;margin-left:5px;padding-top:4px;border:1px solid #e1e1e1;color:#5e5e5e;text-align:center;text-decoration:none;border-radius:3px;box-shadow:0 0 3px #999 inset;font-size:13px;cursor:pointer;zoom:1;*display:inline}
#popup<?=$popup_type?>Block{position:fixed;left:0;top:0;z-index:990;width:100%;height:100%;background:#666;background-color:rgba(33,33,33,0.8);}
</style>

<?
$popup_table = 'popup_01';
$popup_sql_query = 'SELECT * FROM '.TABLE_LEFT.$popup_table.' WHERE view3_use = "1" AND view3_check_09 = "2" AND (view3_open = "0000-00-00 00:00:00" OR view3_close = "0000-00-00 00:00:00" OR (view3_open <= NOW() AND view3_close >= DATE(DATE_ADD(NOW(), interval -1 day)))) ORDER BY CAST(view3_special_03 AS unsigned) desc, view3_idx desc';
$popup_result = mysql_query($popup_sql_query);
while($popup_list = mysql_fetch_assoc($popup_result)) {
	$idx = $popup_list['view3_idx'];
	if(isset($_COOKIE['popup'.$idx]) == true && $_COOKIE['popup'.$idx] == 'hide') {continue;}
	if($popup_list['view3_special_01'] != '') {$popup_x = (int)$popup_list['view3_special_01'];} else {$popup_x = 0;}
	if($popup_list['view3_special_02'] != '') {$popup_y = (int)$popup_list['view3_special_02'];} else {$popup_y = 0;}
	if($popup_list['view3_special_03'] != '') {$popup_z = (int)$popup_list['view3_special_03'] + 1000;} else {$popup_z = 1000;}

	$popup_content = '';

	if($popup_list['view3_check_02'] == '1') { // 팝업 컨텐츠 1.이미지 2.동영상
		if($popup_list['view3_check_03'] == '1') { // 링크 0.없음 1.일반링크 2.이미지맵
			$link = preg_replace('#^[^:/.]*[:/]+#i', '', $popup_list['view3_link']);
			$popup_content .= '<a href="http://'.$link.'"';
			if($popup_list['view3_check_04'] == '2') { // 링크 타겟 1.현재창 2.새 창
				$popup_content .= ' target="_blank"';
			}
			$popup_content .= '>';
		}
		$temp_img = explode('||', $popup_list['view3_file']);
		$img_size = getimagesize(ROOT_INC.'/upload/'.$popup_table.$temp_img[0]);
		$layer_x = $img_size[0];
		$layer_y = $img_size[1];
		$popup_content .= '<img src="'.$pc.'/upload/'.$popup_table.$temp_img[0].'" alt="'.$popup_list['view3_command_01'].'" width="'.$layer_x.'" height="'.$layer_y.'"';
		if($popup_list['view3_check_03'] == '0') {
			$popup_content .= ' />';
		} else if($popup_list['view3_check_03'] == '1') {
			$popup_content .= ' /></a>';
		} else {
			$popup_content .= ' usemap="#usemap'.$idx.'" />';
			$popup_content .= '<map name="usemap'.$idx.'">';
			$popup_content .= htmlspecialchars_decode($popup_list['view3_link']);
			$popup_content .= '</map>';
		}
	} else {
		if($popup_list['view3_special_04'] != '') {$layer_x = (int)$popup_list['view3_special_04'];} else {$layer_x = 480;}
		if($popup_list['view3_special_05'] != '') {$layer_y = (int)$popup_list['view3_special_05'];} else {$layer_y = 320;}
		if($popup_list['view3_check_05'] == '1') { // 동영상 벤더 1.유투브 2.비메오
			$popup_content .= '<iframe src="http://www.youtube.com/embed/'.$popup_list['view3_video'].'?autoplay=1&amp;rel=0" width="'.$layer_x.'" height="'.$layer_y.'" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>';
		} else {
			$popup_content .= '<iframe src="//player.vimeo.com/video/'.$popup_list['view3_video'].'?autoplay=1&amp;loop=1" width="'.$layer_x.'" height="'.$layer_y.'" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>';
		}
	}

	$popup_content .= PHP_EOL;
?>
<div id="popup<?=$popup_list['view3_idx']?>" class="popup_<?=$popup_type?>" style="top:<?=$popup_y?>px;z-index:<?=$popup_z?>;margin-left:<?=(int)$popup_x - 10?>px" onmousedown="dragger.startDrag(event, this);" data-index="<?=$idx?>">
	<?=$popup_content?>
	<div class="pop_footer">
		<label for="popcheck<?=$idx?>"><input type="checkbox" name="popcheck" id="popcheck<?=$idx?>" class="popcheck" />&nbsp;&nbsp;오늘 하루 동안 열지 않기</label>
		<a href="#none" id="popupX<?=$idx?>" class="popup_x">닫기</a>
	</div>
</div>
<?
}
?>