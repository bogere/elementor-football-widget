<?php
/**
 * Plugin Name: Football Team Elementor Extension
 * Description: Plugin for managing football/sports teams categorized by the league they are from and list them with a custom-made Elementor widget. 
 * Plugin URI:        https://www.kazilab.com/
 * Description:       Plugin for managing football/sports teams categorized by the league they are from and list them with a custom-made Elementor widget. 
 * Version:           1.0.0
 * Author:            Bogere Goldsoft
 * Author URI:        https://github.com/bogere
 * Requires PHP:      5.4
 */


if ( ! defined( 'ABSPATH' ) ) exit;
define('ECW_PLUGIN_PLUGIN_PATH', plugin_dir_path( __FILE__ ));
define( 'ECW_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
define ('ECW_PLUGIN_FILE', __FILE__);

// plug it in
add_action('plugins_loaded', 'ecw_require_files');
function ecw_require_files() {
    require_once ECW_PLUGIN_PLUGIN_PATH.'modules.php';
}


// enqueue your custom style/script as your requirements
//add_action( 'wp_enqueue_scripts', 'ecw_enqueue_styles', 25);
// function ecw_enqueue_styles() {
//     wp_enqueue_style( 'elementor-custom-widget-editor', ECW_PLUGIN_DIR_URL . 'assets/css/editor.css');
// }


 /**
* Include required files
 */
function includes() {
    require_once ECW_PLUGIN_PLUGIN_PATH . '/includes/classes/class-football-team.php';
    require_once ECW_PLUGIN_PLUGIN_PATH . '/includes/views/admin/football_team_list.php';
    require_once ECW_PLUGIN_PLUGIN_PATH . '/includes/views/admin/football_team_league_list.php';
    require_once ECW_PLUGIN_PLUGIN_PATH . '/includes/class-hook-registry.php';
}

includes();

