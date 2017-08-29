<?php
if ( !current_user_can( 'manage_options' ) )  {
  wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

$opt_visualize_img_name = 'odpkg_visualize_img';
$opt_visualize_url_name = 'odpkg_visualize_url';

$hidden_field_name = 'odpkg_submit_hidden';

$opt_visualize_img_val = get_option( $opt_visualize_img_name );
$opt_visualize_url_val = get_option( $opt_visualize_url_name );

if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
  $opt_visualize_img_val = $_POST[ $opt_visualize_img_name ];
  $opt_visualize_url_val = $_POST[ $opt_visualize_url_name ];
  update_option( $opt_visualize_img_name, $opt_visualize_img_val );
  update_option( $opt_visualize_url_name, $opt_visualize_url_val );
?>
<div class="updated"><p><strong><?php echo __('Settings saved.'); ?></strong></p></div>
<?php
}
?>

<div class="wrap">
  <h2>ビジュアライズ画像の設定</h2>
  <p>画像をアップロードすると、画像が自動的に変更されます。</p>
  <form method="post" action="">
    <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
    <table class="form-table">

    <tr>
    <th scope="row"><label for="<?php echo $opt_visualize_img_name; ?>"><?php _e('◎ビジュアライズ画像のURL'); ?></label></th>
    <td>
      <input type="text" name="<?php echo $opt_visualize_img_name; ?>" id="<?php echo $opt_visualize_img_name; ?>" size="80"
            value="<?php echo esc_attr( get_option($opt_visualize_img_name) ); ?>"/>　（http://〜）
    </td>
    </tr>

    <tr>
    <th scope="row"><label for="<?php echo $opt_visualize_url_name; ?>"><?php _e('◎ビジュアライズ画像のリンクURL'); ?></label></th>
    <td>
      <input type="text" name="<?php echo $opt_visualize_url_name; ?>" id="<?php echo $opt_visualize_url_name; ?>" size="80"
            value="<?php echo esc_attr( get_option($opt_visualize_url_name) ); ?>"/>　（http://〜）
    </td>
    </tr>

    <tr>
    <th></th>
    <td>
      <p>
      <a href="<?php bloginfo('url'); ?>/wp-admin/media-new.php" target="_blank" rel="noopener noreferrer">画像をアップロード</a><br>
      ＊画像サイズ：横幅420px 高さ300px ファイル：png<br>
      </p>
      <p>
      ＜変更方法＞
      <ol>
      <li>WordPressのメディアライブラリーに画像をアップロード</li>
      <li>ファイルの URLをコピー</li>
      <li>上のボックスにファイルのURLをペースト</li>
      <li>ページ一番下の「設定を保存ボタン」を押す</li>
      </ol>
      ＊削除する場合は空欄にして保存ボタンを押してください。初期設定の画像に戻ります。
      </p>
      <p>
      ＜現在の画像＞<br>
      <img src="<?php echo esc_attr( get_option($opt_visualize_img_name) ) ? get_option($opt_visualize_img_name) : get_template_directory_uri() . '/images/visualization.png'; ?>">
      </p>
    </td>
    </tr>

    </table>
    <?php submit_button(); ?>
  </form>
</div>
