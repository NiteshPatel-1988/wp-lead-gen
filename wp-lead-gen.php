<?php
/**
 * Plugin Name: WP Lead Generator
 * Description: A simple lead generation plugin to collect name and email, store in DB, and view in WP Admin.
 * Version: 1.0
 * Author: Nitesh Patel
 */

defined('ABSPATH') || exit;

register_activation_hook(__FILE__, 'wp_leadgen_install');
function wp_leadgen_install() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'leadgen';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        submitted datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

add_action('admin_menu', function() {
    add_menu_page('Lead Generator', 'Lead Generator', 'manage_options', 'wp-leadgen', 'wp_leadgen_admin_page');
});

function wp_leadgen_admin_page() {
    include plugin_dir_path(__FILE__) . 'admin-page.php';
}

add_action('wp_enqueue_scripts', function() {
    wp_enqueue_script('leadgen-js', plugin_dir_url(__FILE__) . 'leadgen.js', ['jquery'], null, true);
    wp_localize_script('leadgen-js', 'leadgen_obj', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('leadgen_nonce')
    ]);
});

add_shortcode('leadgen_form', function() {
    ob_start(); ?>
    <form id="leadgen-form">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <button type="submit">Submit</button>
    </form>
    <div id="leadgen-response"></div>
    <?php return ob_get_clean();
});

require_once plugin_dir_path(__FILE__) . 'ajax-handler.php';
?>
