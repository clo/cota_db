/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function resetComboBox(id){
  var box = document.getElementById(id);
  box.selectedIndex=0;
}

function enableRadioButton(caller,idyes,idno){
  var radioYes = document.getElementById(idyes);
  var radioNo = document.getElementById(idno);
  if (caller.value > 0 ){
    radioYes.checked = true;
    radioNo.checked = false;
  }
  if (caller.value == 0){
    radioYes.checked = false;
    radioNo.checked = true;
  }
}

function ident(caller){
  alert("ID: " + caller.id);
}

