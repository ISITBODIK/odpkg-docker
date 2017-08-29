</div>
<!-- / 全体wrapper -->

<!-- Powerdエリア -->
<div id="powerd">
<div class="powerd-inner">

<!-- フッターウィジェット -->
<div class="row">
<article class="half">
<div id="pwbox">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Powerd3列-1') ) : ?>
<?php endif; ?>
</div>
</article>
<article class="fifth">
<div id="pwbox">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Powerd3列-2') ) : ?>
<?php endif; ?>
</div>
</article>
<article class="fifth">
<div id="pwbox">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Powerd3列-3') ) : ?>
<?php endif; ?>
</div>
</article>
</div>
<!-- / フッターウィジェット -->
<div class="clear"></div>

</div>
</div>
<!-- / Powerdエリア -->


<!-- フッターエリア -->
<footer id="footer">
<div class="footer-inner">

<!-- フッターウィジェット -->
<div class="row">
<article class="quarter">
<div id="topbox">
<!--
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('フッター3列-1') ) : ?>
<?php endif; ?>
-->
</div>
</article>
<article class="quarter">
<div id="topbox">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('フッター3列-2') ) : ?>
<?php endif; ?>
</div>
</article>
<article class="half">
<div id="topbox">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('フッター3列-3') ) : ?>
<?php endif; ?>
</div>
</article>

</div>
<!-- / フッターウィジェット -->
<div class="clear"></div>

</div>
</footer>
<!-- / フッターエリア -->

<?php wp_footer(); ?>

</body>
</html>
