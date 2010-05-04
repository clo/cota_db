<?
echo "<html><head>";
echo "<meta http-equiv='cache-control' content='no-cache'>";
echo "<script language='JavaScript' src='js/cotadb.js' type='text/javascript'></script>\n";
echo "<link rel='stylesheet' href='adressdb.css'>";
echo "<title>CUP OF THE ALPS - Adressdatenbank</title>";
echo "</head>";

echo "<body>";
include("cfg/config.inc.php");
include("lib/db.class.php");
include("lib/html.class.php");
include("lib/lib.inc.php");
$db = new db();
if (empty($mode)){
  $refresh = "<td><a href='".getCurrentUrl()."'>Refresh</a></td>";
}else{
  $refresh = "";
}
echo "<table border='0' width='100%'>";
echo "<tr><td><h3>Adressdatenbank</h3></td>$refresh<td align='right'><img src='../images/logoklein_150px.gif' height='80' border='0'></td></tr>";
echo "<pre>DB Information:<br>";
printf("%-10s: %-20s<br>","host",$db->_host);
printf("%-10s: %-20s<br>","db",$db->_user);
printf("%-10s: %-20s<br>","User",$_SERVER['REMOTE_USER']);
echo "</pre>";
echo "<table>";

$db->connect();
$html = new html();
if (!isset($mode)){
	$mode = "view";
}
include("person_".$mode.".php");
$db->close();
echo "</body></html>";
?>