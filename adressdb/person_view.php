<?
//$html->dump($_GET);
if ($_GET['abfrageid']<>0){
  $col_arr = array("name","vorname","firma","Anzahl Brunch","Anzahl VIP-Karten","Anzahl Turnierkarten","Anzahl Podium","Betrag","Anrede 1","Anrede 2");
}else{
  $col_arr = array("Name","Vorname","Firma","Strasse","PLZ","Ort","Telefon","Mobiltelefon");
}
if (!isset($clear)){
	if (!is_Null($keyword) && !isset($_POST['abfrageid'])){
		$filter = $db->createFilter($col_arr,$keyword);
	}else{
    $filter = "";
  }
}else{
	$keyword="";
  $abfrageid=0;
}

$adressen = $db->select($col_arr, "personendaten", "Firma, Name, Vorname ASC", $filter, $_GET['abfrageid']);
echo "<form>";
echo "<a href='person.php?mode=form'>Neue Adresse erstellen</a>&nbsp;\n";
echo "<input type='text' name='keyword' value='".$keyword."' onFocus=\"javascript:resetComboBox('abfrageid');\">";
$abfrage = array();
$abfrage = $db->getAbfragen();
echo " Abfrage: ";
$html->inSelect_new("abfrageid",$abfrage,$_GET['abfrageid']);
echo "&nbsp;<input style='width: 50' type='submit' name='filter' value='Filter' onClick='person.php?keyword=$keyword'>";
echo "&nbsp;<input style='width: 100' type='submit' name='clear' value='Zur&uuml;cksetzen' onClick='person.php'>&nbsp;";
echo "<a href='person.php?mode=form&export=export'>Adress-Export</a>&nbsp;\n";
echo "</form>";


//table overview
if (!empty($adressen)){
  $html->tableHeaderNew(1, 1, 1, "100%", 1, "left");
  $html->printTableHeader($adressen);
  
  //table data
  foreach ($adressen as $key => $val){
		echo "<tr>\n";
		foreach ($val as $colname => $v) {
			if ($colname == "PersonendatenID"){
				echo "<td><a href='person.php?mode=form&id=$v'>".$v."</a>&nbsp;</td>";
			}else{
				echo "<td>".$v."&nbsp;</td>";
			}
		}
    if (isset($val[PersonendatenID]) || isset($val[presonendatenid])){
		  echo "<td align='middle'><a href='person.php?mode=data&delete=delete&id=".$val[PersonendatenID]."'>L&ouml;schen</a></td>\n";
    }
    echo "</tr>\n";
	}
  $html->tableFooter();
}else{
  echo "<br><br>Keine Adressen gefunden.";
}
?>