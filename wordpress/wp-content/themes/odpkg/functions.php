<?php

/*** ヘッダータグの消去 ***/
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'feed_links_extra',3,0);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'parent_post_rel_link');
remove_action('wp_head', 'start_post_rel_link');
remove_action('wp_head', 'rel_canonical');


/*** セルフピンバック禁止 ***/
function no_self_ping( &$links ) {
$home = get_option( 'home' );
foreach ( $links as $l => $link )
if ( 0 === strpos( $link, $home ) )
    unset($links[$l]);
}
add_action( 'pre_ping', 'no_self_ping' );


/*** カスタムメニュー ***/
register_nav_menus(array('navigation' => 'ナビゲーションバー'));
register_nav_menus(array('sec_navigation' => 'トップインフォバー'));


/*** カスタム背景 ***/
add_theme_support( 'custom-background' );


/*** ウィジェット ***/
register_sidebar(array(
    'name'=>'サイドバー',
    'id'=>'sidebar-1',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<div class="sidebar-title">',
    'after_title' => '</div>',
));
register_sidebar(array(
    'name'=>'Powerd3列-1',
    'id'=>'sidebar-2',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<div class="sidebar-title2">',
    'after_title' => '</div>',
));
register_sidebar(array(
    'name'=>'Powerd3列-2',
    'id'=>'sidebar-3',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<div class="sidebar-title2">',
    'after_title' => '</div>',
));
register_sidebar(array(
    'name'=>'Powerd3列-3',
    'id'=>'sidebar-4',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<div class="sidebar-title2">',
    'after_title' => '</div>',
));
register_sidebar(array(
    'name'=>'フッター3列-1',
    'id'=>'sidebar-5',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<div class="sidebar-title">',
    'after_title' => '</div>',
));
register_sidebar(array(
    'name'=>'フッター3列-2',
    'id'=>'sidebar-6',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<div class="sidebar-title">',
    'after_title' => '</div>',
));
register_sidebar(array(
    'id'=>'sidebar-7',
    'name'=>'フッター3列-3',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<div class="sidebar-title">',
    'after_title' => '</div>',
));


/*** アイキャッチ画像 ***/
add_theme_support( 'post-thumbnails' );


/*** 続きを読む ***/
function new_excerpt_more($more) {
global $post;
return '<a href="'. get_permalink($post->ID) . '"> ...続きを読む</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');


/*** #more-$id を削除 ***/
function custom_content_more_link( $output ) {
$output = preg_replace('/#more-[\d]+/i', '', $output );
return $output;
}
add_filter( 'the_content_more_link', 'custom_content_more_link' );


/*** シングルページテンプレート ***/
add_filter('single_template', create_function('$t', 'foreach( (array) get_the_category() as $cat ) { if ( file_exists(TEMPLATEPATH . "/single-{$cat->term_id}.php") ) return TEMPLATEPATH . "/single-{$cat->term_id}.php"; } return $t;' ));


/*** ヴィジュアルエディタ ***/
function ilc_mce_buttons($buttons){
array_push($buttons, 'backcolor', 'copy', 'cut', 'paste', 'fontsizeselect', 'cleanup');
return $buttons;
}
add_filter('mce_buttons', 'ilc_mce_buttons');


/*** Google Analytics 設定 ***/
add_action( 'admin_menu', 'odpkg_ga_menu' );
function odpkg_ga_menu() {
    add_options_page( 'Google Analytics 設定',
                      'Google Analytics',
                      'manage_options',
                      'odpkg-ga',
                      'odpkg_ga_options' );
}
function odpkg_ga_options() {
    require_once ( get_template_directory() . '/options/odpkg_ga.php' );
}


/*** ロゴ画像設定 ***/
add_action('admin_menu', 'odpkg_logo_menu');
function odpkg_logo_menu() {
    add_theme_page( '背景/ロゴ画像設定',
                    '背景/ロゴ画像',
                    'edit_themes',
                    'odpkg-logo',
                    'odpkg_logo_options');
}
function odpkg_logo_options() {
    require_once ( get_template_directory() . '/options/odpkg_logo.php' );
}

/*** ビジュアライズ画像設定 ***/
add_action('admin_menu', 'odpkg_visualize_menu');
function odpkg_visualize_menu() {
    add_theme_page( 'ビジュアライズ画像設定',
                    'ビジュアライズ画像',
                    'edit_themes',
                    'odpkg-visualize',
                    'odpkg_visualize_options');
}
function odpkg_visualize_options() {
    require_once ( get_template_directory() . '/options/odpkg_visualize.php' );
}

/*** CKAN連携設定 ***/
add_action( 'admin_menu', 'odpkg_ckan_menu' );
function odpkg_ckan_menu() {
    add_options_page( 'CKAN連携設定',
                      'CKAN連携',
                      'manage_options',
                      'odpkg-ckan',
                      'odpkg_ckan_options' );
}
function odpkg_ckan_options() {
    require_once ( get_template_directory() . '/options/odpkg_ckan.php' );
}

/*** ダッシュボード連携設定 ***/
add_action( 'admin_menu', 'odpkg_dashboard_menu' );
function odpkg_dashboard_menu() {
    add_options_page( 'ダッシュボード連携設定',
                      'ダッシュボード連携',
                      'manage_options',
                      'odpkg-dashboard',
                      'odpkg_dashboard_options' );
}
function odpkg_dashboard_options() {
    require_once ( get_template_directory() . '/options/odpkg_dashboard.php' );
}

/*** イメージサイズの追加 ***/
function add_custom_image_sizes() {
    global $my_custom_image_sizes;
    $my_custom_image_sizes = array(
        'size-A' => array(
            'name'       => '2枚並び（サイドバー無）', // 「メディアを挿入」での名称
            'width'      => 430,    // 画像の最大幅
            'height'     => 320,    // 画像の最大高
            'crop'       => true,  // 切り抜き
            'selectable' => true   // 「メディアを挿入」での選択可否
        ),
        'size-B' => array(
            'name'       => '3枚並び（サイドバー無）',
            'width'      => 280,
            'height'     => 210,
            'crop'       => true,
            'selectable' => true
        ),	
			'size-C'     => array(
            'name'       => '縦長サムネイル',
            'width'      => 120,
            'height'     => 160,
            'crop'       => true,
            'selectable' => true
        ),	
    );
    foreach ( $my_custom_image_sizes as $slug => $size ) {
        add_image_size( $slug, $size['width'], $size['height'], $size['crop'] );
    }
}
add_action( 'after_setup_theme', 'add_custom_image_sizes' );
function add_custom_image_size_select( $size_names ) {
    global $my_custom_image_sizes;
    $custom_sizes = get_intermediate_image_sizes();
    foreach ( $custom_sizes as $custom_size ) {
        if ( isset( $my_custom_image_sizes[$custom_size]['selectable'] ) && $my_custom_image_sizes[$custom_size]['selectable'] ) {
            $size_names[$custom_size] = $my_custom_image_sizes[$custom_size]['name'];
        }
    }
    return $size_names;
}
add_filter( 'image_size_names_choose', 'add_custom_image_size_select' );
?>
