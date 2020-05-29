<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
$popup_skin = 'view3_popup_01';
$popup_table = 'popup_01';
$popup_sql_query = 'SELECT * FROM '.TABLE_LEFT.$popup_table.' WHERE view3_use = "1" AND view3_check_09 = "1" AND (view3_open = "0000-00-00 00:00:00" OR view3_close = "0000-00-00 00:00:00" OR (view3_open <= NOW() AND view3_close >= DATE(DATE_ADD(NOW(), interval -1 day)))) ORDER BY CAST(view3_special_03 AS unsigned) desc, view3_idx desc';
$popup_result = mysql_query($popup_sql_query);
while($popup_list = mysql_fetch_assoc($popup_result)) {
    $idx = $popup_list['view3_idx'];
    if(isset($_COOKIE['popup'.$idx]) == true && $_COOKIE['popup'.$idx] == 'hide') {continue;}
	if($popup_list['view3_special_01'] != '') {$popup_x = (int)$popup_list['view3_special_01'];} else {$popup_x = 0;}
	if($popup_list['view3_special_02'] != '') {$popup_y = (int)$popup_list['view3_special_02'];} else {$popup_y = 0;}
    if($popup_list['view3_check_02'] == '1') { // 팝업 컨텐츠 1.이미지 2.동영상
        $temp_img = explode('||', $popup_list['view3_file']);
		$img_size = getimagesize(ROOT_INC.'/upload/'.$popup_table.$temp_img[0]);
		$layer_x = $img_size[0];
		$layer_y = $img_size[1];
	} else {
		if($popup_list['view3_special_04'] != '') {$layer_x = (int)$popup_list['view3_special_04'];} else {$layer_x = 480;}
		if($popup_list['view3_special_05'] != '') {$layer_y = (int)$popup_list['view3_special_05'];} else {$layer_y = 320;}
	}
?>
<script type="text/javascript">
window.open('<?=BOARD?>/<?=$popup_skin?>/window.php?idx=<?=$idx?>', 'popup', 'left=<?=$popup_x?>, top=<?=$popup_y?>, width=<?=$layer_x?>, height=<?=(int)$layer_y + 40?>, scrollbars=yes, menubar=no');
</script>
<?
}
?>