<?php 


function ebike_absolute(){
  $absolute = explode('wp-content/plugins', pathinfo(dirname(__DIR__))["dirname"]);
  return $absolute[0];
}

/**
 * Path del Plugin
 * Corrente
 */

function ebike_url_my_plugin(){
  return plugins_url('wpackage_ebike');
}

/**
 * Percorso assoluto
 * del sito web
 */

function ebike_url_my_path(){
  return site_url('/');
}



function ebike_isNull($a, string $w){
  if($a){
    echo "<p class='msg'>" . $w . " Correttamente</p>";
  }else{
    echo "<p class='msg'>Ops! Qualcosa è andato storto</p>";
  }
}

function ebike_date_comparison($date){
  if(strtotime($date) > strtotime("now")){
    return true;
  }else{
    return false;
  }
}

function redirect_Ebike(){
  ?> 
    <script type="text/javascript">window.location.href = "<?php echo ebike_url_my_path() . 'wp-admin/admin.php?page=admin_candidate_ebike_page' ?>"</script>
  <?php
}


?>