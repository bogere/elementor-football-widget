<?php


/**
 * Hook registry
 *
 * @category   Components
 * @package    football-team
 * @author     Bogere Goldsoft
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt
 * @link       kazilab.com
 * @since      1.0.0
 */

namespace Football\Team;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * General hook registry
 */
class Hook_Registry {

    /**
     * Class constructor
     */
    public function __construct() {
        $this->add_hooks();
    }

    /**
     * Add all hooks
     */
    private function add_hooks() {

        //Enqueue Styles and Scripts
        //works on the frontend
        add_action( 'wp_enqueue_scripts', [ $this, 'bg_load_custom_scripts']);
        //works only on backend.
        add_action('admin_enqueue_scripts', [ $this, 'bg_load_custom_scripts']);
        
        // //admin menu..
	    add_action( 'admin_menu', array( $this, 'bg_add_admin_menu_page' ), 99 );
        

        add_action('wp_ajax_register_football_team_action', [$this, 'bg_register_football_teams']);
        add_action('wp_ajax_register_football_league_action', [$this,'bg_register_football_league']);

        //search the team data..
        add_action('wp_ajax_search_team_action', [$this, 'bg_search_football_team']);
        add_action('wp_ajax_nopriv_search_team_action', [$this, 'bg_search_football_team']);

         //dealing with plugin activation
        register_activation_hook(ECW_PLUGIN_FILE, [$this, 'bg_create_football_team_tables']);
         //Actions.

        register_deactivation_hook(ECW_PLUGIN_FILE, [$this, 'bg_drop_tables_after_deactivation']); 
    }


    public function bg_load_custom_scripts (){
        //wp_enqueue_style( 'football-bootstrap', '//stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' );
        wp_enqueue_style( 'football-bootstrap', ECW_PLUGIN_DIR_URL.'assets/css/bootstrap.min.css' );
        wp_enqueue_style('football-team-css', ECW_PLUGIN_DIR_URL.'assets/css/football-team.css', array('football-bootstrap') );
        wp_enqueue_script('football-team-js', ECW_PLUGIN_DIR_URL.'assets/js/football-team.js', array('jquery'));
        wp_localize_script( 'football-team-js', 'siteData',
             array( 
             'ajaxurl' => admin_url( 'admin-ajax.php' ),
             'data_var_1' => 'value 1',
             'data_var_2' => 'value 2',
        )
       );
    }

   


    public function bg_register_football_teams(){
        $football = new FootballTeamAPI();
        $football->bg_save_football_team_in_db();
    }


    public function bg_register_football_league(){
        $football = new FootballTeamAPI();
        $football->bg_save_football_team_league_in_db();
    }

    public function bg_search_football_team(){
        $football = new FootballTeamAPI();
        $football->bg_search_football_db();
    }



     /*
        *  Check if the parent plugin is activated.
        */
    public function after_plugin_is_activated(){
            
        //register the config options for codeable site
        update_option(FOOTBALL_TEAM_OPTIONS_KEY, 'no-expired-sites' );  

    }

   

    public function bg_create_football_team_tables(){
        global $wpdb;
        $team_table = $wpdb->prefix . "football_teams";
        $league_table = $wpdb->prefix . "football_league";
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $team_table (
               id mediumint(9) NOT NULL AUTO_INCREMENT,
               team_name varchar(50) NOT NULL,
               team_nickname varchar(50) NOT NULL,
               team_logo varchar(50) NOT NULL,
               team_history varchar(50) NOT NULL,
               league_id smallint(5) NOT NULL,
               PRIMARY KEY  (id)
             ) $charset_collate;
             CREATE TABLE $league_table (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                name varchar(50) NOT NULL,
                description varchar(50) NOT NULL,
                PRIMARY KEY (id)
             ) $charset_collate";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    public function bg_drop_tables_after_deactivation() {
        global $wpdb;
        $teamTable = $wpdb->prefix . "football_teams";
        $leagueTable = $wpdb->prefix . "football_leagues";
        
        $dropTables = array($teamTable, $leagueTable);

        foreach ( $dropTables as $table ) {
            $wpdb->query( "DROP TABLE IF EXISTS {$table}" );
        }
    }


    /**
     * Add page to admin menu
     */
    public function bg_add_admin_menu_page() {
        // add_menu_page('Theme page title', 'Theme menu label', 'manage_options', 'theme-options', 'wps_theme_func');
        add_menu_page(
            'Football Teams', //page title'
            'Football Teams', //'menu label'
            'manage_options',  //capabilities
            'football_team', ////menu slug
            //null,
            'bg_display_football_team_list',
            'dashicons-groups',
            55.5
        );
        add_submenu_page(
            'football_team',
            'Football Leagues',
            'Football Leagues',
            'manage_options',
            'add_football_team',
            'bg_display_football_team_league_list'
        );
    }

}

new Hook_Registry();
