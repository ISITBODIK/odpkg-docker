<?php
if ( !current_user_can( 'manage_options' ) )  {
  wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

$opt_web_name = 'odpkg_ckan_web';
$opt_api_name = 'odpkg_ckan_api';

$hidden_field_name = 'odpkg_submit_hidden';

$opt_web_val = get_option( $opt_web_name );
$opt_api_val = get_option( $opt_api_name );

if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
  $opt_web_val = $_POST[ $opt_web_name ];
  $opt_api_val = $_POST[ $opt_api_name ];
  update_option( $opt_web_name, $opt_web_val );
  update_option( $opt_api_name, $opt_api_val );
?>
<div class="updated"><p><strong><?php echo __('Settings saved.'); ?></strong></p></div>
<?php
}
?>

<div class="wrap">
  <h2>CKAN連携設定</h2>
  <p>CKANの情報を入力してください。</p>

  <form method="post" action="">
  <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
    <table class="form-table">
    <tr>
      <th scope="row"><label for="<?php echo $opt_web_name; ?>">CKAN Webサイト</label></th>
      <td><input type="text" name="<?php echo $opt_web_name; ?>" id="<?php echo $opt_web_name; ?>"
                 class="regular-text" value="<?php echo esc_attr( get_option($opt_web_name) ); ?>"></td>
    </tr>
    <tr>
      <th scope="row"><label for="<?php echo $opt_api_name; ?>">CKAN API</label></th>
      <td><input type="text" name="<?php echo $opt_api_name; ?>" id="<?php echo $opt_api_name; ?>"
                 class="regular-text" value="<?php echo esc_attr( get_option($opt_api_name) ); ?>"></td>
    </tr>
    </table>
  <?php submit_button(); ?>
  </form>
</div>
