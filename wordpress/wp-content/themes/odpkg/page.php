<?php get_header(); ?>


<!-- 全体warapper -->
<div class="wrapper">

<!-- メインwrap -->
<div id="main">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php
 global $post;
 if ( is_page() && $post->post_parent ):  //子ページの場合
?>
 <h1 class="categorytitle"><?php echo esc_attr( get_the_title($post->post_parent) ); ?></h1>
<?php else: //親ページの場合 ?>
 <h1 class="categorytitle"><?php the_title_attribute(); ?></h1>
<?php endif; ?>

<div class="entry">
<?php the_content(); ?>

<?php endwhile; else: ?>
<p><?php echo 'お探しの記事、ページは見つかりませんでした。'; ?></p>
<?php endif; ?>

</div>
</div>
<!-- / メインwrap -->

<?php get_footer(); ?>