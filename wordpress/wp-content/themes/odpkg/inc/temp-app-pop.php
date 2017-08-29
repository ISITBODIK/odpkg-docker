<?php
  $url = get_option('odpkg_ckan_api') . "/action/package_search?sort=views_recent+desc&rows=100";
  $json = json_decode ( wp_remote_get ( $url ) ['body'], true );
  $count = min(100, $json['result']['count']);
  $array = array();
  for ( $i=0 ; $i < $count ; $i++ ){
    if (0 < count($json['result']['results'][$i]['groups'])) {
      array_push($array, $json['result']['results'][$i]['groups'][0]['name']);
    }
  }
  $tmpArray = array_count_values($array);
  arsort($tmpArray);
?>

<div class="categoryset">
  <ul class="block-cat">

<?php foreach( array_slice($tmpArray,0,10) as $key=>$val ) { ?>
    <?php if( $key == "gr0100" ) { ?>
        <li><p><a href="<?php echo get_option('odpkg_ckan_web'); ?>/groups/gr0100"><i class="fa fa-map fa-5x"></i><br>国土･気象</a></p></li>
    <?php } elseif( $key == "gr0200" ) { ?>
        <li><p><a href="<?php echo get_option('odpkg_ckan_web'); ?>/groups/gr0200"><i class="fa fa-bar-chart fa-5x"></i><br>人口･世帯</a></p></li>
    <?php } elseif( $key == "gr0300" ) { ?>
        <li><p><a href="<?php echo get_option('odpkg_ckan_web'); ?>/groups/gr0300"><i class="fa fa-wrench fa-5x"></i><br>労働･賃金</a></p></li>
    <?php } elseif( $key == "gr0400" ) { ?>
        <li><p><a href="<?php echo get_option('odpkg_ckan_web'); ?>/groups/gr0400"><i class="fa fa-tree fa-5x"></i><br>農林水産業</a></p></li>
    <?php } elseif( $key == "gr0500" ) { ?>
        <li><p><a href="<?php echo get_option('odpkg_ckan_web'); ?>/groups/gr0500"><i class="fa fa-industry fa-5x"></i><br>鉱工業</a></p></li>
    <?php } elseif( $key == "gr0600" ) { ?>
        <li><p><a href="<?php echo get_option('odpkg_ckan_web'); ?>/groups/gr0600"><i class="fa fa-shopping-cart fa-5x"></i><br>商業･<br>サービス業</a></p></li>
    <?php } elseif( $key == "gr0700" ) { ?>
        <li><p><a href="<?php echo get_option('odpkg_ckan_web'); ?>/groups/gr0700"><i class="fa fa-calculator fa-5x"></i><br>企業･家計･<br>経済</a></p></li>
    <?php } elseif( $key == "gr0800" ) { ?>
        <li><p><a href="<?php echo get_option('odpkg_ckan_web'); ?>/groups/gr0800"><i class="fa fa-home fa-5x"></i><br>住宅･土地･<br>建設</a></p></li>
    <?php } elseif( $key == "gr0900" ) { ?>
        <li><p><a href="<?php echo get_option('odpkg_ckan_web'); ?>/groups/gr0900"><i class="fa fa-recycle fa-5x"></i><br>エネルギー･水</a></p></li>
    <?php } elseif( $key == "gr1000" ) { ?>
        <li><p><a href="<?php echo get_option('odpkg_ckan_web'); ?>/groups/gr1000"><i class="fa fa-subway fa-5x"></i><br>運輸･観光</a></p></li>
    <?php } elseif( $key == "gr1100" ) { ?>
        <li><p><a href="<?php echo get_option('odpkg_ckan_web'); ?>/groups/gr1100"><i class="fa fa-space-shuttle fa-5x"></i><br>情報通信･<br>科学技術</a></p></li>
    <?php } elseif( $key == "gr1200" ) { ?>
        <li><p><a href="<?php echo get_option('odpkg_ckan_web'); ?>/groups/gr1200"><i class="fa fa-futbol-o fa-5x"></i><br>教育･文化･スポーツ･生活</a></p></li>
    <?php } elseif( $key == "gr1300" ) { ?>
        <li><p><a href="<?php echo get_option('odpkg_ckan_web'); ?>/groups/gr1300"><i class="fa fa-university fa-5x"></i><br>行財政</a></p></li>
    <?php } elseif( $key == "gr1400" ) { ?>
        <li><p><a href="<?php echo get_option('odpkg_ckan_web'); ?>/groups/gr1400"><i class="fa fa-balance-scale fa-5x"></i><br>司法･安全･<br>環境</a></p></li>
    <?php } elseif( $key == "gr1500" ) { ?>
        <li><p><a href="<?php echo get_option('odpkg_ckan_web'); ?>/groups/gr1500"><i class="fa fa-medkit fa-5x"></i><br>社会保障･衛生</a></p></li>
    <?php } elseif( $key == "gr1600" ) { ?>
        <li><p><a href="<?php echo get_option('odpkg_ckan_web'); ?>/groups/gr1600"><i class="fa fa-globe fa-5x"></i><br>国際</a></p></li>
    <?php } elseif( $key == "gr9100" ) { ?>
        <li><p><a href="<?php echo get_option('odpkg_ckan_web'); ?>/groups/gr9100"><i class="fa fa-wheelchair fa-5x"></i><br>健康･福祉</a></p></li>
    <?php } elseif( $key == "gr9200" ) { ?>
        <li><p><a href="<?php echo get_option('odpkg_ckan_web'); ?>/groups/gr9200"><i class="fa fa-users fa-5x"></i><br>地域コミュニティ</a></p></li>
    <?php } elseif( $key == "gr9300" ) { ?>
        <li><p><a href="<?php echo get_option('odpkg_ckan_web'); ?>/groups/gr9300"><i class="fa fa-child fa-5x"></i><br>子育て</a></p></li>
    <?php } elseif( $key == "gr9400" ) { ?>
        <li><p><a href="<?php echo get_option('odpkg_ckan_web'); ?>/groups/gr9400"><i class="fa fa-cutlery fa-5x"></i><br>くらしの情報</a></p></li>
    <?php } elseif( $key == "gr9900" ) { ?>
        <li><p><a href="<?php echo get_option('odpkg_ckan_web'); ?>/groups/gr9900"><i class="fa fa-info-circle fa-5x"></i><br>その他</a></p></li>
    <?php } else { ?>
        
    <?php } ?>
<?php } ?>

  </ul>
</div>
