<?php get_header(); ?>


<!-- 全体warapper -->
<div class="wrapper">

<!-- メインwrap -->
<div id="main">

<!-- コンテンツブロック -->
<div class="row">

<!-- 本文エリア -->
<article class="threequarter">

<!-- 投稿が存在するかを確認する条件文 -->
<?php if (have_posts()) : ?>

<!-- 投稿一覧の最初を取得 -->
<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>

<!-- カテゴリーアーカイブの場合 -->
<?php /* If this is a category archive */ if (is_category()) { ?>

<?php if(is_category()): ?>
 <?php
    $cat_id = get_query_var('cat');
    $cat = get_category($cat_id);
    $cat_parent_id = $cat->category_parent;
    $cat_parent = get_category($cat_parent_id);
    if( $cat_parent_id == 0 ): //親カテゴリの場合
      $cat_parent = get_category($cat_parent_id); ?>
   <h1 class="categorytitle"><?php single_cat_title(); ?></h1>
	 
 <?php else: //子カテゴリの場合 ?>
   <h1 class="categorytitle"><?php echo get_cat_name($cat_parent_id); ?></h1>
   <h1 class="pagetitle"><?php single_cat_title(); ?></h1>
	 	 
 <?php endif; ?>
<?php endif; ?>

<!-- タグアーカイブの場合 -->
<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
<h2 class="tit_normal"><?php single_tag_title(); ?></h2>

<!-- 日別アーカイブの場合 -->
<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
<h2 class="tit_normal"><?php printf(_c(' %s|Daily archive page'), get_the_time(__('Y-m-d'))); ?></h2>

<!-- 月別アーカイブの場合 -->
<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
<h2 class="tit_normal"><?php printf(_c(' %s|Monthly archive page'), get_the_time(__('Y-m'))); ?></h2>

<!-- 年別アーカイブの場合 -->
<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
<h2 class="tit_normal"><?php printf(_c('Archive for %s|Yearly archive page'), get_the_time(__('Y'))); ?></h2>

<!-- 著者アーカイブの場合 -->
<?php /* If this is an author archive */ } elseif (is_author()) { ?>
<h2 class="tit_normal"><?php _e('Author Archive'); ?></h2>

<!-- 複数ページにアーカイブの場合 -->
<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
<h2 class="tit_normal"><?php _e('Blog Archives'); ?></h2>

<?php } ?>
<!-- / 投稿一覧の最初 -->


<!-- 投稿ループ -->
<?php while (have_posts()) : the_post(); ?>

<dl class="catblog_list">
<dt class="item-img"><a href="<?php the_permalink(); ?>"><?php
if ( has_post_thumbnail() ) the_post_thumbnail();
else echo '<img src="'.get_template_directory_uri().'/images/noimage-630x420.jpg" />';
?></a></dt>
<?php
$cats = get_the_category();
$cats = $cats[0];
?>
<dd class="ico_<?php echo $cats->category_nicename; ?>">
<?php
$cats = get_the_category();
foreach($cats as $cat):
if($cat->parent) echo "<a href=\"".get_category_link( $cat->cat_ID )."\">". $cat->cat_name. "</a>";
endforeach;
?>
</dd>
<dd class="item-date"><?php the_time(__('Y.m.d')) ?></dd>
<dd class="tit"><a href="<?php the_permalink(); ?>" alt="<?php the_title(); ?>"><?php the_title(); ?></a></dd>
<dd><?php echo mb_substr(strip_tags($post-> post_content), 0, 50); ?>...</dd>
<dd class="more-link"><a href="<?php the_permalink(); ?>">続きを読む &raquo;</a></dd>
<div class="clear"></div>
</dl>
<?php endwhile; ?>
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
<!-- / 投稿がない場合 -->
<div class="clear mb30"></div>

<!-- ページャー -->
<!--div id="next-archives">
<span class="left"><?php previous_posts_link(__('＜')); ?></span>
<span class="right"><?php next_posts_link(__('＞')); ?></span>
<div class="clear"></div>
</div-->
<!-- / ページャー -->
<!-- wp-pagenavi -->
<div class="next-pagenavi"><?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?></div>
<!-- / wp-pagenavi -->

</article>
<!-- / 本文エリア -->


<!-- サイドエリア -->
<article class="quarter">

<?php
    get_sidebar();
?>

</article>
<!-- / サイドエリア -->


</div>
<!-- / コンテンツブロック -->


</div>
<!-- / メインwrap -->

<?php get_footer(); ?>
