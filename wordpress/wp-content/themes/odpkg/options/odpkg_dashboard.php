<?php
if ( !current_user_can( 'manage_options' ) )  {
  wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

$opt_dashboard_name = 'odpkg_dashboard_web';

$hidden_field_name = 'odpkg_submit_hidden';

$opt_dashboard_val = get_option( $opt_dashboard_name );

if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
  $opt_dashboard_val = $_POST[ $opt_dashboard_name ];
  update_option( $opt_dashboard_name, $opt_dashboard_val );
?>
<div class="updated"><p><strong><?php echo __('Settings saved.'); ?></strong></p></div>
<?php
}
?>

<div class="wrap">
  <h2>ダッシュボード連携設定</h2>
  <p>ダッシュボードの情報を入力してください。</p>

  <form method="post" action="">
  <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
    <table class="form-table">
    <tr>
      <th scope="row"><label for="<?php echo $opt_dashboard_name; ?>">ダッシュボード URL</label></th>
      <td><input type="text" name="<?php echo $opt_dashboard_name; ?>" id="<?php echo $opt_dashboard_name; ?>"
                 class="regular-text" value="<?php echo esc_attr( get_option($opt_dashboard_name) ); ?>"></td>
    </tr>
    </table>
  <?php submit_button(); ?>
  </form>
</div>
