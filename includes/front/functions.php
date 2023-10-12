<?php
/**
 * Plugin Name:       WPackage HR
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Function Design Front End
 * Version:           1.1
 * Requires PHP:      7
 * Author:            Mez
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

/**
 * @param $x => array()
 * (Associazione => [h1, p])
 * Heading delle Pagine
 */

function ebike_section_top_myPlugIn($x = array()){
  $html_ = "<section class='header_wpckage_hr'>
              <div class='topLane'>
                <img src='" . plugin_dir_url(__DIR__) . "../admin/media/img/cube_admin.png' alt='Unsocials TheLaboratory'>
                <h2><b>WP</b>ackage Ebike<sup>unsocials&copy;</sup></h2>
              </div>
              <div class='midLane' style='margin-top:20px;'>
                <h3>" . $x["title"] . "</h3>
                <p>" . $x["paragraph"] . "</p>
              </div>  
            </section>";

  return $html_;
}
?>