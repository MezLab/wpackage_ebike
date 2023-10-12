<?php
/**
 * Plugin Name:       WPackage HR
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Cerca Moduli
 * Version:           1.0
 * Requires PHP:      7
 * Author:            Mez
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */


if(isset($_GET['e_search_value'])){
  switch ($_GET['e_search_type']) {
    case 'IDcandidate':
      $EBIKE_Table->searchCodeEbike($_GET['e_search_value']);
      break;
    default:
      break;
  }
  
}else{
  $_GET['e_search_value'] = null;
}

?>