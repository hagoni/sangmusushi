<div class="ig_wrap">
<?
if($linkbar_show == true) {
?>
    <div class="linkbar m_t50">
        <a href="https://www.instagram.com/explore/tags/<?=$hashTag?>/" target="_blank" title="instagram 바로가기"><img src="<?=$skinPath?>/img/linkbar_ig.jpg" alt="<?=$sitename?> instagram 바로가기" /></a>
    </div>
<?
}
?>
    <ul class="igContainer ig_list"></ul>

    <div class="load_more">
        <a href="#none" class="igMore spinner">
            <span class="load_link_tt">더보기</span>
            <span class="load_spinner"><img src="<?=$skinPath?>/img/spinner02.gif" alt="" /></span>
        </a>
    </div>

<?
$igContainerId = $_REQUEST['igContainerId'] ? $_REQUEST['igContainerId'] : '#boardWrap';
?>
<script type="text/javascript" src="<?=$skinPath?>/js/IG.js?<?=time?>"></script>
<script type="text/javascript">
(function($) {
    doc.ready(function() {
        var wrapper = $('<?=$igContainerId?>');
        new IG($('.igContainer', wrapper), {
            requestUrl: '<?=$skinPath?>/resource/ig_hash_feed.php',
            hashTag: '<?=$hashTag?>',
            wrapper: wrapper,
			ignoreCaption : '<?=str_replace("'","\\'",$ignoreCaption);?>',
            skinPath: '<?=$skinPath?>'
        });
    });
}(jQuery));
</script>

</div>