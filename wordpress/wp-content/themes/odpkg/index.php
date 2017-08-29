<?php get_header(); ?>

<!-- 全体warapper -->
<div class="wrapper">

<!-- メインwrap -->
<div id="top-main">

<!-- コンテンツブロックrow -->
<div class="row">

<!-- グループ -->
<article class="threefifth">

<h2 class="top-midashi">人気のグループ</h2>
<?php include('inc/temp-app-pop.php'); ?>

</article>
<!-- //グループ -->

<!-- 新着情報 -->
<article class="twofifth">
<!--
<h2 class="top-midashi-info">お知らせ</h2>
-->
<h2 class="top-midashi">お知らせ</h2>
<!-- 投稿が存在するかを確認する条件文 -->
<div class="new">
<?php if (have_posts()) : ?>
<!-- 投稿一覧の最初を取得 -->
<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<!-- / 投稿一覧の最初 -->

<!-- 投稿ループ -->
<?php query_posts('showposts=10&category_name=info'); while(have_posts()) : the_post(); ?>
<dl>
<?php
$cats = get_the_category();
$cats = $cats[0];
?>
<dt><?php the_time(__('Y.m.d')) ?></dt>
<dd><a href="<?php the_permalink(); ?>" alt="<?php the_title(); ?>"><?php the_title(); ?></a></dd>
</dl>
<?php endwhile; ?>
</div>
<!-- / 投稿ループ -->

<!-- 投稿がない場合 -->
<?php else :
        if ( is_category() ) { // If this is a category archive
            printf('<h4>'.__('　　投稿がありません').'</h4>', single_cat_title('',false));
        } else if ( is_date() ) { // If this is a date archive
            echo('<h4>'.__('Sorry, but there aren\'t any posts with this date.').'</h4>');
        } else if ( is_author() ) { // If this is a category archive
            $userdata = get_userdatabylogin(get_query_var('author_name'));
            printf('<h4>'.__('Sorry, but there aren\'t any posts by %s yet.').'</h4>', $userdata->display_name);
        } else {
            echo('<h4>'.__('No posts found.').'</h4>');
        }
    endif;
?>
<div class="clear"></div>
<!-- / 投稿がない場合 -->
</article>
<!-- //新着情報 -->

<div class="clear"></div>
</div>
<!-- //コンテンツブロックrow -->


<!-- コンテンツブロックrow -->
<div class="row">
<!-- 新着データセット -->
<!-- 新着データセット CKANアクセス -->
<?php
$url = get_option('odpkg_ckan_api') . '/action/package_search?sort=metadata_modified+desc&rows=3';
$json = json_decode ( wp_remote_get ( $url ) ['body'], true );
?>

<article class="third">
<h2 class="top-midashi">新着データセット</h2>

<div class="new_dataset">
<?php for( $i=0 ; $i< count($json['result']['results']) ; $i++ ) : ?>
<dl>
    <dt><?php echo date('Y.m.d', strtotime($json['result']['results'][$i]['metadata_modified'])); ?></dt>
    <dd><a href="<?php echo get_option('odpkg_ckan_web'); ?>/dataset/<?php echo $json['result']['results'][$i]['name']; ?>"><?php echo$json['result']['results'][$i]['title']; ?></a></dd>
  </dl>
<?php endfor; ?>
</div>
</article>
<!-- //新着データセット -->

<!-- 人気のデータセット -->
<!-- 人気のデータセットCKANアクセス -->
<?php
$url = get_option('odpkg_ckan_api') . '/action/package_search?sort=views_total+desc&rows=3';
$json = json_decode ( wp_remote_get ( $url ) ['body'], true );
?>
<article class="third">
<h2 class="top-midashi">人気のデータセット</h2>

<div class="new_popular">
     <?php for( $i=0 ; $i< count($json['result']['results']) ; $i++ ) : ?>
     <dl>
    <dt><?php echo date('Y.m.d', strtotime($json['result']['results'][$i]['metadata_modified'])); ?></dt>
    <dd><a href="<?php echo get_option('odpkg_ckan_web'); ?>/dataset/<?php echo $json['result']['results'][$i]['name']; ?>"><?php echo $json['result']['results'][$i]['title']; ?></a></dd>
  </dl>
 <?php endfor; ?>
</div>
</article>
<!-- //人気のデータセット -->

<article class="third">
<h2 class="top-midashi">ビジュアライズ</h2>
<a href="<?php echo get_option('odpkg_visualize_url'); ?>"><img src="<?php echo (get_option('odpkg_visualize_img')) ? get_option('odpkg_visualize_img') : get_template_directory_uri() . '/images/visualization.png' ?>"></a>
</article>

<div class="clear"></div>
</div>
<!-- //コンテンツブロックrow -->

</div>
<!-- / メインwrap -->

<?php get_footer(); ?>
