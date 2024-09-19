<?php
//Theme Options 
$icon=get_bloginfo('template_url').'/images/admin_icon.png';
add_action('admin_menu', 'dz_create_menu');
function dz_create_menu() {
	add_menu_page('Theme Settings', 'Theme Options', 'administrator', __FILE__, 'dz_settings_page',$icon,1);
	add_action( 'admin_init', 'register_mysettings' );
}
function register_mysettings() {
	register_setting( 'dz-settings-group', 'name' );
	register_setting( 'dz-settings-group', 'logo' );
}
function dz_settings_page() {

?>
<div class="wrap">
<h2><b style="color:#848585;">&nbsp;&nbsp;L&P Theme Options</b></h2>
<form method="post" action="options.php">
    <?php settings_fields( 'dz-settings-group' ); ?>
    <table class="form-table">
    
        <tr valign="top">
        <th scope="row">Contact Name</th>
        <td><input size="95" type="text" name="name" value="<?php echo get_option('name'); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Logo</th>
        <td><input size="95" type="text" name="logo" value="<?php echo get_option('logo'); ?>" /></td>
        </tr>
        
        </table>
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
</form>
</div>
<?php } ?>