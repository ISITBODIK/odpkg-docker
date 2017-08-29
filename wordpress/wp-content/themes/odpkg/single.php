<?php get_header(); ?>

<!-- 全体warapper -->
<div class="wrapper">

<!-- メインwrap -->
<div id="main">


<!-- コンテンツブロック -->
<div class="row">


<!-- 本文エリア -->
<article class="threequarter">

<?php
  $cat = get_the_category();
  if ($cat[0]->category_parent): //子カテゴリの場合
  $parent_cat = get_category($cat[0]->category_parent);
?>
    <h1 class="categorytitle"><?php echo $parent_cat->name; ?></h1>
    <h1 class="pagetitle"><?php echo $cat[0]->cat_name; ?></h1>
<?php else: //親カテゴリの場合 ?>
    <h1 class="categorytitle"><?php echo $cat[0]->cat_name; ?></h1>
<?php endif; ?>


<!-- 投稿 -->
<div class="entry">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<h2><?php the_title(); ?></h2>
<div class="date"><?php the_time(__('Y.m.d')) ?></div>

<?php the_content(); ?>

<!-- ウィジェットエリア（本文下の広告枠） -->
<div class="row widget-adspace">
<article>	
<div id="topbox">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('本文下の広告枠') ) : ?>
<?php endif; ?>
</div>
</article>	
</div>
<!-- / ウィジェットエリア（本文下の広告枠） -->

<div id="blog-foot"><?php the_time(__('Y.m.d')) ?> ｜ <?php printf(__('Posted in %s'), get_the_category_list(', ')); ?> ｜ <?php edit_post_link(__('Edit'), ''); ?></div>
<!-- / 投稿 -->

<!-- ページャー -->
<div id="next">
<span class="left"><?php previous_post_link('%link', '＜ %title', 'true'); ?></span>
<span class="right"><?php next_post_link('%link', '%title ＞', 'true'); ?></span>
<div class="clear"></div>
</div>
<!-- / ページャー -->

<!-- 投稿が無い場合 -->
<?php endwhile; else: ?>
<p><?php echo 'お探しの記事、ページは見つかりませんでした。'; ?></p>
<?php endif; ?>
<!-- 投稿が無い場合 -->


<!-- ウィジェットエリア（コメント下の広告枠） -->
<div class="row widget-adspace">
<article>	
<div id="topbox">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('コメント下の広告枠') ) : ?>
<?php endif; ?>
</div>
</article>	
</div>
<!-- / ウィジェットエリア（コメント下の広告枠） -->

</div>
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
