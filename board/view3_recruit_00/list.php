<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
if($_GET['is_ajax']==='true'){
    include('list.ajax.php');
}else{
    include('list.inc.php');
}