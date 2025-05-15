<?php
add_action('wp_ajax_leadgen_submit', 'leadgen_submit');
add_action('wp_ajax_nopriv_leadgen_submit', 'leadgen_submit');

function leadgen_submit() {
    check_ajax_referer('leadgen_nonce', 'nonce');
    global $wpdb;
    $table = $wpdb->prefix . 'leadgen';
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $wpdb->insert($table, ['name' => $name, 'email' => $email]);
    wp_send_json_success('Thank you! Your lead has been submitted.');
}
?>
