<?php
/*
Plugin Name: Simple Contact Form
Description: A basic contact form plugin that lets users send messages to the site owner.
Version: 1.0
Author: Daksh Makwana
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('SCF_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SCF_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include required files
require_once SCF_PLUGIN_DIR . 'includes/form-handler.php';
require_once SCF_PLUGIN_DIR . 'includes/shortcode.php';
require_once SCF_PLUGIN_DIR . 'includes/settings.php';

// Enqueue styles
function scf_enqueue_styles() {
    wp_enqueue_style('scf-styles', SCF_PLUGIN_URL . 'assets/css/style.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'scf_enqueue_styles');