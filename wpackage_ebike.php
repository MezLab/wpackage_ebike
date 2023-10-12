<?php
/**
 * Plugin Name:       WPackage Ebike
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Gestione Incentivi Ebike
 * Version:           1.0
 * Requires PHP:      7
 * Author:            Mez
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

if(!defined('ABSPATH'))exit;

/** Funzionalità */
// BACK
require(plugin_dir_path(__FILE__) . 'includes/back/wp_function.php');
require(plugin_dir_path(__FILE__) . 'includes/back/ebike_function.php');
// FRONT
require(plugin_dir_path(__FILE__) . 'includes/front/functions.php');
/** CLASSI */
require(plugin_dir_path(__FILE__) . 'class/class_candidate.php');
require(plugin_dir_path(__FILE__) . 'class/class_table.php');
/** ShortCode */
require(plugin_dir_path(__FILE__) . 'includes/back/shortcode.php');
/** Search */
require(plugin_dir_path(__FILE__) . 'admin/e_search.php');
?>