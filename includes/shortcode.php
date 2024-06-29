<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

function scf_display_message() {
    if (isset($_GET['message'])) {
        if ($_GET['message'] === 'success') {
            return '<div class="scf-message-wrapper"><div class="scf-message scf-success">Your message has been sent successfully!</div></div>';
        } elseif ($_GET['message'] === 'error') {
            return '<div class="scf-message-wrapper><div class="scf-message scf-error">There was an error sending your message. Please try again later.</div></div>';
        }
    }
    return '';
}


function scf_contact_form_shortcode() {
    $message = scf_display_message();
    ob_start();
    echo $message;
    ?>
    <form method="post" action="" class="scf-form">
        <?php wp_nonce_field('scf_contact_form', 'scf_nonce'); ?>
        <div class="scf-form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>
        </div>
        <div class="scf-form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="scf-form-group">
            <label for="message">Message:</label>
            <textarea name="message" id="message" required></textarea>
        </div>
        <div class="scf-form-group">
            <input type="submit" name="simple_contact_submit" value="Send">
        </div>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('simple_contact_form', 'scf_contact_form_shortcode');