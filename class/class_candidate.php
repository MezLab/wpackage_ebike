<?php

/**
 * Plugin Name:       WPackage HR
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Class Candidate
 * Version:           1.2
 * Requires PHP:      7
 * Author:            Mez
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

class EBIKE_Candidate
{
  /* ----------------- */
  /** PROPERTY */
  /* ----------------- */

  /** Codice del richiedente */
  public $code;

  /** Email del richiedente */
  public $mail;

  /** Dati del richiedente*/
  public $data;

  /* ----------------- */
  /** METHOD */
  /* ----------------- */

  //--------------------------------------------


  /**
   * Codice del richiedente
   */
  public function getCode(){
    return $this->code;
  }

  /**
   * Mail del richiedente
   */
  public function getMail(){
    return $this->mail;
  }

  /**
   * Dati in txt del richiedente
   */
  public function getData(){
    return $this->data;
  }

  //--------------------------------------------

  /**
   * Path file allegato del candidato
   */
  public function set($id){

    global $wpdb;
    $_data = '';

    $query = $wpdb->get_results("select * from wpackage_ebike_candidate where id=$id ;", ARRAY_A);

    $this->code = $query[0]['code'];
    $this->mail = $query[0]['mail'];

    $jSonDecode = json_decode($query[0]["data_user"]);
    foreach ($jSonDecode as $key => &$value) {
      $_data .= "<tr><td>" . $key . "</td><td>" . $value . "</td></tr>";
    }

    $this->data = "<table>" . $_data . "</table>";
  }


  //--------------------------------------------

  /**
   * Crea il Codice 
   * identificativo del candidato
   */
  public function setCode(){

    global $wpdb;
    //variabili di codifica codice
    $name_module = "EB";
    $anno = date('y');

    
    $query = $wpdb->get_results("select * from wpackage_ebike_candidate", ARRAY_A);
    $pos_candidate = count($query) + 12;

   if($pos_candidate >= 10 && $pos_candidate <= 99){
      $pos_ = "00" . strval($pos_candidate);  
    }else if($pos_candidate >= 100 && $pos_candidate <= 999){
      $pos_ = "0" . strval($pos_candidate);
    }else if($pos_candidate >= 1000){
      $pos_ = strval($pos_candidate);
    }else{
      $pos_ = "000" . strval($pos_candidate);
    }
      
    return $name_module . "_" . $pos_ . "_" . $anno;

  }

 //--------------------------------------------

   /**
   * Controllo 
   * codice fiscale
   * nel DATABASE 
   */
  public function codeTax_control($taxCode){
    global $wpdb;

    $query_tax_code = $wpdb->get_results("select data_user from wpackage_ebike_candidate", ARRAY_A); 

    for ($i = 0; $i < count($query_tax_code); $i++) {
      $jSonDecode = json_decode($query_tax_code[$i]["data_user"]); 
      if(strtoupper($jSonDecode->codice_fiscale) == strtoupper($taxCode)){
          return false;
       }
      }
      return true;
  }

  //--------------------------------------------

  /**
   * Aggiungi Candidato
   * nel DATABASE 
   */
  public function add(array $array){
    global $wpdb;

    $datetime = new DateTime($array['date']);
    $datetime->add(new DateInterval('P20D'));


    $query = $wpdb->insert( 'wpackage_ebike_candidate', array(
      "code" => $array['code'],
      "mail" => $array['mail'],
      "data_user" => $array['data'],
      "date" => $array['date'],
      "date_limit" => $datetime->format('Y/m/d'),
      "ci" => $array['ci'],
      "receipt" => $array['receipt'],
      "status" => 'attesa'
    ) );

    if(!is_null($query)){
      return true;
    }else{
      return false;
    }
  }

  
//--------------------------------------------

  /**
   * Modifica Status
   * del candidato
   * nel DATABASE 
   */
  public function modifyCandidate($id, array $array){

    global $wpdb;
    $query = $wpdb->update( 'wpackage_ebike_candidate', array('status' => $array["status"]), array( 'id' => $id ) );

  }

//--------------------------------------------

  /**
   * Modifica Status
   * dei file del candidato
   * nel DATABASE 
   */
  public function modifyFile($id, array $array){

    global $wpdb;
    $bool;

    $query1 = $wpdb->get_results("select ci, receipt, status from wpackage_ebike_candidate where id = " . $id, ARRAY_A);

    if($query1[0][$array["file"]]){
      $bool = false;
      $this->modifyCandidate($id, array("status" => "attesa"));
    }else{
      $bool = true;
    }

    $query = $wpdb->update( 'wpackage_ebike_candidate', array($array["file"] => $bool), array( 'id' => $id ) );

  }

  //--------------------------------------------

  /**
   * Invio Mail
   * al candidato
   */
  public function sendMailRequest(array $array){
    global $wpdb;

    $OnInvoice = "Grazie " . $array["nome"] . " " . $array["cognome"] . " PRATICA N. " . $array["code"] . " </br> per aver inviato la tua richiesta, controlleremo i requisiti e la documentazione inviata. \nRiceverai nei prossimi giorni una mail per avvenuta accettazione e predisposizione dell'erogazione dell'incentivo. \nCordiali saluti, \nUfficio Mobilità Sostenibile";

    $OffInvoice = "Grazie " . $array["nome"] . " " . $array["cognome"] . " PRATICA N. " . $array["code"] . " </br> per aver inviato la tua richiesta, controlleremo i requisiti e la documentazione inviata. \nLa preghiamo di inviare la fattura d’acquisto quietanzata entro e non oltre 20 gg dalla presente richiesta, trascorso tale periodo la richiesta decadrà e non sarà più possibile richiedere l’incentivo.\nLa fattura deve essere inviata a: incentivibici@infomobility.pr.it indicando nome, cognome e numero della pratica. \nCordiali saluti, \nUfficio Mobilità Sostenibile";

    $object = "Infomobility S.p.a. - Incentivi ebike";

    $headers = array('Content-Type: text/html; charset=UTF-8', 'From: Incentivi Infomobility <incentivibici@infomobility.pr.it>');

    $query = $wpdb->get_results("select receipt from wpackage_ebike_candidate where code = '" . $array["code"] . "'", ARRAY_A);

    if($query[0]["receipt"]){$msg = $OnInvoice;}else{$msg = $OffInvoice;}

    if(!is_null($query)){
      /* Invio mail di risposta */
      wp_mail($array["mail"], $object, $msg, $headers);
      return true;
    }else{
      return false;
    }
  }


  //--------------------------------------------
  /**
   * Invio Mail
   * a Infomobility
   */
  public function sendMailInfomobility(array $array, $code, $attachments){

    $msg = "Richiesta da " . $array["nome"] . " " . $array["cognome"] . " PRATICA N. " . $code . ".";

    $object = "Infomobility S.p.a. - Richiesta incentivi ebike";

    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    $headers[] = 'From: Incentivi Infomobility <incentivibici@infomobility.pr.it>';    

    wp_mail("incentivibici@infomobility.pr.it", $object, $msg, $headers, $attachments);
  }

  // incentivibici@infomobility.pr.it


  

//--------------------------------------------

  /**
   * Scarica Excel
   * dei candidati
   * in Real Time
   */

    public function excel(){
      global $wpdb;

  
      $excelQuery = $wpdb->get_results("select * from wpackage_ebike_candidate", ARRAY_A);

      $arrayTemp = array();
      $arrayDatiCandidati = array();
      $size_2 = 0;
      $arrayTitolazioni = array("Codice Pratica", "Nome","Cognome","Data di Nascita","Luogo di nascita","Indirizzo di residenza","Numero civico","Comune","Provincia","Codice Fiscale","Telefono","Email","Tipologia Incentivo","IBAN","Intestatario IBAN","Privacy","Stato");
      $name = "Richiedenti Incentivi Ebike";
      

      $s = 0;
      for ($i = 0; $i < count($excelQuery); $i++) {

        // Codice Pratica
        $arrayDatiCandidati[$s] = $excelQuery[$i]["code"];
        $s++;

        // Inserimento dati Candidato nell'array
        $jSonDecode = json_decode($excelQuery[$i]["data_user"]);
        foreach ($jSonDecode as $key => &$value) {
          $arrayDatiCandidati[$s] = $value;
          $s++;
        }

        // Stato Richiesta
        $arrayDatiCandidati[$s] = $excelQuery[$i]["status"];
        $s++;
      }

      $stringTitle = implode(',', $arrayTitolazioni);
      $stringCandidati = implode(',', $arrayDatiCandidati);

      // Inserisco i dati in un Excel
?> 
  <script type="text/javascript">
    window.location.href = "<?php echo ebike_url_my_plugin()."/admin/excel.php?titolazioni=".$stringTitle."&datiCandidati=".$stringCandidati."&nameFile=".$name ?>"
  </script>

<?php
      
    }
}

$EBIKE_Candidate = new EBIKE_Candidate();

?>