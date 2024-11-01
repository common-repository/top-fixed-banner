<?php
/*
Plugin Name: TopBanner
Plugin URI: https://avega.me/plugins
Description: Adds a fixed top banner with customizable text via custom fields.
Version: 1.0
Author: Andrés Vega
Author URI: https://avega.me/
Text Domain: topbanner
Domain Path: /languages
License: GPLv2 or later
*/

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Include the main class file.
require_once plugin_dir_path(__FILE__) . 'includes/classtopbanner.php';

// Initialize the plugin.
function topbanner_init() {
    $topbanner = new Topbanner();
    $topbanner->register_hooks();
}
add_action('plugins_loaded', 'topbanner_init');

// Activation and deactivation hooks.
register_activation_hook(__FILE__, array('Topbanner', 'activate'));
register_deactivation_hook(__FILE__, array('Topbanner', 'deactivate'));
