<?php
require_once("JSON.php");
$json = new Services_JSON();
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
define('_VIEW3BOARD_', TRUE);
include_once														"../../../view3.php";
######################################################################################################################################################
$board = $_POST['board'];
$tableName = TABLE_LEFT.$board;
$fieldList = explode('||', $_POST['select_list']);
$search = $_POST['search'];
$placeInfo = array();
$i = 0;

$special = " WHERE view3_special_01 NOT IN ('4') AND view3_use='1'";

if($search) {
	$query = "SELECT * FROM $tableName".$special." AND (";
	for($j=0; $j<count($fieldList); $j++) {
		$query .= TABLE_LEFT.$fieldList[$j]." LIKE '%$search%'";
		if($j < count($fieldList) - 1) {
			$query .= " OR ";
		}
	}
	$query .= ")";
} else {
	$query = "SELECT * FROM $tableName".$special;
}
$result = mysql_query($query);
while($list = mysql_fetch_assoc($result)) {
	if($list[view3_addr_road]) {
		$addr = $list[view3_addr_road]." ".$list[view3_addr_detail];
	} else {
		$addr = $list[view3_addr_number]." ".$list[view3_addr_detail];
	}
	$placeInfo[$i] = array(
		'id' => $list[view3_idx],
		'subject' => $list[view3_title_01],
		'address' => $addr,
		'phone' => $list[view3_special_04],
		'geocode' => array(
			'lat' => $list[view3_addr_y],
			'lng' => $list[view3_addr_x]
		)
	);
	$i++;
}
$data = array('data' => $placeInfo);
$output = $json->encode($data);
echo $output;
?>