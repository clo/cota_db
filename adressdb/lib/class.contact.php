<?
/*
 * file:         class.contact.php
 * 
 * author:       christian lochmatter
 * 
 * description:  contact class
 * 
 * history:      28.01.2007 implementation
 */
 

class contact {
  var $firstname;
  var $lastname;
  var $address;
  var $email;
  var $phone;
   
  //constuctor
  function contact(){}
  
  //generic set function
  function set($var,$value){
    eval("$"."this->".$var."=\"$value\";");
  }
  
  //generic get function
  function get($var){
  	eval("$"."value=\"\$this->".$var."\";");
    return $value;
  }

  //this function checks the input
  function checkData(){
    $errMsg = array();
    if (empty($this->vorname)){
      $errMsg['vorname'] = "Vorname ist leer.";
    }
    if (empty($this->name)){
      $errMsg['name'] = "Nachname ist leer.";
    }
    if (!preg_match("/^[a-z|\.|-]+@[a-z|\.|-]+\.[a-z]+$/",$this->email)){
      $errMsg['email'] = "E-mail Adresse fehlerhaft (z.B. muster.mann@muster.ch).";  
    }
    return $errMsg;
  }
  
  //this set and get functions are not necessaire -> replaced by get/set
  function setFirstname($firstname){
    $this->firstname = $firstname;
  }
  
  function getFirstname(){
  	return $this->firstname;
  }
  
  function setLastname($lastname){
  	$this->lastname = $lastname;
  }
  
  function getLastname(){
  	return $this->lastname;
  }
  
  function setAddress($address){
  	$this->addresss = $address;
  }
  
  function getAddress(){
  	return $this->address;
  }
  
  function setEmail($email){
  	$this->email =  $email;
  }
  
  function getEmail(){
  	return $this->email;
  }
  
  function setPhone($phone){
    $this->phone = $phone;
  }
  
  function getPhone(){
    return $this->phone;
  }
}
?>
