/**
 * Plugin Name:       WPackage Ebike
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       General Script
 * Version:           1.0
 * Author:            Mez
 */

/* ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ */


function e_searchDB(type){
  var _s = document.querySelector('.sel_ input[type=search]');

  const xhttp = new XMLHttpRequest();
  xhttp.onload = function () {
    document.querySelector('#myTable.ebike tbody').innerHTML =  this.responseText;
  }
  xhttp.open("GET", "?e_search_value=" + _s.value + "&e_search_type=" + type , true);
  xhttp.send();
}

// TAB
const tabs = document.querySelector(".wrapper");
const tabButton = document.querySelectorAll(".tab-button");
const contents = document.querySelectorAll(".content");

if(tabs != null){
tabs.onclick = e => {
  const id = e.target.dataset.id;
  if (id) {
    tabButton.forEach(btn => {
      btn.classList.remove("active");
    });
    e.target.classList.add("active");

    contents.forEach(content => {
      content.classList.remove("active");
    });
    const element = document.getElementById(id);
    element.classList.add("active");
  }
}
}