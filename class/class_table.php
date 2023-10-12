<?php

/**
 * Plugin Name:       WPackage Ebike
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Class Table
 * Version:           1.1
 * Requires PHP:      7
 * Author:            Mez
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
global $EBIKE_Candidate;

class EBIKE_Table
{

  /* ----------------- */
  /** PROPERTY */
  /* ----------------- */


  /* ----------------- */
  /** METHOD */
  /* ----------------- */

  function __construct(){}

  //--------------------------------------------

    /**
   * Visualizzazione di tutti i candidati
   * Tabella CANDIDATE
   */
  public function get_table_candidate($page, $status){
    global $wpdb;
    $forms = "";

    $postPerPage = 100;
    $number = $page * $postPerPage;
    $date;
    $color_receipt;
    $color_ci;

    $queryData = $wpdb->get_results("select data_user from wpackage_ebike_candidate", ARRAY_A);
    
    if($status == "all"){
      $queryTot = $wpdb->get_results("select * from wpackage_ebike_candidate", ARRAY_A);
      $query = $wpdb->get_results("select * from wpackage_ebike_candidate limit " . $number . ", " . $postPerPage, ARRAY_A);
    }else{
      $queryTot = $wpdb->get_results("select * from wpackage_ebike_candidate where status = '" . $status . "'", ARRAY_A);
      $query = $wpdb->get_results("select * from wpackage_ebike_candidate where status = '" . $status . "' limit " . $number . ", " . $postPerPage, ARRAY_A);
    }


    for($a = 0; $a < count($query); $a++){

      $jSonDecode = json_decode($query[$a]["data_user"]);

      // Calcolatore Data di scadenza
      // quietanza alla consegna
      if($query[$a]["receipt"] && $query[$a]["ci"]){
        $ggTotal = "";
      }else{
        /** Variabili Iniziali */
        $Published = new DateTime("now");
        $DeadLine = new DateTime($query[$a]["date_limit"]);
        /** */
        $ggTotal = $Published->diff($DeadLine); // gg trascorsi dalla pubblicazione fino alla scadenza

        if(new DateTime("now") > new DateTime($query[$a]["date_limit"])){
          $wpdb->update( 'wpackage_ebike_candidate', array('status' => 'scaduto'), array( 'id' => $queryTot[$a]["id"] ) );
          $ggTotal = $ggTotal->format('<span style="color: red;" class="gg"> [ %a giorni ]</span>');
        }else{
          $ggTotal = $ggTotal->format('<span style="color: green;" class="gg"> [ %a giorni ]</span>');
        }
      }

      
      
      // Inserimento colore in base 
      // al file inviato
      ($query[$a]["receipt"]) ? $color_receipt = "#04aa6b" : $color_receipt = "#ed503d";
      ($query[$a]["ci"]) ? $color_ci = "#04aa6b" : $color_ci = "#ed503d";

      $forms .= '<tr>
                  <td>
                    <a class="" href="' . ebike_url_my_path() . 'wp-admin/admin.php?page=view_candidate_ebike&id=' . $query[$a]["id"] . '">
                      <i style="color:#2d2d2d" class="fa fa-open fa-fw"></i>
                    </a>
                  </td>
                  <td>
                    <a class="tooltipMenu" href="' . ebike_url_my_path() . 'wp-admin/admin.php?page=admin_candidate_ebike_page&candidate=accept&id=' . $query[$a]["id"] . '">
                      <i style="color:#04aa6b" class="fa fa-circle"></i>
                      <span class="">Accetta</span>
                    </a>
                    <a class="tooltipMenu" href="' . ebike_url_my_path() . 'wp-admin/admin.php?page=admin_candidate_ebike_page&candidate=rejected&id=' . $query[$a]["id"] . '">
                      <i style="color:#ed503d" class="fa fa-circle"></i>
                      <span class="">Respingi</span>
                    </a>
                    <a class="tooltipMenu" href="' . ebike_url_my_path() . 'wp-admin/admin.php?page=admin_candidate_ebike_page&candidate=pending&id=' . $query[$a]["id"] . '">
                      <i style="color:grey" class="fa fa-circle"></i>
                      <span class="">In Attesa</span>
                    </a>
                  </td>
                  <td>' . $query[$a]["code"] . '</td>
                  <td>' . $jSonDecode->{"nome"} . '</td>
                  <td>' . $jSonDecode->{"cognome"} . '</td>
                  <td>' . $query[$a]["mail"] . '</td>
                  <td>' . $query[$a]["date"] . $ggTotal . '</td>
                  <td>
                    <a class="tooltipMenu" href="' . ebike_url_my_path() . 'wp-admin/admin.php?page=admin_candidate_ebike_page&candidate=ci&id=' . $query[$a]["id"] . '">
                      <i style="color:'. $color_ci .'" class="fa fa-file-o"></i>
                      <span class="">C.I.</span>
                    </a>
                    <a class="tooltipMenu" href="' . ebike_url_my_path() . 'wp-admin/admin.php?page=admin_candidate_ebike_page&candidate=receipt&id=' . $query[$a]["id"] . '">
                      <i style="color:'. $color_receipt .'" class="fa fa-file-o"></i>
                      <span class="">Fattura</span>
                    </a>
                  </td>
                </tr>';
    };

    return "<table id='myTable' class='myTable ebike'>
              <thead>
                <tr>
                  <td><i class='fa fa-cog4 fa-1x fa-fw'></i></td>
                  <td>Richiesta</td>
                  <td>Codice Richiedente</td>
                  <td>Nome</td>
                  <td>Cognome</td>
                  <td>Mail</td>
                  <td>Invio Richiesta</td>
                  <td>Allegati</td>
                </tr>
              </thead>
              <tbody>
                $forms
              </tbody>
            </table>" . $this->perPagePost($page, $number, count($query), count($queryTot), "admin.php?page=admin_candidate_ebike_page", $postPerPage);
            
  }


  //--------------------------------------------

  /**
   * Visualizzazione Totale Inseriti
   */
  public function getTotal(string $tableDB){
    global $wpdb;

    $query = $wpdb->get_results("select * from " . $tableDB, ARRAY_A);

    return count($query);
  }


  /**
   * Page for Post
   */

   public function perPagePost($page, $num, $limit, $total, $link, $perPage){

    $ppp = "<div class='perPages'><span>" . ($num + 1) . " - " . ($num + $limit) . " di <b>(" . $total . " elementi)</b></span>";

    if($num == 0){
      $ppp .= "<a style='opacity:0.5;' class='pageLink' href='javascript:void(0)'><i class='fa fa-chevron-left fa-fw'></i></a>";
    }else{
      $ppp .= "<a class='pageLink' href='" . $link . "&pages=" . ($page - 1) . "'><i class='fa fa-chevron-left fa-fw'></i></a>";
    }
    
    if(($page+1) > ($total/$perPage)){
      $ppp .= "<a style='opacity:0.5;' class='pageLink' href='javascript:void(0)'><i class='fa fa-chevron-right fa-fw'></i></a>";
    }else{
      $ppp .= "<a class='pageLink' href='" . $link . "&pages=" . ($page + 1) . "'><i class='fa fa-chevron-right fa-fw'></i></a>";
    }

    $ppp .= "</div>";

    return $ppp;

   }


   //--------------------------------------------

  /**
   * Cerca Candidato
   * nel DATABASE 
   * in base a Codice Pratica
   */
  public function searchCodeEbike($code){
    global $wpdb;
    $forms = "";

    $query = $wpdb->get_results("select * from wpackage_ebike_candidate where code like '%" . $code . "%'", ARRAY_A);

    if(!is_null($query)){
      if(count($query) == 0){
        echo '<p class="alertSearch">Nessun Richiedente Trovato</p>';
      }else{
        for($a = 0; $a < count($query); $a++){

          $jSonDecode = json_decode($query[$a]["data_user"]);

          // Calcolatore Data di scadenza
          // quietanza alla consegna
          if($query[$a]["receipt"] && $query[$a]["ci"]){
            $ggTotal = "";
          }else{
            /** Variabili Iniziali */
            $Published = new DateTime("now");
            $DeadLine = new DateTime($query[$a]["date_limit"]);
            /** */
            $ggTotal = $Published->diff($DeadLine); // gg trascorsi dalla pubblicazione fino alla scadenza

            if(new DateTime("now") > new DateTime($query[$a]["date_limit"])){
              $wpdb->update( 'wpackage_ebike_candidate', array('status' => 'scaduto'), array( 'id' => $queryTot[$a]["id"] ) );
              $ggTotal = $ggTotal->format('<span style="color: red;" class="gg"> [ %a giorni ]</span>');
            }else{
              $ggTotal = $ggTotal->format('<span style="color: green;" class="gg"> [ %a giorni ]</span>');
            }
          }

          
          
          // Inserimento colore in base 
          // al file inviato
          ($query[$a]["receipt"]) ? $color_receipt = "#04aa6b" : $color_receipt = "#ed503d";
          ($query[$a]["ci"]) ? $color_ci = "#04aa6b" : $color_ci = "#ed503d";

          $forms .= '<tr>
                      <td>
                        <a class="" href="' . ebike_url_my_path() . 'admin.php?page=view_candidate_ebike&id=' . $query[$a]["id"] . '">
                          <i style="color:#2d2d2d" class="fa fa-open fa-fw"></i>
                        </a>
                      </td>
                      <td>
                        <a class="tooltipMenu" href="' . ebike_url_my_path() . 'admin.php?page=admin_candidate_ebike_page&candidate=accept&id=' . $query[$a]["id"] . '">
                          <i style="color:#04aa6b" class="fa fa-circle"></i>
                          <span class="">Accetta</span>
                        </a>
                        <a class="tooltipMenu" href="' . ebike_url_my_path() . 'admin.php?page=admin_candidate_ebike_page&candidate=rejected&id=' . $query[$a]["id"] . '">
                          <i style="color:#ed503d" class="fa fa-circle"></i>
                          <span class="">Respingi</span>
                        </a>
                      </td>
                      <td>' . $query[$a]["code"] . '</td>
                      <td>' . $jSonDecode->{"nome"} . '</td>
                      <td>' . $jSonDecode->{"cognome"} . '</td>
                      <td>' . $query[$a]["mail"] . '</td>
                      <td>' . $query[$a]["date"] . $ggTotal . '</td>
                      <td>
                        <a class="tooltipMenu" href="' . ebike_url_my_path() . 'admin.php?page=admin_candidate_ebike_page&candidate=ci&id=' . $query[$a]["id"] . '">
                          <i style="color:'. $color_ci .'" class="fa fa-file-o"></i>
                          <span class="">C.I.</span>
                        </a>
                        <a class="tooltipMenu" href="' . ebike_url_my_path() . 'admin.php?page=admin_candidate_ebike_page&candidate=receipt&id=' . $query[$a]["id"] . '">
                          <i style="color:'. $color_receipt .'" class="fa fa-file-o"></i>
                          <span class="">Fattura</span>
                        </a>
                      </td>
                    </tr>';
            
            echo $forms;

        }
      }
    }
  }

}


$EBIKE_Table = new EBIKE_Table();