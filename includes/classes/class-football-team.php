<?php
/**
 * Football Team API
 *
 * @category   Components
 * @package    football-team
 * @author     Bogere Goldsoft
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt
 * @link       www.servicecops.com
 * @since      1.0.0
 */

namespace Football\Team;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 *  Football Team API 
 */
class FootballTeamAPI {
    
    /**
     * Class constructor
     */
    //public function __construct() {
    //    $this->add_hooks();
    //}

    public function init(){
        //$this->school_pay_handle_reset_password();
    }
    
    

   
    /**
     * Register the football team  in the db
     * 
     */
    public function bg_save_football_team_in_db(){
        global $wpdb;

        $teamName = $_POST['teamName'];
        $nickName = $_POST['nickName'];
        $teamHistory = $_POST['teamHistory'];
        $teamLeague = $_POST['teamLeague'];
        

        if (empty($teamName) || empty($nickName) || empty($teamHistory)  || empty($teamLeague)) {
            # code..
            $response = array(
                'success' => false,
                'message' => 'Please enter all required input fields'
             );

             wp_send_json_error($response);  
        }

        // error_log(print_r($wpdb->prefix,true));

        $table_name = $wpdb->prefix . "football_teams";
        //$wpdb->insert() automatically sanitizes the input data thus no need 
        //to sanitize the input data
        $teamName = sanitize_text_field($teamName);
        $nickName = sanitize_text_field($nickName);
        $teamHistory = sanitize_text_field($teamHistory);
        $teamLeague = sanitize_text_field($teamLeague);
                
        $wpdb->insert( 
            $table_name, 
            array( 
                'team_name' => $teamName, 
                'team_nickname' => $nickName,
                'team_logo' => 'helloLogo', 
                'team_history' => $teamHistory,
                'league_id' => $teamLeague
            ),
            array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%d'
            ) 
        );
  
        if($wpdb->insert_id){
            $response = array(
                    'success' =>true,
                    'message' => 'Added the football team successful'
            );
            wp_send_json_success($response);

        }else{

            $errorMessage =  $wpdb->last_error;

            $response = array(
                'success' => false,
                //'message' => 'Failed to add the football team'
                'message' => json_encode($errorMessage)
            );
            wp_send_json_error($response);
        }
    }

     /**
     * Register the football team league  in the db
     * 
     */
    public function bg_save_football_team_league_in_db(){
        global $wpdb;

        $leagueName = $_POST['leagueName'];
        $description = $_POST['description'];


        if (empty($leagueName) || empty($description) ) {
            # code..
            $response = array(
                'success' => false,
                'message' => 'Please enter all required input fields'
             );

             wp_send_json_error($response);  
        }


        $table_name = $wpdb->prefix . "football_league";
        $leagueName = sanitize_text_field($leagueName);
        $description = sanitize_text_field($description);
           
                
        $wpdb->insert( 
            $table_name, 
            array( 
                'name' => $leagueName, 
                'description' => $description, 
            ),
            array(
                '%s',
                '%s'
            ) 
        );


        if($wpdb->insert_id){
            $response = array(
                    'success' =>true,
                    'message' => 'Added the football league successful'
            );
            wp_send_json_success($response);

        }else{

            $errorMessage =  $wpdb->last_error;

            $response = array(
                'success' => false,
                'message' => 'Failed to add the football team league'
            );
            wp_send_json_error($response);
        }
    }


    /**
     * Register the football team league  in the db
     * 
     */
    public function bg_search_football_db(){
        global $wpdb;

        $searchInput = $_POST['searchInput'];


        if (empty($searchInput)  ) {
            # code..
            $response = array(
                'success' => false,
                'message' => 'Please the search input is required'
             );

             wp_send_json_error($response);  
        }


        $table_name = $wpdb->prefix . "football_teams";
        $searchInput = sanitize_text_field($searchInput);
            
        $search = $wpdb->esc_like( $searchInput );
        $search = "%{$search}%";

        // Build the where clause using $wpdb->prepare to prevent SQL injection attacks
        // Searching ALL THREE of our columns: Product, Application, Sector 
        //$where = $wpdb->prepare( 'WHERE Product LIKE %s OR Application LIKE %s OR Sector LIKE %s', $search, $search, $search );
        // Execute the query with our WHERE clause
        $where = $wpdb->prepare( 'WHERE team_name LIKE %s', $search );
        $searchResults = $wpdb->get_results( "SELECT *  FROM {$table_name} {$where}" );

        $response = array(
            'success' => true,
            'message' => json_encode($searchResults)
        );
        wp_send_json_success($response);

    }
           

}