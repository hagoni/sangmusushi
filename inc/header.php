    <!-- header_wrap start -->
    <div class="header_wrap" id="headerWrap">
        <div class="header h100">
            <h1 class="logo l50"><a href="<?=$root?>/">상무초밥</a></h1>
            <a href="#none" class="btn_stm bindSitemapSpread">사이트맵</a>
            <ul class="hd_sns fs_def">
                <li><a href="https://facebook.com/sangmusushi/" target="_blank">페이스북</a></li>
                <li><a href="https://www.instagram.com/sangmusushi" target="_blank">인스타그램</a></li>
            </ul>
        </div>
        <div class="nav_wrap_org nav_wrap">
            <div class="nav">
                <ul id="navigation" class="depth1_ul fs_def t_center">
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
                    <li class="depth1_li depth1_li<?=$depth1_list['view3_order_css']?><?if($depth1_list['view3_order_css'] == $gnb_index){echo ' on';}?>">
                        <a href="<?=$depth1_link?>" class="depth1_a"><?=strip_tags(html_entity_decode($depth1_list['view3_title_02']))?></a>
                    </li>
    <?
    }
    ?>
                </ul>
                <a href="<?=$root?>/html/menu.html#3" class="nav_btn">
            		<div class="circle-shape">
            			<span class="btn-opener">
            				<img src="<?=$root?>/img/common/nav_btn_front.png" alt="" class="w100 front">
            				<img src="<?=$root?>/img/common/nav_btn_back_20200414.png" alt="" class="w100 back">
            			</span>
            		</div>
            	</a>
            </div>
        </div>
        <div class="nav_wrap_sm nav_wrap">
            <div class="nav_logo"><img src="<?=$root?>/img/main/nav_bi.png" alt="상무"></div>
            <a href="#none" class="btn_top">맨 위로</a>
            <a href="#none" class="btn_stm bindSitemapSpread">사이트맵</a>
            <div class="nav">
                <ul id="navigation" class="depth1_ul fs_def t_center">
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
                    <li class="depth1_li depth1_li<?=$depth1_list['view3_order_css']?><?if($depth1_list['view3_order_css'] == $gnb_index){echo ' on';}?>">
                        <a href="<?=$depth1_link?>" class="depth1_a"><?=strip_tags(html_entity_decode($depth1_list['view3_title_02']))?></a>
                    </li>
    <?
    }
    ?>
                </ul>
                <a href="<?=$root?>/html/menu.html#3" class="nav_btn">
            		<div class="circle-shape">
            			<span class="btn-opener">
            				<img src="<?=$root?>/img/common/nav_btn_front.png" alt="" class="w100 front">
            				<img src="<?=$root?>/img/common/nav_btn_back_20200414.png" alt="" class="w100 back">
            			</span>
            		</div>
            	</a>
            </div>
        </div>
    </div>
    <!-- //header_wrap end -->
