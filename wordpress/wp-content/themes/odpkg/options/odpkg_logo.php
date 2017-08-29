<?php
if ( !current_user_can( 'manage_options' ) )  {
  wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

$opt_bg_name = 'odpkg_bg_url';
$opt_logo_name = 'odpkg_logo_url';

$hidden_field_name = 'odpkg_submit_hidden';

$opt_bg_val = get_option( $opt_bg_name );
$opt_logo_val = get_option( $opt_logo_name );

if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
  $opt_bg_val = $_POST[ $opt_bg_name ];
  $opt_logo_val = $_POST[ $opt_logo_name ];
  update_option( $opt_bg_name, $opt_bg_val );
  update_option( $opt_logo_name, $opt_logo_val );
?>
<div class="updated"><p><strong><?php echo __('Settings saved.'); ?></strong></p></div>
<?php
}
?>

<div class="wrap">
  <h2>背景/ロゴの設定</h2>
  <p>画像をアップロードすると、画像が自動的に変更されます。</p>
  <form method="post" action="">
    <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
    <table class="form-table">

    <tr>
    <th scope="row"><label for="<?php echo $opt_bg_name; ?>"><?php _e('◎カスタム背景のURL'); ?></label></th>
    <td>
      <input type="text" name="<?php echo $opt_bg_name; ?>" id="<?php echo $opt_bg_name; ?>" size="80"
            value="<?php echo esc_attr( get_option($opt_bg_name) ); ?>"/>　（http://〜）
    </td>
    </tr>

    <tr>
    <th scope="row"><label for="<?php echo $opt_logo_name; ?>"><?php _e('◎カスタムロゴのURL'); ?></label></th>
    <td>
      <input type="text" name="<?php echo $opt_logo_name; ?>" id="<?php echo $opt_logo_name; ?>" size="80"
            value="<?php echo esc_attr( get_option($opt_logo_name) ); ?>"/>　（http://〜）
    </td>
    </tr>

    <tr>
    <th></th>
    <td>
      <p>
      <a href="<?php bloginfo('url'); ?>/wp-admin/media-new.php" target="_blank" rel="noopener noreferrer">画像をアップロード</a><br>
      ＊背景サイズ：横幅1920px 高さ300px ファイル：jpg<br>
      ＊ロゴサイズ：横幅600px 高さ200px ファイル：png<br>
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
      ＜現在の背景＞<br>
      <img src="<?php echo esc_attr( get_option($opt_bg_name) ) ? get_option($opt_bg_name) : get_template_directory_uri() . '/images/bgimg.jpg'; ?>" style="max-width:800px;">
      </p>
      <p>
      ＜現在のロゴ＞<br>
      <img src="<?php echo esc_attr( get_option($opt_logo_name) ) ? get_option($opt_logo_name) : get_template_directory_uri() . '/images/logo.png'; ?>" style="max-width:600px;">
      </p>
    </td>
    </tr>

    </table>
    <?php submit_button(); ?>
  </form>
</div>
