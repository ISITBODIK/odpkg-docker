<?php get_header(); ?>

<!-- 全体warapper -->
<div class="wrapper">

<!-- メインwrap -->
<div id="main">


<!-- コンテンツブロック -->
<div class="row">


<!-- 本文エリア -->
<article class="threequarter">

<!-- 検索結果の表示 -->
<h2 class="pagetitle">検索結果：<?php the_search_query(); ?></h2>
<?php if (have_posts()) : ?>
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
if($cat->parent) echo '<a href="'.get_category_link( $cat->cat_ID ).'">'. $cat->cat_name. '</a>';
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
<!-- /検索結果の表示 -->


<!-- キーワードが見つからないとき -->
<?php else: ?> 
<p>お探しのキーワードは見つかりませんでした。</p>
<?php endif; ?>
<!-- / キーワードが見つからないとき -->


<!-- ページャー -->
<div id="next-archives">
<span class="left"><?php previous_posts_link(__('＜')); ?></span>
<span class="right"><?php next_posts_link(__('＞')); ?></span>
<div class="clear"></div>
</div>
<!-- / ページャー -->
<!-- wp-pagenavi -->
<div class="next-pagenavi"><?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?></div>
<!-- / wp-pagenavi -->

</article>
<!-- / 本文エリア -->


<!-- サイドエリア -->
<article class="quarter">

<?php get_sidebar(); ?>

</article>
<!-- / サイドエリア -->


</div>
<!-- / コンテンツブロック -->


</div>
<!-- / メインwrap -->

<?php get_footer(); ?>
