<?
echo "<a href=\"javascript:history.back()\">Hauptseite</a>\n";
if ($GLOBALS[export]){
	$sel_arr1 = array('Abteilung','Aktiv 1','Anrede','Anrede 1','Anzahl Brunch','Anzahl Turnierkarten'
		             ,'Anzahl VIP-Karten','Bemerkungen','Brunch','E-Mail','Fax','Firma','Funktion'
		             ,'Geschaeftsadresse','Kategorie','Land','Mobiltelefon','Name','Nummer','Ort'
		             ,'PLZ','Privatadresse','Strasse','Telefon','Titel','Turnierkarte','VIP-Karten'
		             ,'Vorname');
	//aktive2
	$sel_arr2 = array('Abteilung 2','Aktiv 2','Anrede','Anrede 2','Anzahl Brunch','Anzahl Turnierkarten'
					 ,'Anzahl VIP-Karten','Bemerkungen','Brunch','E-Mail 2','Fax','Firma'
					 ,'Funktion','Geschaeftsadresse','Kategorie','Land','Land 2','Mobiltelefon 2','Name'
					 ,'Nummer','Ort 2','PLZ 2','Privatadresse','Strasse 2','Telefon 2','Titel','Turnierkarte'
					 ,'VIP-Karten','Vorname');

	echo "<h3>Adress-Export</h3>\n";
	echo "<h4>Geschichte</h4>\n";
	echo "<form name='geschichte' method='post' action=\"javascript:exportsql();\">\n";
	if (isset($akt)){
		$sel = array();
		if ($akt == "aktiv1"){
			$sel = $sel_arr1;
			$s1 = "selected";
		}
		if ($akt == "aktiv2"){
			$sel = $sel_arr2;
			$s2 = "selected";
		}
	}
	echo "<select name='akt' onChange=\"javascript:sitereload()\">";
	echo "<option name=''></option>";
	echo "<option name='aktiv1' $s1>Aktiv 1</option>";
	echo "<option name='aktiv2' $s2>Aktiv 2</option>";
	echo "</select><br>";
	//aktive1
	$col_arr = $db->getColumnsInfos("personendaten");
	echo "<select name='col' multiple size='20'>";
	foreach ($col_arr as $key => $col){
		$s = "";
		if (!empty($sel)){
			if (in_array($col[Field], $sel)){
				$s = "selected";
			}
		}
		echo "<option name='".$col[Field]."' $s>".$col[Field]."</otpion>\n";
	}
	echo "</select><br>\n";
	$col_arr = $db->getGeschichtsKategorien(date("Y"));
	echo "<select name='kat'>";
	foreach ($col_arr as $kid => $k){
		echo "<option name='".$k."'>".$k."</otpion>\n";
	}
	echo "</select><br>\n";
	echo "<input type='submit' name='save' value='exportieren'>\n";
	echo "<input type='hidden' name='mode' value='data'>\n";
	echo "</form>\n";
	echo "<h4>Weihnachtskarte</h4>\n";
}else{
	if (isset($id)){
    $col_arr = array("*");
   	$data = $db->select($col_arr, "personendaten", "PersonendatenID", "AND PersonendatenID=".$id);
    $data = $data[0];
    replace($data," ","_");
	}
  echo "<h3>Korrespondenzadresse</h3>";
	echo "<table>";
	echo "<form name='person' method='post' action='person.php?mode=data'>";
	echo "<tr><td width='15%'>PersonendatenID: </td><td width='20%'><input type='text' name=data[PersonendatenID] value='".$data[PersonendatenID]."' maxlength='5'size='30'></input></td></tr>";
	$check1 = "";
	$check2 = "";
	if ($data[Privatadresse] == "1"){
        	$check1 = "checked";
	}else{
        	$check2 = "checked";
	}
	//echo "<tr><td>Privatadresse: </td><td><input type='checkbox' name=data[Privatadresse] value='".$data[Privatadresse]."' maxlength='5' size='30' $check></td></tr>";
	echo "<tr><td>Privatadresse: </td><td><input style='width: 50' type='radio' name=data[Privatadresse] value='1' $check1>&nbsp;ja&nbsp;<input style='width: 50' type='radio' name=data[Privatadresse] value='0' $check2>&nbsp;nein&nbsp;</td></tr>";
	$check1 = "";
	$check2 = "";
	if ($data[Geschaeftsadresse] == "1"){
        	$check1 = "checked";
	}else{
        	$check2 = "checked";
	}
	//echo "<tr><td>Gesch�ftsadresse: </td><td><input type='checkbox' name=data[Gesch�ftsadresse] maxlength='5' size='30' $check></td></tr>";
	echo "<tr><td>Gesch&auml;ftsadresse: </td><td><input style='width: 50' type='radio' name=data[Geschaeftsadresse] value='1' $check1>&nbsp;ja&nbsp;<input style='width: 50' type='radio' name=data[Geschaeftsadresse] value='0' $check2>&nbsp;nein&nbsp;</td></tr>";
	echo "<tr><td>Firma: </td><td><input type='text' name=data[Firma] value='".$data[Firma]."' maxlength='50' size='30'></input></td>";
	echo "<td>Firma 2: </td><td><input type='text' name=data[Firma_2] value='".$data[Firma_2]."' maxlength='50' size='30'></input></td></tr>";
	echo "<tr><td>Abteilung: </td><td><input type='text' name=data[Abteilung] value='".$data[Abteilung]."' maxlength='50' size='30'></input></td>";
	echo "<td>Abteilung 2: </td><td><input type='text' name=data[Abteilung_2] value='".$data[Abteilung_2]."' maxlength='50' size='30'></input></td></tr>";
	echo "<tr><td>Name: </td><td><input type='text' name=data[Name] value='".$data[Name]."'  maxlength='50' size='30'></input></td></tr>";
	echo "<tr><td>Vorname: </td><td><input type='text' name=data[Vorname] value='".$data[Vorname]."' maxlength='50' size='30'></input></td></tr>";
	echo "<tr><td>Funktion: </td><td><input type='text' name=data[Funktion] value='".$data[Funktion]."' maxlength='50' size='30'></input></td></tr>";
	echo "<tr><td>Titel: </td><td><input type='text' name=data[Titel] value='".$data[Titel]."' maxlength='50' size='30'></input></td></tr>";
	$check1 = "";
	$check2 = "";
	if ($data[Aktiv_1] == "1"){
        	$check1 = "checked";
	}else{
        	$check2 = "checked";
	}
	//echo "<tr><td>Aktiv 1: </td><td><input type='checkbox' name=data[Aktiv_1] value='".$data[Aktiv_1]."' maxlength='5' size='30' $check></td>";
	echo "<tr><td>Aktiv 1: </td><td><input style='width: 50' type='radio' name=data[Aktiv_1] value='1' $check1>&nbsp;ja&nbsp;<input style='width: 50' type='radio' name=data[Aktiv_1] value='0' $check2>&nbsp;nein&nbsp;</td>";
	$check1 = "";
	$check2 = "";
	if ($data[Aktiv_2] == "1"){
        	$check1 = "checked";
	}else{
        	$check2 = "checked";
	}
	//echo "<td>Aktiv 2: </td><td><input type='checkbox' name=data[Aktiv_2] value='".$data[Aktiv_2]."' maxlength='5' size='30' $check></td></tr>";
    //print_r($data);
	echo "<td>Aktiv 2: </td><td><input style='width: 50' type='radio' name=data[Aktiv_2] value='1' $check1>&nbsp;ja&nbsp;<input style='width: 50' type='radio' name=data[Aktiv_2] value='0' $check2>&nbsp;nein&nbsp;</td>";
	echo "<tr><td>E-Mail: </td><td><input type='text' name=data[E-Mail] value='".$data['E-Mail']."' maxlength='50' size='30'></input></td>";
	echo "<td>E-Mail 2: </td><td><input type='text' name=data[E-Mail_2] value='".$data['E-Mail_2']."' maxlength='50' size='30'></input></td></tr>";
	echo "<tr><td>Fax: </td><td><input type='text' name=data[Fax] value='".$data[Fax]."' maxlength='50' size='30'></input></td>";
	echo "<td>Fax 2: </td><td><input type='text' name=data[Fax_2] value='".$data[Fax_2]."' maxlength='50' size='30'></input></td></tr>";
	echo "<tr><td>Land: </td><td><input type='text' name=data[Land] value='".$data[Land]."' maxlength='50' size='30'></input></td>";
	echo "<td>Land 2: </td><td><input type='text' name=data[Land_2] value='".$data[Land_2]."' maxlength='50' size='30'></input></td></tr>";
	echo "<tr><td>Telefon: </td><td><input type='text' name=data[Telefon] value='".$data[Telefon]."' maxlength='50' size='30'></input></td>";
	echo "<td>Telefon 2: </td><td><input type='text' name=data[Telefon_2] value='".$data[Telefon_2]."' maxlength='50' size='30'></input></td></tr>";
	echo "<tr><td>Mobiltelefon: </td><td><input type='text' name=data[Mobiltelefon] value='".$data[Mobiltelefon]."' maxlength='50' size='30'></input></td>";
	echo "<td>Mobiltelefon 2: </td><td><input type='text' name=data[Mobiltelefon_2] value='".$data[Mobiltelefon_2]."' maxlength='50' size='30'></input></td></tr>";
	echo "<tr><td>Strasse: </td><td><input type='text' name=data[Strasse] value='".$data[Strasse]."' maxlength='50' size='30'></input></td>";
	echo "<td>Strasse 2: </td><td><input type='text' name=data[Strasse_2] value='".$data[Strasse_2]."' maxlength='50' size='30'></input></td></tr>";
	echo "<tr><td>Ort: </td><td><input type='text' name=data[Ort] value='".$data[Ort]."' maxlength='50' size='30'></input></td>";
	echo "<td>Ort 2: </td><td><input type='text' name=data[Ort_2] value='".$data[Ort_2]."' maxlength='50' size='30'></input></td></tr>";
	echo "<tr><td>PLZ: </td><td><input type='text' name=data[PLZ] value='".$data[PLZ]."' maxlength='50' size='30'></input></td>";
	echo "<td>PLZ 2: </td><td><input type='text' name=data[PLZ_2] value='".$data[PLZ_2]."' maxlength='50' size='30'></input></td>";
	echo "<tr><td>Website: </td><td><input type='text' name=data[Website] value='".$data[Website]."' maxlength='50' size='30'></input></td>";
	echo "<td>Website 2: </td><td><input type='text' name=data[Website_2] value='".$data[Website_2]."' maxlength='50' size='30'></input></td></tr>";
	echo "<tr><td>Anrede 1: </td><td><input type='text' name=data[Anrede_1] value='".$data[Anrede_1]."' maxlength='50' size='30'></input></td></tr>";
	echo "<tr><td>Anrede 2: </td><td><input type='text' name=data[Anrede_2] value='".$data[Anrede_2]."' maxlength='50' size='30'></input></td></tr>";

  $check1 = "";$check2 = "";
  $data[Brunch] == "1" ? $check1 = "checked" : $check2 = "checked";
	echo "<tr><td>Brunch: </td><td><input id='brunchYes' style='width: 50' type='radio' name=data[Brunch] value='1' $check1>&nbsp;ja&nbsp;<input id='brunchNo' style='width: 50' type='radio' name=data[Brunch] value='0' $check2>&nbsp;nein&nbsp;</td><td colspan='2'>F&uuml;r den Brunch wird ein B&auml;ndel ben&ouml;tigt.</td></tr>";
	echo "<tr><td>Anzahl Brunch: </td><td><input onChange=\"javascript:enableRadioButton(this,'brunchYes','brunchNo');\" type='text' name=data[Anzahl_Brunch] value='".$data[Anzahl_Brunch]."' maxlength='10' size='30'></input></td></tr>";

  $check1 = "";$check2 = "";
	$data[Turnierkarte] == "1" ? $check1 = "checked" : $check2 = "checked";
	echo "<tr><td>Turnierkarte: </td><td><input id='turnierkarteYes' style='width: 50' type='radio' name=data[Turnierkarte] value='1' $check1>&nbsp;ja&nbsp;<input id='turnierkarteNo' style='width: 50' type='radio' name=data[Turnierkarte] value='0' $check2>&nbsp;nein&nbsp;</td><td colspan='2'>Berechigt zum Turnierbesuch, ohne Trib&uuml;ne</td></tr>";
	echo "<tr><td>Anzahl Turnierkarten: </td><td><input onChange=\"javascript:enableRadioButton(this,'turnierkarteYes','turnierkarteNo');\" type='text' name=data[Anzahl_Turnierkarten] value='".$data[Anzahl_Turnierkarten]."' maxlength='5' size='30'></input></td></tr>";

  $check1 = "";$check2 = "";
  $data['VIP-Karten'] == "1" ? $check1 = "checked" : $check2 = "checked";
  echo "<tr><td>VIP-Karten: </td><td><input id='vipYes' style='width: 50' type='radio' name=data[VIP-Karten] value='1' $check1>&nbsp;ja&nbsp;<input id='idNo'  style='width: 50' type='radio' name=data[VIP-Karten] value='0' $check2>&nbsp;nein&nbsp;</td><td colspan='2'>Berechtigt zum Besuch der VIP Bar.</td></tr>";
	echo "<tr><td>Anzahl VIP-Karten: </td><td><input onChange=\"javascript:enableRadioButton(this,'vipYes','vipNo');\" type='text' name=data[Anzahl_VIP-Karten] value='".$data['Anzahl_VIP-Karten']."' maxlength='5' size='30'></input></td></tr>";

  $check1 = "";$check2 = "";
  $data[Podium] == "1" ? $check1 = "checked" : $check2 = "checked";
  echo "<tr><td>Podiumsgespr&auml;ch: </td><td><input id='podiumYes' style='width: 50' type='radio' name=data[Podium] value='1' $check1>&nbsp;ja&nbsp;<input id='podiumNo' style='width: 50' type='radio' name=data[Podium] value='0' $check2>&nbsp;nein&nbsp;</td></tr>";
	echo "<tr><td>Anzahl Podiumsgespr&auml;ch: </td><td><input onChange=\"javascript:enableRadioButton(this,'podiumYes','podiumNo');\" type='text' name=data[Anzahl_Podium] value='".$data['Anzahl_Podium']."' maxlength='5' size='30'></input></td></tr>";

  echo "<tr><td>Bemerkungen: </td><td><input type='text' name=data[Bemerkungen] value='".$data[Bemerkungen]."' maxlength='50' size='30'></input></td></tr>";

  $kontakt_arr = $db->getKontakte();
	echo "<tr><td>KontaktID: </td><td><select name=data[KontaktID]>";
	foreach ($kontakt_arr as $kid => $kontaktperson){
        $sel = "";
        if ($data[KontaktID] == $kid){
                $sel = "selected";
        }
        echo "<option value='$kid' $sel>$kontaktperson</otpion>";
	}
	echo "</select></td></tr>";
	//echo "<tr><td>Nummer: </td><td><input type='checkbox' name=data[Nummer] maxlength='10' size='30'></input></td></tr>";
	$check1 = "";
	$check2 = "";
	if ($data[Weihnachtskarte] == "1"){
        $check1 = "checked";
	}else{
        $check2 = "checked";
	}
	echo "<tr><td>Weihnachtskarte: </td><td><input style='width: 50' type='radio' name=data[Weihnachtskarte] value='1' $check1>&nbsp;ja&nbsp;<input style='width: 50' type='radio' name=data[Weihnachtskarte] value='0' $check2>&nbsp;nein&nbsp;</td></tr>";
	echo "<tr><td><input type='submit' name='save' value='speichern'></td></tr>";
	echo "<input type='hidden' name='mode' value='data'>";
	if ($id){
        echo "<input type='hidden' name='update' value='update'>";
	}else{
        echo "<input type='hidden' name='new' value='new'>";
	}
	echo "</form>";
	echo "</table>";
	
	// --- GESCHICHTE ---
	echo "<h3>Kategorien</h3>\n";
	if (isset($id)){
        $col_arr = array("*");
        $geschichte = $db->getGeschichte($id);
	}
	echo "<table>\n";
	echo "<form name='geschichte' method='post' action='person.php?mode=data'>\n";
	echo "<tr>\n";
	if (count($geschichte) != 0){
        $col_arr = array_keys($geschichte[0]);
        foreach ($col_arr as $key => $col){
                echo "<td><b>$col&nbsp;&nbsp;</b></td>\n";
        }
        echo "<td><b>L&ouml;schen</b></td>";
        echo "</tr>";
        foreach($geschichte as $key => $val){
                echo "<tr>\n";
                foreach ($val as $col => $d){
       	        	echo "<td>$d</td>\n";
                }
                echo "<td align='middle'><a href='person.php?mode=data&deletegeschichte=deletegeschichte&id=".$val[GeschichteID]."'>x</a></td></tr>\n";
        }
	}

	//row for adding
	echo "<td><input style='width: 100' type='text' name='data[GeschichtID]' disabled></td>\n";
	echo "<td><select style='width: 150' name='data[KategorieID]'>\n";
	$kat_arr = $db->getKategorien();
	foreach ($kat_arr as $kid => $kategorie){
    	echo "<option value='$kid'>".$kategorie."</otpion>\n";
	}
	echo "</select></td>\n";
	echo "<td><input style='width: 100' type='text' name='data[Jahr]' value='".date("Y")."'></td>\n";
	echo "<td><input style='width: 100' type='text' name='data[Betrag]' value=0></td>\n";
	echo "<td><input style='width: 100' type='text' name='data[Bemerkungen]'></td>\n";
	echo "</tr>\n";
	echo "</table>\n";
	echo "<table>\n";
	echo "<tr><td><input type='submit' name='save' value='speichern'></td></tr>\n";
	echo "<input type='hidden' name='mode' value='data'>\n";
	echo "<input type='hidden' name='geschichte' value='geschichte'>\n";
	echo "<input type='hidden' name='data[PersonendatenID]' value='".$id."'>\n";
	echo "</form>\n";
	echo "</table>\n";
}

?>
