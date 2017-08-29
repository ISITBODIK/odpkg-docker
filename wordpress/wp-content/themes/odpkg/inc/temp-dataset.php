<!-- CKANデータセットの数を取得 -->
<div class="search">
<?php
$url = get_option('odpkg_ckan_api') . '/action/package_search?rows=0';
$json = json_decode ( wp_remote_get ( $url ) ['body'], true );
?>
<form action="<?php echo get_option('odpkg_ckan_web'); ?>/dataset" method="GET">
<div style="white-space:nowrap"><input id="field-sitewide-search" name="q" type="text" onfocus="if(this.value=='データセットを検索') this.value='';" onblur="if(this.value=='') this.value='データセットを検索';" value="データセットを検索" /><button type="submit"></button></div>
<div class="search_txt">
<?php echo $json['result']['count'] ?>件のデータ・セットから検索可能です
</div>
</form>
</div>
