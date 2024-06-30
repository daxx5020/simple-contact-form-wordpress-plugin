<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

function scf_display_message() {
    if (isset($_GET['message']) && $_GET['message'] === 'error') {
        $errors = isset($_GET['errors']) ? json_decode(stripslashes(urldecode($_GET['errors'])), true) : [];
        if ($errors && is_array($errors)) {
            $error_output = '<div class="error-message-container"><div class="scf-message scf-error">';
            foreach ($errors as $error) {
                $error_output .= '<div class="scf-error-item">' . esc_html($error) . '</div>';
            }
            $error_output .= '</div></div>';
            return $error_output;
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
            <input type="text" name="name" id="name" >
        </div>
        <div class="scf-form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" >
        </div>
        <div class="scf-form-group">
            <label for="message">Message:</label>
            <textarea name="message" id="message" ></textarea>
        </div>
        <div class="scf-form-group">
            <input type="submit" name="simple_contact_submit" value="Send">
        </div>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('simple_contact_form', 'scf_contact_form_shortcode');