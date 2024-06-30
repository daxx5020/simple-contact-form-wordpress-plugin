<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

function scf_handle_contact_form_submission() {
    if (isset($_POST['simple_contact_submit'])) {
        // Verify nonce for security
        if (!isset($_POST['scf_nonce']) || !wp_verify_nonce($_POST['scf_nonce'], 'scf_contact_form')) {
            wp_die('Security check failed');
        }

        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $message = sanitize_textarea_field($_POST['message']);

        $errors = array();

        if (empty($name)) {
            $errors[] = 'Name is required.';
        }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'A valid email is required.';
        }
        if (empty($message)) {
            $errors[] = 'Message is required.';
        }

         // If there are validation errors, redirect back with error messages
         if (!empty($errors)) {
            $redirect_url = add_query_arg('message', 'error', wp_get_referer());
            $redirect_url = add_query_arg('errors', urlencode(json_encode($errors)), $redirect_url);
            wp_safe_redirect($redirect_url);
            exit;
        }

        $to = get_option('scf_recipient_email', get_option('admin_email'));
        $subject = 'New Contact Form Submission';
        $body = "Name: $name\n";
        $body .= "Email: $email\n";
        $body .= "Message: $message";

        $sent = wp_mail($to, $subject, $body);
        
        if ($sent) {
            error_log("Simple Contact Form: Email sent successfully to $to");
        } else {
            error_log("Simple Contact Form: Failed to send email to $to");
            global $ts_mail_errors;
            global $phpmailer;
            if (!isset($ts_mail_errors)) {
                $ts_mail_errors = array();
            }
            if (isset($phpmailer)) {
                $ts_mail_errors[] = $phpmailer->ErrorInfo;
            }
            error_log("Simple Contact Form: " . print_r($ts_mail_errors, true));
        }

        // Redirect to avoid form resubmission
        wp_safe_redirect(add_query_arg('message', $sent ? 'success' : 'error', wp_get_referer()));
        exit;
    }
}
add_action('init', 'scf_handle_contact_form_submission');