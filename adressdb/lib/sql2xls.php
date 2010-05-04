<?php
//Written by Dan Zarrella. Some additional tweaks provided by JP Honeywell
//pear excel package has support for fonts and formulas etc.. more complicated
//this is good for quick table dumps (deliverables)

include("db.class.php");
error_reporting(0);
$db = new db();
$db->connect();
$cols = $GLOBALS[col];
$cols = str_replace("undef;", "", $cols);
$cols = str_replace(";undef", "", $cols);
$cols = "p.`" . str_replace(";","`,p.`",$cols) . "`";
$kat = $GLOBALS[kat];
$kat = str_replace("undef;", "", $kat);
$kat = str_replace(";undef", "", $kat);
$kat = str_replace(";","`,`",$kat);
$katID = $db->getKatID($kat);
$sql = "SELECT ".$cols." FROM 
		personendaten p, kategorien k, geschichte g 
		WHERE k.KategorieID=$katID 
		AND g.Jahr=".date("Y")."
		AND p.PersonendatenID = g.PersonendatenID
		AND k.KategorieID = g.KategorieID";
//echo $sql;
$result = $db->execute($sql);
$count = mysql_num_fields($result);
$tag = ";";
for ($i = 0; $i < $count; $i++){
    $header .= mysql_field_name($result, $i).$tag;
}

while($row = mysql_fetch_row($result)){
  $line = '';
  foreach($row as $value){
    if(!isset($value) || $value == ""){
      $value = $tag;
    }else{
# important to escape any quotes to preserve them in the data.
      $value = str_replace('"', '""', $value);
# needed to encapsulate data in quotes because some data might be multi line.
# the good news is that numbers remain numbers in Excel even though quoted.
      $value = '"' . $value . '"' . $tag;
    }
    $line .= $value;
  }
  $data .= trim($line)."\n";
}
# this line is needed because returns embedded in the data have "\r"
# and this looks like a "box character" in Excel
  $data = str_replace("\r", "", $data);


# Nice to let someone know that the search came up empty.
# Otherwise only the column name headers will be output to Excel.
if ($data == "") {
  $data = "\nno matching records found\n";
}

# This line will stream the file to the user rather than spray it across the screen
header("Content-type: application/octet-stream");

# replace excelfile.xls with whatever you want the filename to default to
header("Content-Disposition: attachment; filename=cota_export_".date("d.m.Y").".xls");
header("Pragma: no-cache");
header("Expires: 0");

echo $header."\n".$data;
$db->close();
?> 