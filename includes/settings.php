<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

function scf_settings_page() {
    add_options_page('Simple Contact Form Settings', 'Simple Contact Form', 'manage_options', 'simple-contact-form', 'scf_settings_page_content');
}
add_action('admin_menu', 'scf_settings_page');

function scf_settings_page_content() {
    ?>
    <div class="wrap">
        <h1>Simple Contact Form Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('scf_settings');
            do_settings_sections('scf_settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function scf_settings_init() {
    register_setting('scf_settings', 'scf_recipient_email');

    add_settings_section('scf_settings_section', 'Email Settings', null, 'scf_settings');

    add_settings_field('scf_recipient_email', 'Recipient Email', 'scf_recipient_email_callback', 'scf_settings', 'scf_settings_section');
}
add_action('admin_init', 'scf_settings_init');

function scf_recipient_email_callback() {
    $recipient = get_option('scf_recipient_email', get_option('admin_email'));
    echo '<input type="email" name="scf_recipient_email" value="' . esc_attr($recipient) . '">';
}