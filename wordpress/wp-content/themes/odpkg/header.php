<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<title><?php echo trim(wp_title('', false)); if(wp_title('', false)) { echo ' - '; } bloginfo('name'); ?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/responsive.css" type="text/css" media="screen, print" />
<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen, print" />
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link href='//fonts.googleapis.com/css?family=Quicksand:300,400,700' rel='stylesheet' type='text/css'>
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?php wp_head(); ?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/slick.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/slick-theme.css">
<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/jquery/scrolltopcontrol.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/jquery/slick.min.js"></script>
</head>

<body <?php body_class(); ?>>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', '<?php echo get_option('odpkg_ga_tracking_id'); ?>', 'auto');
  ga('send', 'pageview');
</script>

<!-- ヘッダー -->
<header id="header" style="background-position: bottom center; background-size: cover; background-image:url(<?php echo (get_option('odpkg_bg_url')) ? get_option('odpkg_bg_url') : get_template_directory_uri() . '/images/bgimg.jpg' ?>);">

<!-- ヘッダー中身 -->    
<div class="header-inner">
<!-- ロゴ -->
<h1 class="logo">
<a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><img src="<?php echo (get_option('odpkg_logo_url')) ? get_option('odpkg_logo_url') : get_template_directory_uri() . '/images/logo.png' ?>" alt="<?php bloginfo('name'); ?>"/></a>
</h1>
<!-- / ロゴ -->

<!-- トップナビゲーション -->
<div class="topinfo">
<nav id="infonav" class="info-navigation" role="navigation">
</nav>
<!-- サーチ -->
<?php include('inc/temp-dataset.php'); ?>
<!--?php get_search_form(); ?-->
<!-- / サーチ --> 
</div>
<!-- //トップナビゲーション -->

</div>    
<!-- / ヘッダー中身 -->    

</header>
<!-- / ヘッダー -->  
<div class="clear"></div>

<!-- トップナビゲーション -->
<div class="nav_wrap">
<nav id="nav" class="main-navigation" role="navigation">
<?php wp_nav_menu( array( 'menu' => 'topnav', 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
</nav>

</div>
<!-- / トップナビゲーション -->
<div class="clear"></div>
