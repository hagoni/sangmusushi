<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
$popup_type = 'type03';
$popup_skin = 'view3_popup_03';
?>
<style type="text/css">
.hpopup_wrap{display:none;overflow:hidden;position:absolute;left:0;top:0;z-index:1100;width:100%;background-color:#202328}
.hpopup{overflow:hidden;position:relative;width:100%;height:100%;margin:0 auto}
.hpopup_slide{overflow:hidden;position:relative;width:100%;height:100%}
.hpopup_slide ul, .hpopup_slide ul li{width:100%;height:100%}
.hpopup_slide a{display:block;width:100%;height:100%;text-indent:-10000px}
.hpopup_ctrl{position:absolute;bottom:15px;width:100%;font-size:0;text-align:center}
.hpopup_ctrl li{display:inline-block;width:9px;height:9px;margin:0 5px}
.hpopup_ctrl li a{display:block;width:100%;height:100%;background-image:url('<?=BOARD?>/<?=$popup_skin?>/img/popup_ctrl.png');background-repeat:no-repeat;background-position:0 0;text-indent:-10000px}
.hpopup_ctrl li.on a{background-position:0 100%}
.hpopup_check{position:absolute;right:45px;top:22px;font-size:12px;color:#fff}
.hpopup_x{display:block;position:absolute;right:20px;top:20px}
</style>
<?
$popup_table = 'popup_01';
$popup_sql_query = 'SELECT * FROM '.TABLE_LEFT.$popup_table.' WHERE view3_use = "1" AND view3_check_09 = "3" AND (view3_open = "0000-00-00 00:00:00" OR view3_close = "0000-00-00 00:00:00" OR (view3_open <= NOW() AND view3_close >= DATE(DATE_ADD(NOW(), interval -1 day)))) ORDER BY CAST(view3_special_03 AS unsigned) desc, view3_idx desc';
$temp_sql_query = $popup_sql_query." LIMIT 0, 1";
$temp_result = mysql_query($temp_sql_query);
$temp_count = mysql_num_rows($temp_result);
if($temp_count > 0) {
    $temp_list = mysql_fetch_assoc($temp_result);
    if($temp_list['view3_check_02'] == '1') {
        $temp_file = explode('||', $temp_list['view3_file']);
        $temp_h = getimagesize(ROOT_INC."/upload/popup_01".$temp_file[0]);
        $pop_h = $temp_h[1];
    } else {
        if($temp_list['view3_special_05'] != '') {$pop_h = (int)$temp_list['view3_special_05'];} else {$pop_h = 214;}
    }
}
$popup_result = mysql_query($popup_sql_query);
$popup_count = mysql_num_rows($popup_result);
if($popup_count > 0 && (isset($_COOKIE['hpopup']) == false || $_COOKIE['hpopup'] != 'hide')) {
?>
<div id="popupWrap" class="hpopup_wrap" style="height:<?=$pop_h?>px">
	<div class="hpopup">
		<div id="popupSlide" class="hpopup_slide">
			<ul>
<?
	while($popup_list = mysql_fetch_assoc($popup_result)) {
        if($popup_list['view3_check_02'] == '1') { // 팝업 컨텐츠 1.이미지 2.동영상
    		$popup_file = explode('||', $popup_list['view3_file']);
    		if($popup_list['view3_link']) {
    			$link_target = '';
    			if($popup_list['view3_special_01'] == 2) {
                    $link_target .= ' target="_blank"';
    			}
?>
				    <li style="background:url('<?=$pc?>/upload/popup_01<?=$popup_file[0]?>') no-repeat 50% 0"><a href="<?=$popup_list['view3_link']?>"<?=$link_target?>><?=$popup_list['view3_command_01']?></a></li>
<?
            } else {
?>
                    <li style="background:url('<?=$pc?>/upload/popup_01<?=$popup_file[0]?>') no-repeat 50% 0;text-indent:-10000px"><?=$popup_list['view3_command_01']?></li>
<?
            }
        } else {
            if($popup_list['view3_special_04'] != '') {$layer_x = (int)$popup_list['view3_special_04'];} else {$layer_x = 320;}
    		if($popup_list['view3_special_05'] != '') {$layer_y = (int)$popup_list['view3_special_05'];} else {$layer_y = 214;}
?>
                <div style="width:<?=$layer_x?>px;margin:0 auto">
<?
    		if($popup_list['view3_check_05'] == '1') { // 동영상 벤더 1.유투브 2.비메오
?>
                    <iframe src="http://www.youtube.com/embed/<?=$popup_list['view3_video']?>?autoplay=1&amp;rel=0" width="<?=$layer_x?>" height="<?=$layer_y?>" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>
<?
    		} else {
?>
                    <iframe src="//player.vimeo.com/video/<?=$popup_list['view3_video']?>?autoplay=1&amp;loop=1" width="<?=$layer_x?>" height="<?=$layer_y?>" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>
<?
    		}
?>
                </div>
<?
        }
    }
?>
			</ul>
		</div>
<?
	if($popup_count > 1) {
?>
		<ul id="popupCtrl" class="hpopup_ctrl">
<?
		for($i=0; $i<$popup_count; $i++) {
?>
			<li<?if($i==0){echo ' class="on"';}?>><a href="#none"><?=($i + 1)?></a></li>
<?
		}
?>
		</ul>
<?
	}
?>
		<div class="hpopup_check">
			<label for="hpopcheck"><input type="checkbox" name="hpopcheck" id="hpopcheck" class="hpopcheck" /> 오늘 하루 보지 않기</label>
		</div>
		<a href="#none" id="hpopupX" class="hpopup_x"><img src="<?=BOARD?>/<?=$popup_skin?>/img/popup_x.png" alt="" /></a>
	</div>
</div>

<script type="text/javascript">
(function($) {
	doc.ready(function() {
<?
    if($popup_count > 1) {
?>
        new CommonSlider($('#popupSlide'), {
            pagination: $('#popupCtrl')
        });
<?
    }
?>
	});
}(jQuery));
</script>
<?
}
?>