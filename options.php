<?php 
function pk_register_options_page() {
    add_options_page('ACF To WP API Options', 'ACF2WP API Options', 'manage_options', 'pk-acftoapi', 'pk_options_page');
  }
  add_action('admin_menu', 'pk_register_options_page');
 

  function pk_options_page(){
      
    global $wp_post_types;
    $post_types = array_keys( $wp_post_types );
    $post_types = array_diff($post_types,['attachment','revision','nav_menu_item','custom_css','customize_changeset','oembed_cache','user_request','wp_block','acf-field-group','acf-field']);
    ?>
<div class="wrap">
    <?php screen_icon(); ?>
    <h2>Options for ACF to WP Rest API</h2>
    <form method="post">
        <input type="hidden" name="pk_acfwpapi">
        <?php
        settings_fields("section-one");
        do_settings_sections("pk-acftoapi_settings");      
        submit_button(); 
        ?>
    </form>
</div>
<?php
}


if (isset($_POST['pk_acfwpapi'])) {
    $newfield       = $_POST['pk_acfwpapi_newfield'] ?? '';
    $newfieldname   = $_POST['pk_acfwpapi_newfield_name'] ?? '';
    update_option('pk_acfwpapi_newfield', sanitize_text_field($newfield));
    update_option('pk_acfwpapi_newfield_name', sanitize_text_field( $newfieldname) );
    add_action('admin_notices', 'pk_displayUpdatedNotice');

}


function displayNewFieldCheckbox(){?>
<input type="checkbox" id="pk_acfwpapi_newfield" name="pk_acfwpapi_newfield" value="1"
    <?php checked( get_option('pk_acfwpapi_newfield')); ?> />
<?php }

function displayNewFieldtexbox(){?>
<input type="text" id="pk_acfwpapi_newfield_name" name="pk_acfwpapi_newfield_name"
    value="<?php echo get_option('pk_acfwpapi_newfield_name') ?: 'acf'; ?>" />
<?php }




function pk_acfttoapi_fields()
{
	add_settings_section("section-one", "Settings", null, "pk-acftoapi_settings");
	
	add_settings_field("pk_acfwpapi_newfield", "Add a key to hold ACF fields in REST API response?", "displayNewFieldCheckbox", "pk-acftoapi_settings", "section-one");
    add_settings_field("pk_acfwpapi_newfield_name", "Key name for REST API response", "displayNewFieldtexbox", "pk-acftoapi_settings", "section-one");
}

add_action("admin_init", "pk_acfttoapi_fields");




    // display custom admin notice
    function pk_displayUpdatedNotice() { ?>

<div class="notice notice-success is-dismissible">
    <p>
        ACF To REST API settings saved!
    </p>
</div>

<?php }