/**
 * Plugin Name:       WPackage Ebike
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Send Form Compilate
 * Version:           1.0
 * Author:            Mez
 */

/* ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ */


function true_crtl(f, string, n){
  var fieldIban = f.querySelector(string);
  var l = fieldIban.value;
  if(l.length == n){
    return true;
  }
  return false;
}

async function ebike_sendForm($path){

  var form = document.querySelector(".WPackage_Ebike_Module");
  var formData = new FormData(form);

  formData.set('codice_fiscale',formData.get('codice_fiscale').toUpperCase());
  
  var msgResponse = document.querySelector('#response');
  msgResponse.style.padding = "20px";
  msgResponse.style.color = "#fff";
  msgResponse.style.fontSize = "20px";
  msgResponse.style.fontWeight = "700";
  
  var ci = document.getElementById("ci").files;

  if (ci.length <= 0) {
    msgResponse.style.backgroundColor = "#922E22";
    msgResponse.innerHTML = "Non hai inserito la Carta d'identità";
    return;
  } else if (ci.length > 2) {
    msgResponse.style.backgroundColor = "#922E22";
    msgResponse.innerHTML = "Non puoi inserire più di 2 file nel campo Carta d'identità";
    return;
  }


  if (!true_crtl(form, "input[name=iban]", 27)){
    msgResponse.style.backgroundColor = "#922E22";
    msgResponse.innerHTML = "IBAN non valido";
    return;
  } else if (!true_crtl(form, "input[name=codice_fiscale]", 16)) {
    msgResponse.style.backgroundColor = "#922E22";
    msgResponse.innerHTML = "Codice Fiscale non valido";
    return;
  }else{
    msgResponse.style.backgroundColor = "#393939";
    msgResponse.innerHTML = "Stiamo processando l'invio...";
  }

  await fetch(
    $path, 
    {
      method: "POST",
      body: formData,
    }

  )
  .then(response => {
    if(response.status == 404){
      form.reset();
      msgResponse.style.backgroundColor = "#922E22";
      msgResponse.innerHTML = "La richiesta è stata respinta. Riprova più tardi";
    } else if (response.status == 600) {
      msgResponse.style.backgroundColor = "#922E22";
      msgResponse.innerHTML = "Questo codice fiscale è già stato inserito";
    } else if (response.status == 500) {
      form.reset();
      msgResponse.style.backgroundColor = "#922E22";
      msgResponse.innerHTML = "In questo momento non è possibile processare la richiesta. Riprova più tardi";
    } else if (response.status == 503) {
      form.reset();
      msgResponse.style.backgroundColor = "#922E22";
      msgResponse.innerHTML = "Invio richiesta momentaneamente sospesa";
    } else if (response.status == 200){
      form.reset();
      msgResponse.style.backgroundColor = "#2bb73a";
      msgResponse.innerHTML = "Invio avvenuto con successo.";
    }
  })
  .catch(error => {
    msgResponse.style.backgroundColor = "#922E22";
    msgResponse.innerHTML = error;
  });
}