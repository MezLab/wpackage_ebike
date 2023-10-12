<?php 

/**
 * Plugin Name:       WPackage Ebike
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Creazione Shortcode
 * Version:           1.1
 * Requireds PHP:      7
 * Author:            Mez
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

// <form enctype='multipart/form-data' action='javascript:void(0);' method='POST' class='WPackage_Ebike_Module infomobilityModule' onsubmit='ebike_sendForm(\"" . $path . "ebike\")'>
// <form action='https://www.infomobility.pr.it/ebike/' method='POST' class='WPackage_Ebike_Module infomobilityModule'>

/**
 * Modulo per la registrazione
 * del richiedente incentivo 
 * Ebike
 */
function WPackage_Ebike_Receipt($atts){
  $path = ebike_url_my_path();
 $shortcode = "
  <form enctype='multipart/form-data' action='javascript:void(0);' method='POST' class='WPackage_Ebike_Module infomobilityModule' onsubmit='ebike_sendForm(\"" . $path . "ebike\")'>
    <p><span style='color:#F73545'>*</span>: campi obbligatori</p>
    <p>Nome<span style='color:#F73545'>*</span></p>
    <input type='text' name='nome' id='name' required>
    <p>Cognome<span style='color:#F73545'>*</span></p>
    <input type='text' name='cognome' id='surname' required>
    <p>Data di nascita<span style='color:#F73545'>*</span></p>
    <input type='date' name='data' id='date' required>
    <p>Luogo di nascita<span style='color:#F73545'>*</span></p>
    <input type='text' name='luogo' id='place' required>
    <div style='width:69%; display:inline-block;'>
      <p>Indirizzo di residenza<span style='color:#F73545'>*</span></p>
      <input type='text' name='indirizzo' id='indirizzo' required>
    </div>
    <div style='width:30%; display:inline-block;'>
      <p>Numero civico<span style='color:#F73545'>*</span></p>
      <input type='text' name='civico' id='civico' required>
    </div>
    <p>Comune<span style='color:#F73545'>*</span></p> 
    <select name='comune' id='comune'>
      <option value='Parma'>Parma</option>
    </select>
    <p>Provincia<span style='color:#F73545'>*</span></p>
    <select name='provincia' id='provincia'>
      <option value='PR'>PR</option>
    </select>
    <p>Codice fiscale<span style='color:#F73545'>*</span></p>
    <input type='text' name='codice_fiscale' id='tax_code' required>
    <p>Telefono<span style='color:#F73545'>*</span></p>
    <input type='tel' name='telefono' id='phone' required>
    <p>Mail<span style='color:#F73545'>*</span></p>
    <input type='email' name='email' id='email' required>
    <p>Tipologia Incentivo<span style='color:#F73545'>*</span></p>
    <select name='incentive' id='incentivo' required>
      <option value='EBike-300€'>EBike-300€</option>
      <option value='ECargobike-500€'>ECargobike-500€</option>
    </select>
    <p>IBAN<span style='color:#F73545'>*</span></p>
    <input type='text' name='iban' id='iban' required>
    <p>Intestatario IBAN<span style='color:#F73545'>*</span></p>
    <input type='text' name='intestatario_IBAN' id='name_IBAN' required>
    <p>Allegare Carta d'identità (o Autodichiarazione)<span style='color:#F73545'>*</span></p>
    <p style='margin:0px;font-weight:300;'>puoi inserire la <strong>carta d'identità</strong> fronte/retro in un unico file oppure in 2 file separati</p>
    <p style='margin:0px;font-weight:300;'>per inserire 2 file separati tieni premuto <strong>ctrl(window)</strong> o <strong>cmd(mac)</strong> mentre li selezioni</p>
    <input type='file' name='ci[]' id='ci' accept='image/*,application/pdf' multiple required>
    <p>Allegare la fattura quietanzata</p>
    <input type='file' name='quietanza' id='quietanza' accept='image/*,application/pdf'>
    <p><a style='color: #006989;text-decoration: underline;' href='https://www.infomobility.pr.it/wp-content/uploads/2023/03/Informativa-Privacy.pdf' target='_blank'>Leggi l’informativa sulla privacy</a></p>
    <input type='checkbox' name='accept' id='accept' required>
    <label for=''>Ho preso visione dell’informativa privacy</label>
    <input type='submit' value='Invia richiesta'>
  </form>
  <div id='response'></div>
  <script src=" . plugins_url('wpackage_ebike/library/js/ebike_send.js') . "></script>
 ";
 return $shortcode;

}

add_shortcode('WPackage_Ebike', 'WPackage_Ebike_Receipt');

?>