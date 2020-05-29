<!-- header start -->
<div id="headerWrap" class="header_wrap">
    <div class="header_top">
        <h1 class="hd_logo"><a href="<?=$root?>/">상무초밥</a></h1>
        <button class="stm_btn bindSitemapSpread">사이트맵</button>
    </div>
    <div class="gnb_wrap swiper-container">
        <ul id="navigation" class="gnb swiper-wrapper">
<?
$depth1_link_query = "SELECT * FROM `".TABLE_LEFT."group` WHERE view3_use = '1' AND view3_setup = '$html_idx' ORDER BY view3_order";
$depth1_result = mysql_query($depth1_link_query);
while($depth1_list = mysql_fetch_assoc($depth1_result)) {
$depth2_link_query = "SELECT * FROM `".TABLE_LEFT."board` WHERE view3_use = '1' AND view3_setup = '$html_idx' AND view3_group_idx = '".$depth1_list['view3_idx']."' ORDER BY view3_order";
$depth2_result = mysql_query($depth2_link_query);
unset($depth1_link);
while($depth2_list = mysql_fetch_assoc($depth2_result)) {
switch($depth2_list['view3_style']) {
case 'html':
    if(file_exists(ROOT_INC.'/html/'.$depth2_list['view3_link'])) {
        $depth1_link = $root.'/html/'.$depth2_list['view3_link'];
    }
    break;
case 'board':
    $depth1_link = BOARD.'/index.php?board='.$depth2_list['view3_link'];
    break;
case 'http':
    $depth1_link = $depth2_list['view3_link'].'" target="_blank';
    break;
case 'url':
    $depth1_link = $depth2_list['view3_link'];
    break;
default:
    if(file_exists(ROOT_INC.'/html/'.$depth2_list['view3_link'])) {
        $depth1_link = $root.'/html/'.$depth2_list['view3_link'];
    }
}
if($depth1_link) {
if($depth2_list['view3_sca']) {
    if(strpos($depth1_link, '?') > -1) $depth1_link .= '&amp;sca='.$depth2_list['view3_sca'];
    else $depth1_link .= '?sca='.$depth2_list['view3_sca'];
}
if($depth1_list['view3_order_css'] == $gnb_index) $group_list['front_link'] = $depth1_link;
break;
}
}
?>
            <li class="<?=$depth1_list['view3_order_css']?><?if($depth1_list['view3_order_css'] == $gnb_index){echo ' on';}?> swiper-slide">
                <a href="<?=$depth1_link?>" class="depth1_a"><?=strip_tags(html_entity_decode($depth1_list['view3_title_01']))?></a>
            </li>
<?
}
?>
        </ul>
    </div>
</div>
<!-- //header end -->
