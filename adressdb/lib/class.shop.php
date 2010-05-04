<?
class shop {
  var $_article=array();
  var $_picwidth = "150";
	
  function putArticle($article){
    $this->_article = $article;
  }
	
  function getArticle(){
	return $this->_article;
  }
  
  function printArticleAsTable($values){
    foreach ($this->_article as $idartikel => $val ){
      $aSizes = array();
      $size = array();
      echo "<tr><td align='center'><h4>".$val['artikel']."</h4></td></tr>\n";
      echo "<tr><td align='center'><b><img src='".$val['picture']."' border='0' width='$this->_picwidth' title='".$val['artikel']."'></b></td></tr>\n";
      echo "<tr><td align='center'>".$val['beschrieb']."</td></tr>\n";
      $aFarben = split(";",$val['farbe']);
      echo "<tr><td align='center'>";
      if (count($aFarben) >= 2){
        foreach ($aFarben as $farbe){
          $index = str_replace(" ","_",$val['artikel']."_farbe");
          $defval = $values[$index];
          $en = "";
          if ( $defval == $farbe){
            $en = "checked";
          }
          echo "<input type='radio' name='".$val['artikel']."_farbe' value='".$farbe."' $en>&nbsp;".$farbe."&nbsp;\n";
          
        }
      }else{
      	echo $val['farbe'];
      }
      echo "</td></tr>";
      echo "<tr><td align='center'><b>".$val['preis']." CHF</b></td></tr>\n";
      //Grössen
      echo "<tr><td align='center'>Grössen:</td></tr>";
      if (eregi("\*",$val['groesse'])){
        $aSizes = split("\*",$val['groesse']);
      }else{
      	$aSizes[] = $val['groesse'];
      }
      foreach ($aSizes as $sSize){
        $aSize = split(";",$sSize);
        echo "<tr><td align='center'>";
        foreach ($aSize as $size){
       	  $index = str_replace(" ","_",$val['artikel']."_groesse_".$size);
	      $defvalue = $values[$index];
          echo "&nbsp;$size&nbsp;<input maxlength='2' type='text' class='inputsize' name='".$val['artikel']."_groesse_".$size."' value='".$defvalue."'>";
        }
        echo "&nbsp;Anzahl</td></tr>";
  	  }
  	  echo "<tr><td><br><br></td></tr>";
    }
  }

}
?>