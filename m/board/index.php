<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
define('_VIEW3BOARD_', TRUE);
@include_once														"../../view3.php";
#####################################################################################################################################################
if(isset($_SESSION["code"])){
$view3_code_sql = "select * from ".TABLE_LEFT."member where view3_code='".$_SESSION["code"]."'";
$out_view3_code_sql =                                           @mysql_query($view3_code_sql);
$view3_session                                                = @mysql_fetch_assoc($out_view3_code_sql);
}
if(isset($no_include) == false) {
	include_once                                                        ROOT_M_INC.'/inc/top.php';
}
#####################################################################################################################################################
	$server_file_01 = TOP_INC."/freebest/".$view3_type.".php";
	if(file_exists($server_file_01)){
		$temp_server_file_01 = $server_file_01;
	}else{
		$temp_server_file_01 = ADMIN_INC."/main.php";
	}

	$server_file_02 = BOARD_INC."/".$view3_skin."/".$view3_type.".php";

	if(file_exists($server_file_02)){
		$temp_server_file_02 = $server_file_02;
	}else{
		$temp_server_file_02 = ADMIN_INC."/main.php";
	}
	if(!strcmp($view3_session['view3_level'],"100")){
//		echo $view3_skin;
	}
#####################################################################################################################################################
	@include                                                       TOP_INC."/freebest/sql.php";
	if(!strcmp($_GET['skin'], "root")){
		@include														$temp_server_file_01;
	}else{
		include															$temp_server_file_02;
	}
#####################################################################################################################################################
if(isset($no_include) == false) {
	include_once                                                        ROOT_M_INC.'/inc/bottom.php';
}
#####################################################################################################################################################
?>