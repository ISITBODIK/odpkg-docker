<?php
if ( !current_user_can( 'manage_options' ) )  {
  wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

$opt_name = 'odpkg_ga_tracking_id';
$hidden_field_name = 'odpkg_submit_hidden';
$opt_val = get_option( $opt_name );

if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
  $opt_val = $_POST[ $opt_name ];
  update_option( $opt_name, $opt_val );
?>
<div class="updated"><p><strong><?php echo __('Settings saved.'); ?></strong></p></div>
<?php
}
?>

<div class="wrap">
  <h2>Google Analytics 設定</h2>
  <p>Google Analytics のトラッキングIDを入力してください。</p>

  <form method="post" action="">
    <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

    <table class="form-table">
    <tr>
    <th scope="row"><label for="<?php echo $opt_name; ?>">トラッキングID</label></th>
    <td><input type="text" name="<?php echo $opt_name; ?>" id="<?php echo $opt_name; ?>"
               class="regular-text" value="<?php echo esc_attr( get_option($opt_name) ); ?>"></td>
    </tr>
    </table>

    <?php submit_button(); ?>
  </form>
</div>
