<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
define('_VIEW3BOARD_', TRUE);
@include_once														"../../view3.php";
######################################################################################################################################################
if(!isset($_SESSION['data'])) {
?>
<script>
alert('잘못된 접근입니다');
history.go(-1);
</script>
<?
}

//==========================================================================================================================
// XSS(Cross Site Scripting) 공격에 의한 데이터 검증 및 차단
//--------------------------------------------------------------------------------------------------------------------------
function xss_clean($data)
{
    // If its empty there is no point cleaning it :\
    if(empty($data))
        return $data;

    // Recursive loop for arrays
    if(is_array($data))
    {
        foreach($data as $key => $value)
        {
            $data[$key] = xss_clean($value);
        }

        return $data;
    }

    // http://svn.bitflux.ch/repos/public/popoon/trunk/classes/externalinput.php
    // +----------------------------------------------------------------------+
    // | Copyright (c) 2001-2006 Bitflux GmbH                                 |
    // +----------------------------------------------------------------------+
    // | Licensed under the Apache License, Version 2.0 (the "License");      |
    // | you may not use this file except in compliance with the License.     |
    // | You may obtain a copy of the License at                              |
    // | http://www.apache.org/licenses/LICENSE-2.0                           |
    // | Unless required by applicable law or agreed to in writing, software  |
    // | distributed under the License is distributed on an "AS IS" BASIS,    |
    // | WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or      |
    // | implied. See the License for the specific language governing         |
    // | permissions and limitations under the License.                       |
    // +----------------------------------------------------------------------+
    // | Author: Christian Stocker <chregu@bitflux.ch>                        |
    // +----------------------------------------------------------------------+

    // Fix &entity\n;
    $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/', '$1;', $data);
    $data = preg_replace('/(&#x*[0-9A-F]+);*/i', '$1;', $data);

    if (function_exists("html_entity_decode"))
    {
        $data = html_entity_decode($data);
    }
    else
    {
        $trans_tbl = get_html_translation_table(HTML_ENTITIES);
        $trans_tbl = array_flip($trans_tbl);
        $data = strtr($data, $trans_tbl);
    }

    // Remove any attribute starting with "on" or xmlns
    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#i', '$1>', $data);

    // Remove javascript: and vbscript: protocols
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#i', '$1=$2nojavascript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#i', '$1=$2novbscript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#', '$1=$2nomozbinding...', $data);

    // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#i', '$1>', $data);

    // Remove namespaced elements (we do not need them)
    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

    do
    {
        // Remove really unwanted tags
        $old_data = $data;
        $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
    }
    while ($old_data !== $data);

    return $data;
}

//sql injection 대비 변환
function getRequestVal($val) {
	if(!empty($val)){
		$val = xss_clean(@strip_tags(@trim($val)));
	}
	return $val;
}

//실질 IP를 구한다.
function getRealIpAddr() {
    if(!empty($_SERVER['HTTP_CLIENT_IP']) && getenv('HTTP_CLIENT_IP')){
        return $_SERVER['HTTP_CLIENT_IP'];
    } else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']) && getenv('HTTP_X_FORWARDED_FOR')){
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if(!empty($_SERVER['REMOTE_HOST']) && getenv('REMOTE_HOST')){
        return $_SERVER['REMOTE_HOST'];
    } else if(!empty($_SERVER['REMOTE_ADDR']) && getenv('REMOTE_ADDR')){
        return $_SERVER['REMOTE_ADDR'];
    }
    return false;
}

$board = getRequestVal($_POST['board']);
$url = getRequestVal($_POST['url']);

$fields = array();
$values = array();
foreach($_POST as $field => $value) {
    if($field == 'board' || $field == 'step' || $field == 'agree01' || $field == 'agree02' || $field == 'url' || $field == 'figure') continue;
	$fields[] = $field;
	$values[] = "'".getRequestVal($value)."'";
}

$fields[] = "write_day";
$values[] = "'".date("Y-m-d H:i:s")."'";

$fields[] = "ip";
$values[] = "'".getRealIpAddr()."'";

//파일 저장
$temp_folder = ROOT_INC."/upload/temp";
$save_folder = ROOT_INC."/upload/".$board;
$new_folder = "/".Y_m_d;
$create_folder = $save_folder.$new_folder;
$real_name_value = "";
$save_name_value = "";
foreach($_FILES as $file_key => $file_val) {
    $file_count = max(array_keys($_FILES[$file_key]['name'])) + 1;
    for($file_i=0; $file_i<$file_count; $file_i++) {
        if($_FILES[$file_key]['name'][$file_i]) {
            $file_ext = ext($_FILES[$file_key]['name'][$file_i]);
            $temp_save_file_text = uniqid().'_'.random_generator('5','5').'_'.date('Y_m_d_h_i_s').$file_ext[1];
            if(!is_dir($save_folder)) {
                @umask(0);
                @mkdir($save_folder, 0777, true);
            }
            if(!is_dir($create_folder)) {
                @umask(0);
                @mkdir($create_folder, 0777, true);
            }
            @move_uploaded_file($_FILES[$file_key]['tmp_name'][$file_i], $create_folder.'/'.$temp_save_file_text);

            $real_name_value .= $_FILES[$file_key]['name'][$file_i];
            $save_name_value .= $new_folder."/".$temp_save_file_text;
        }

        if($file_i < $file_count - 1) {
            $real_name_value .= "||";
            $save_name_value .= "||";
        }
    }
}
$fields[] = "filename";
$values[] = "'".$real_name_value."'";
$fields[] = "filepath";
$values[] = "'".$save_name_value."'";

$fields = ' (' . implode(', ', $fields) . ')';
$values = '('. implode(', ', $values) .')';

$sql = "INSERT INTO `".TABLE_LEFT.$board."` ".$fields." VALUES ".$values;
$result = @mysql_query($sql);

if($result) {
	// echo '<script>alert(\'감사합니다.\n귀하의 입사지원이 완료되었습니다.\');location.href = \''.$url.'\'</script>';
?>
<script>
alert('감사합니다.\n귀하의 입사지원이 완료되었습니다.');
setTimeout(function(){
    location.href = '<?=$url;?>';
},2000);
window.parent.closeLayer();
</script>
<?
    unset($_SESSION['data']);
} else {
	echo '<script>alert(\'입력이 되지 않았습니다.\');history.go(-1);</script>';
}
?>