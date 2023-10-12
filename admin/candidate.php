<?php
/**
 * Plugin Name:       WPackage Ebike
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Gestione Candidati
 * Version:           1.1
 * Requires PHP:      7
 * Author:            Mez
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

global $EBIKE_Table;
global $EBIKE_Candidate;

if(!isset($_GET["pages"])){
  $_GET["pages"] = 0;
}

if(!isset($_GET["candidate"])){
  $_GET["candidate"] = 'default';
}

?>

  <?php
    switch ($_GET["candidate"]) {
      case 'accept':
        $EBIKE_Candidate->modifyCandidate($_GET["id"], array("status" => "approvato"));
        redirect_Ebike();
        break;
      case 'rejected':
        $EBIKE_Candidate->modifyCandidate($_GET["id"], array("status" => "respinto"));
        redirect_Ebike();
        break;
      case 'pending':
        $EBIKE_Candidate->modifyCandidate($_GET["id"], array("status" => "attesa"));
        redirect_Ebike();
        break;
      case 'ci':
      case 'receipt':
        $EBIKE_Candidate->modifyFile($_GET["id"], array("file" => $_GET["candidate"]));
        redirect_Ebike();
        break;
      default:
        # code...
        break;
    }
  ?>

  <?php echo ebike_section_top_myPlugIn( array("title" => "Richiedenti", "paragraph" => "Gestione dei richiedenti")); ?>
    <p><b>Richiedenti </b> (<?php echo $EBIKE_Table->getTotal('wpackage_ebike_candidate'); ?>)</p>
    <div class="wrapper">
      <div class="sel_">
        <span>
          <div>
            <a class="downloadExcel" href="https://www.infomobility.pr.it/wp-content/plugins/wpackage_ebike/admin/excel.php">Scarica</a>
          </div>
        </span>
        <span>
          <div class="buttonWrapper">
            <button class="tab-button" data-id="all">Tutti</button>
            <button class="tab-button" data-id="approved">Approvate</button>
            <button class="tab-button active" data-id="pending">In Attesa</button>
            <button class="tab-button" data-id="expired">Scadute</button>
            <button class="tab-button" data-id="rejected">Respinte</button>
          </div>
        </span>
      </div>
      <div class="contentWrapper">
        <div class="content" id="all">
          <div class="sel_">
            <span>
              <div>
                <input type="search" name="search" id="" placeholder="Cerca Codice Richiedente" onkeyup="e_searchDB('IDcandidate')">
                <i style="color:#1d2327" class="fa fa-search fa-fw"></i>
              </div>
            </span>
          </div>
          <?php echo $EBIKE_Table->get_table_candidate($_GET["pages"], "all"); ?>
        </div>
        <div class="content" id="approved">
          <?php echo $EBIKE_Table->get_table_candidate($_GET["pages"], "approvato"); ?>
        </div>
        <div class="content active" id="pending">
          <?php echo $EBIKE_Table->get_table_candidate($_GET["pages"], "attesa"); ?>      </div>
        <div class="content" id="expired">
          <?php echo $EBIKE_Table->get_table_candidate($_GET["pages"], "scaduto"); ?>
        </div>
        <div class="content" id="rejected">
          <?php echo $EBIKE_Table->get_table_candidate($_GET["pages"], "respinto"); ?>
        </div>
      </div>
    </div>