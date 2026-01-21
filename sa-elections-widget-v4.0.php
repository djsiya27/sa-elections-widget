<?php
/*
Plugin Name: SA Elections Widget (v4.0 Hybrid)
Description: Hybrid elections widget: live IEC API mode + offline LGE2021 data. Includes a slider for top 6 parties.
Version: 4.0
Author: Siyabonga Majola
Text Domain: sa-elections-widget-v4
*/

if (!defined('ABSPATH')) exit;

define('SA_ELECTIONS_V4_DIR', plugin_dir_path(__FILE__));
define('SA_ELECTIONS_V4_URL', plugin_dir_url(__FILE__));

require_once SA_ELECTIONS_V4_DIR . 'includes/class-sa-elections-api.php';
require_once SA_ELECTIONS_V4_DIR . 'includes/class-sa-elections-offline.php';
require_once SA_ELECTIONS_V4_DIR . 'includes/class-sa-elections-slider.php';

// Shortcodes
add_shortcode('sa_elections_widget', ['SA_Elections_Widget', 'shortcode_live']);
add_shortcode('sa_elections_widget_lge2021', ['SA_Elections_Offline', 'shortcode_offline']);
add_shortcode('sa_elections_slider', ['SA_Elections_Slider', 'shortcode_slider']);

// Enqueue assets
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style('sa-elections-v4-style', SA_ELECTIONS_V4_URL . 'assets/css/style.css', [], '4.0');
    wp_enqueue_style('sa-elections-v4-slider', SA_ELECTIONS_V4_URL . 'assets/css/slider.css', [], '4.0');
    wp_enqueue_script('sa-elections-v4-js', SA_ELECTIONS_V4_URL . 'assets/js/script.js', ['jquery'], '4.0', true);
    wp_enqueue_script('sa-elections-v4-slider', SA_ELECTIONS_V4_URL . 'assets/js/slider.js', ['jquery'], '4.0', true);

    wp_localize_script('sa-elections-v4-js', 'saElectionsV4', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('sa_elections_nonce')
    ]);

    wp_localize_script('sa-elections-v4-slider', 'saElectionsSlider', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('sa_elections_nonce'),
        'cycle_regions' => ['National','Gauteng','KZN','Western Cape'],
        'cycle_interval' => 5000
    ]);
});
