<?
$db->log($_SERVER['REMOTE_USER'],$data['PersonendatenID']);
if ($new){
	replace($data,"_"," ");
	$sql = "INSERT INTO personendaten SET ";
	foreach ($data as $col => $val) {
		if (is_string($val)){
			$sql .= "`".$col."`='".$val."',";
		}
		if (is_int($val)){
			$sql .= "`".$col."`=".$val.",";
		}
	}
	$sql = substr($sql,0,strlen($sql)-1);
	$db->execute($sql);
	echo "Der Korespondenzadresse wurde erfolgreich hinzugef&uuml;gt. :-)<br>";
}
if ($update){
	replace($data,"_"," ");
	$sql = "UPDATE personendaten SET ";
	foreach ($data as $col => $val) {
		if (is_string($val)){
			$sql .= "`".$col."`='".$val."',";
		}
		if (is_int($val)){
			$sql .= "`".$col."`=".$val.",";
		}
	}
	$sql = substr($sql,0,strlen($sql)-1);
	$sql .= " WHERE `PersonendatenID`=".$data['PersonendatenID'];
  $db->execute($sql);
	echo "Der Korespondenzadresse wurde erfolgreich ge&auml;ndert. :-)<br>";
}
if($delete){
	$sql = "DELETE FROM personendaten WHERE PersonendatenID=".$id;
	$db->execute($sql);
	echo "Der Korespondenzadresse wurde erfolgreich gel&ouml;scht. :-)<br>";
}
if ($geschichte){
	$sql = "INSERT INTO geschichte SET ";
	foreach ($data as $col => $val) {
		if (is_string($val)){
			$sql .= "`".$col."`='".$val."',";
		}
		if (is_int($val)){
			$sql .= "`".$col."`=".$val.",";
		}
	}
	$sql = substr($sql,0,strlen($sql)-1);
	//$sql .= " WHERE `PersonendatenID`=".$data['PersonendatenID'];
	$db->execute($sql);
	echo "Der Geschichtseintrag wurde erfolgreich gespeichert. :-)<br>";
	
}
// ---- geschichteeintrag l�schen ---
if ($deletegeschichte){
	$sql = "DELETE FROM geschichte WHERE GeschichteID=".$id;
	$db->execute($sql);
	echo "Der Geschichtseintrag wurde erfolgreich entfernt. :-)<br>";
}

echo "<a href=\"javascript:history.back()\">zur&uuml;ck</a>&nbsp;|&nbsp;<a href=\"javascript:history.go(-2)\">Haupseite</a>";

?>