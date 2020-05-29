<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
define('_VIEW3BOARD_', TRUE);
@include_once														"../../view3.php";
######################################################################################################################################################
$popup_table = 'popup_01';
$popup_idx = $_REQUEST['idx'];
$popup_sql_query = "SELECT * FROM `".TABLE_LEFT.$popup_table."` WHERE view3_idx = '".$popup_idx;
$popup_result = @mysql_query($popup_sql_query);
$popup_list = @mysql_fetch_assoc($popup_result);
if($popup_list['view3_special_01'] != '') {$popup_x = (int)$popup_list['view3_special_01'];} else {$popup_x = 0;}
if($popup_list['view3_special_02'] != '') {$popup_y = (int)$popup_list['view3_special_02'];} else {$popup_y = 0;}
if($popup_list['view3_special_03'] != '') {$popup_z = (int)$popup_list['view3_special_03'] + 5000;} else {$popup_z = 5000;}

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
	$popup_img = explode('||', $popup_list['view3_file']);
	$img_size = getimagesize('../../upload/'.$popup_table.$popup_img[0]);
	$layer_x = $img_size[0];
	$layer_y = $img_size[1];
	$popup_content .= '<img src="'.$root.'/upload/'.$popup_table.$popup_img[0].'" alt="'.$popup_list['view3_command_01'].'" width="'.$layer_x.'" height="'.$layer_y.'"';
	if($popup_list['view3_check_03'] != '2') {
		$popup_content .= ' /></a>';
	}
	if($popup_list['view3_check_03'] == '2') {
		$popup_content .= ' usemap="#usemap'.$popup_i.'" />';
		$popup_content .= '<map name="usemap'.$popup_i.'">';
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=SET;?>" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="author" content="" />
<meta name="viewport" content="width=device-width" />
<title><?=$popup_list['view3_title_01']?></title>
<style type="text/css">
/* CSS reset */
html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, hr, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video{margin:0;padding:0;border:0;font-size:100%;font:inherit;vertical-align:baseline;line-height:120%}
input, select{margin:0;padding:0;font-size:100%;font:inherit}
/* HTML5 display-role reset for older browsers */
article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section{display:block}
body{font-family:'돋움',Dotum,Verdana,AppleGothic}
li{list-style:none;}
blockquote, q{quotes:'"' '"'}
blockquote:before, blockquote:after, q:before, q:after{content:'';content:none}
table{border-collapse:collapse;border-spacing:0}
address{font-style:normal}
input, select, button, img{vertical-align:middle}
button{display:block;margin:0;padding:0;border:0;background-color:transparent;font:inherit;color:inherit;cursor:pointer}
a{color:inherit;text-decoration:none}
a:hover, a:focus{text-decoration:underline}

div.pop_footer{height:25px;margin:8px 10px 0 0;font-size:13px;color:#000;text-align:right;line-height:1.8em}
div.pop_footer label{display:inline-block;zoom:1;*display:inline}
div.pop_footer a.popup_x{display:inline-block;width:50px;height:19px;margin-left:5px;padding-top:4px;border:1px solid #e1e1e1;color:#5e5e5e;text-align:center;text-decoration:none;border-radius:3px;box-shadow:0 0 3px #999 inset;cursor:pointer;zoom:1;*display:inline}
</style>
</head>
<body>

<div id="popupLayer"><?=$popup_content?></div>

<div class="pop_footer">
	<label><input type="checkbox" name="popcheck" id="popcheck"> 오늘 하루 동안 열지 않기</label>
	<a href="#none" class="popup_x" onclick="window.close();">닫기</a>
</div>

<script type="text/javascript">
function setCookie(name, value, expiredays) {
	var todayDate = new Date();
	todayDate.setDate(todayDate.getDate() + expiredays);
	document.cookie = name +"="+escape(value) + "; path=/; expires=" + todayDate.toUTCString() + ";"
}

window.onload = function() {
	var popcheck = document.getElementById('popcheck');
	popcheck.onclick = function() {
		setCookie('popup'+<?=$popup_idx?>, 'hide', 1);
		window.close();
	};
}
</script>
</body>
</html>