<?php
require_once("JSON.php");
$json = new Services_JSON();
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
define('_VIEW3BOARD_', TRUE);
error_reporting(0);
include_once														"../../../view3.php";
######################################################################################################################################################
if(isset($_SESSION["code"])){
	$view3_code_sql = "select * from ".TABLE_LEFT."member where view3_code='".$_SESSION["code"]."'";
	$out_view3_code_sql =                                           @mysql_query($view3_code_sql);
	$view3_session                                                = @mysql_fetch_assoc($out_view3_code_sql);
}
######################################################################################################################################################
@include_once                                                       TOP_INC."/freebest/sql.php";
######################################################################################################################################################

$placeInfo = array();
$i = 0;

$sql = $main_sql.' AND `view3_addr_x`!="" AND `view3_addr_y`!="" '.$view_order.';';

$result = mysql_query($sql);
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