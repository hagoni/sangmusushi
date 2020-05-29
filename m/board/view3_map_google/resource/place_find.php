<?php
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
define('_VIEW3BOARD_', TRUE);
include_once('../../../../view3.php');
include_once('../../../../freebest/sql.php');
######################################################################################################################################################
$placeInfo = array();
$sql = $main_sql." AND `view3_addr_x` != '' AND `view3_addr_y` != '' ".$view_order;
$result = mysql_query($sql);
while($list = mysql_fetch_assoc($result)) {
	if($list['view3_addr_road']) {
		$addr = $list['view3_addr_road'].' '.$list['view3_addr_detail'];
	} else {
		$addr = $list['view3_addr_number'].' '.$list['view3_addr_detail'];
	}
	$placeInfo[] = array(
		'id' => $list['view3_idx'],
		'subject' => $list['view3_title_01'],
		'address' => $addr,
		'phone' => $list['view3_special_04'],
		'geocode' => array(
			'lat' => $list['view3_addr_y'],
			'lng' => $list['view3_addr_x']
		)
	);
}
$data = array('data' => $placeInfo);
echo json_encode($data);
?>