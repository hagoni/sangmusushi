<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
$query_string = "SELECT * FROM `".TABLE_LEFT.$board."` WHERE 1=1 AND `view3_idx` = '$view3_idx'";
$result = mysql_query($query_string);
$list = mysql_fetch_assoc($result);
$list_file_array = explode('||', $list['view3_file']);
$command_01 = preg_replace('/img(.+)src="/', 'img$1src="'.$pc, html_entity_decode($list['view3_command_01']));
view3_prev_next($view3_table, $view3_idx);
$path_prev = view3_link('||idx', 'write&idx='.$temp_prev, '', $end_path);
$path_next = view3_link('||idx', 'write&idx='.$temp_next, '', $end_path);
view3_hit($view3_table, $list['view3_idx']);
?>