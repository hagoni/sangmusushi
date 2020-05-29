<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
$select_query_string = "SELECT * FROM `".TABLE_LEFT.$board."` WHERE `view3_use` = '1'";
if($view3_sca) {
	$select_query_string .= " AND `view3_sca` = '$view3_sca'";
}
$total_rows = mysql_num_rows(mysql_query($select_query_string));
?>

<?
if($total_rows > 0) {
    $list_num_per_page = 10;
    $pagination = 10;
    page($total_rows, $list_num_per_page, $pagination, $path_next, '', $view3_page, $end_page_path);
    $start_offset = ($view3_page - 1) * $list_num_per_page;
    $end_offset = $list_num_per_page;
    $query_string = $select_query_string." ORDER BY view3_order DESC, view3_write_day DESC LIMIT $start_offset, $end_offset";
    $result = mysql_query($query_string);
?>

<?
    $list_number = $total_rows - $start_offset;
    while($list = mysql_fetch_assoc($result)) {
		$path_view = URL_PATH.'?'.view3_link('||idx||select||search','view&select='.$view3_select.'&search='.$view3_search.'&idx='.$list['view3_idx']);
		$write_day = date('Y.m.d', strtotime($list['view3_write_day']));
		$list_file_array = explode('||', $list['view3_file']);
?>

<?
        $list_number--;
    }
?>

    <div class="paging fs_def">
    	<?=$out_page?>
    </div>
<?
}
?>