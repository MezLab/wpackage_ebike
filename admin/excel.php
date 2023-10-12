<?php
require_once '../class/Classes/PHPExcel.php';

// Dati Database
$servername = 'localhost';
$username = 'infomobilityWP';
$password = 'Mob1l1t@';
$dbname = 'infomobility';

// Crea collegamento
$conn = new mysqli($servername, $username, $password, $dbname);
// Prova connessione
if($conn->connect_error) die( "Connessione fallita:" . $conn->connect_error);

// Query selezione dati richiedenti
$queryExcel = $conn->query("SELECT code, data_user, status FROM wpackage_ebike_candidate");


$arrayTemp = array();
$arrayDatiCandidati = array();
$size_2 = 0;
// Titolazione
$arrayTitolazioni = array("Codice Pratica", "Nome","Cognome","Data di Nascita","Luogo di nascita","Indirizzo di residenza","Numero civico","Comune","Provincia","Codice Fiscale","Telefono","Email","Tipologia Incentivo","IBAN","Intestatario IBAN","Privacy","Stato");
// Nome File
$name = "Richiedenti Incentivi Ebike";

$s = 0;
while($row = $queryExcel->fetch_assoc()) {

  // Codice Pratica
  $arrayDatiCandidati[$s] = $row["code"];
  $s++;

  // Inserimento dati Candidato nell'array
  $jSonDecode = json_decode($row["data_user"]);
  foreach ($jSonDecode as $key => &$value) {
    $value = preg_replace('/[,+]/', ' ', $value);
    $arrayDatiCandidati[$s] = $value;
    $s++;
  }

  // Stato Richiesta
  $arrayDatiCandidati[$s] = $row["status"];
    $s++;
}

$stringTitle = implode(',', $arrayTitolazioni);
$stringCandidati = implode(',', $arrayDatiCandidati);

// Array Campi Titolazione
$intestazione = explode(',', $stringTitle);

// Array Dati dei Candidati
$dati = explode(',', $stringCandidati);

$letter = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");

$newLetterColumn = array();

$n;

/** */
$a = sizeof($intestazione); // Numero di campi del Modulo
$b = sizeof($letter); //26

$c = floor($a / $b);
$e = $a % $b;
/** */

function repeatColumn(int &$q, array &$t, array &$p, int $size){
  for ($i = 0; $i < $q; $i++) { 
      array_push($t, $t[$size] . $p[$i]);
  }
}

for ($l = -1; $l < $c-1; $l++) { 
  repeatColumn($b, $newLetterColumn, $letter, $l);
  $n = $l;
  $n++;
}

if($e <= 0){
  
}else{
  for ($j=0; $j < $e; $j++) {
    array_push($newLetterColumn, $newLetterColumn[$n] . $letter[$j]);
  }
}


// Create new PHPExcel object
$_PHPExcel = new PHPExcel();

// Set document properties
$_PHPExcel->getProperties()->setCreator("MEZ")
							 ->setTitle( str_replace("_", " ", $name) . " - Infomobility")
							 ->setSubject("Office 2007 XLSX")
							 ->setDescription("Documento Generato per Infomobility");


// Add some data
$_PHPExcel->setActiveSheetIndex(0);

foreach ($newLetterColumn as $key => $value) {
  $_PHPExcel->getActiveSheet()
      ->setCellValue($value . '1', $intestazione[$key])
      ->getColumnDimension($value)->setWidth(20);
}

$aa = 2;
$bb = 0;
for ($lol = 0; $lol < sizeof($dati)/sizeof($intestazione); $lol++) { 
  foreach ($newLetterColumn as $key => $value) {
    $_PHPExcel->getActiveSheet()
        ->setCellValue($value . strval($aa), $dati[$bb]);
        $bb++;
  }
$aa++;
}

// Rename worksheet
$_PHPExcel->getActiveSheet()->setTitle('Infomobility');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$_PHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=' . $name . ".xls");
header('Cache-Control: max-age=0');


$objWriter = PHPExcel_IOFactory::createWriter($_PHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;