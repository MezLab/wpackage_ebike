<?php
/**
 * Plugin Name:       WPackage Ebike
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Functions
 * Version:           1.1
 * Requires PHP:      7
 * Author:            Mez
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

/**
 * Aggiunge il 
 * menu principale 
 * nella barra di sinistra
 */
function ebike_admin_menu(){

   add_menu_page(
     'WPackage | Ebike', // Page Title
     'WPackage | Ebike', // Menu Title
     'manage_options', // Capability
     'wpackage_ebike', // Menu Slug
     'login_ebike_page', // Callback => login_ebike_page()
     plugin_dir_url(__FILE__) . '../../admin/media/img/cube_min.png', // Icon URL
     5 // Position
   );
  
 }

 add_action('admin_menu', 'ebike_admin_menu'); 

/**
 * Richiama il file PHP "admin/login.php"
 * Callback => login_ebike_page()
 */
 function login_ebike_page(){
   require plugin_dir_path(__FILE__) . '../../admin/candidate.php';
 }


// <>-<>-<>-<>-<>-<>-<>-<>-<>-<>-<>-<>- //

/**
 * Aggiunge la voce
 * di sottomenu per 
 * la gestione dei candidati
 */

function ebike_candidate(){

   add_submenu_page(
     'wpackage_ebike', // Parent Menu Slug
     'Candidati', // Page Title
     'Candidati', // Menu Title
     'manage_options', // Capability
     'admin_candidate_ebike_page', // Menu Slug
     'candidate_ebike_page', // Callback => candidate_ebike_page()
     2 // Position
   );
  
 }

 add_action('admin_menu', 'ebike_candidate');

/**
 * Richiama il file PHP "admin/module.php"
 * Callback => candidate_ebike_page()
 */
 function candidate_ebike_page(){
   require_once plugin_dir_path(__FILE__) . '../../admin/candidate.php';
 }


// <>-<>-<>-<>-<>-<>-<>-<>-<>-<>-<>-<>-<> //



/**
 * Aggiunge la voce
 * per la gestione di
 * registrazione candidati
 */

function ebike_register(){

   add_submenu_page(
     'admin_candidate_ebike_page', // Parent Menu Slug
     'Registrazione Candidati', // Page Title
     'Registrazione Candidati', // Menu Title
     'manage_options', // Capability
     'admin_mailSend', // Menu Slug
     'register_ebike_page', // Callback => register_ebike_page()
     2 // Position
   );
  
 }

 add_action('admin_menu', 'ebike_register');

/**
 * Richiama il file PHP "admin/module.php"
 * Callback => register_ebike_page()
 */
 function register_ebike_page(){
   require_once plugin_dir_path(__FILE__) . '../../admin/mail.php';
 }


// <>-<>-<>-<>-<>-<>-<>-<>-<>-<>-<>-<>- //


/**
 * Visione 
 * singolo candidato
 */

function view_candidate_ebike(){

   add_submenu_page(
     'admin_candidate_ebike_page', // Parent Menu Slug
     'Visione Candidato', // Page Title
     'Visione Candidato', // Menu Title
     'manage_options', // Capability
     'view_candidate_ebike', // Menu Slug
     'view_candidate_ebike_page', // Callback => view_candidate_ebike_page()
     2 // Position
   );
  
 }

 add_action('admin_menu', 'view_candidate_ebike');

/**
 * Richiama il file PHP "admin/module.php"
 * Callback => view_candidate_ebike_page()
 */
 function view_candidate_ebike_page(){
   require_once plugin_dir_path(__FILE__) . '../../admin/ebikeCandidate.php';
 }

 // <>-<>-<>-<>-<>-<>-<>-<>-<>-<>-<>-<>-<> //


/**
 * Aggiunge i file
 * CSS & JS
 * Style Plugin
 */
    
function wpackage_ebike_all_styles(){

  wp_enqueue_style(
    'wpackage_ebike_css',
    plugins_url('../../library/css/style.css', __FILE__)
  );

  wp_enqueue_script(
    'wpackage_ebike_js',
    plugins_url('../../library/js/script.js', __FILE__),
    array(),
    '1.0.0',
    true
  );
}

add_action( 'admin_enqueue_scripts', 'wpackage_ebike_all_styles');