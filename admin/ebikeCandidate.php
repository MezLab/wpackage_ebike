<?php
/**
 * Plugin Name:       WPackage HR
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Page Candidate
 * Version:           1.1
 * Requires PHP:      7
 * Author:            Mez
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
global $EBIKE_Candidate;

?>

  <?php echo ebike_section_top_myPlugIn( array("title" => "Anteprima Richiedente", "paragraph" => "Stai visualizzando i dati inseriti del richiedente")); ?>

  <?php $EBIKE_Candidate->set($_GET["id"]); ?>

  <div class="candidate">
    <div class="wrap">
        <label for="">Codice Utente</label>
        <p><?php echo $EBIKE_Candidate->getCode(); ?></p>
    </div>
    <div class="wrap">
      <label for="">Email</label>
      <p><?php echo $EBIKE_Candidate->getMail(); ?></p>
    </div>
  </div>
  <div class="ebike_candidate">
    <div class="cand_Preview">  
      <div class="data">
        <label>Dati Inseriti</label>
        <?php echo $EBIKE_Candidate->getData(); ?>
      </div>
    </div>
  </div>


