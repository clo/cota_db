<?

class db {
  var $_host;
  var $_user;
  var $_pw;
  var $_db;
  var $_link;
  var $_local=false;

  function db(){
    if (!$this->_local){
      $this->_host = "mc-blatten.ch";
      $this->_user = "mcb_cota";
      $this->_pw = "w4ysad";
      $this->_db = "mcb_cotaadressen";
    }else{
      $this->_host = "localhost:3307";
	    $this->_user = "root";
	    $this->_pw = "sam1al";
      $this->_db = "mcb_cota";
    }
  }

  function getError($sql) {
  	$error = "";
    $error = mysql_error($this->_link);
    $errno = mysql_errno($this->_link);
    if (!empty($errno)) {
      $error = "ERROR:".$errno.": ".$error.$this->wrap.$sql.$this->wrap;
      return $error;
    }else{
      return "";
    }
  }

    function connect(){
    	$this->_link = mysql_connect($this->_host,$this->_user,$this->_pw);
        if (!$this->_link){
          $this->_link = mysql_connect("localhost:3307","root","sam1al");
        }
        mysql_selectdb($this->_db, $this->_link);
    }


    function execute($sql) {
      $res = mysql_query($sql, $this->_link);
      if (!$this->showError($sql)) {
        return $res;
      }else{
        return false;
      }
    }

    function showError($sql) {
      $error = mysql_error();
      $errno = mysql_errno();
      if (!empty($errno)) {
        echo "ERROR:".mysql_errno().": ".mysql_error() . "<br>".$sql."<br>\n";
        return true;
      }else{
        return false;
      }
    }

    function configure($host, $user, $pw, $db){
        $this->_host = $host;
        $this->_user = $user;
        $this->_pw   = $pw;
        $this->_db   = $db;
    }


    function close(){
        mysql_close($this->_link);
    }

    function log($uid,$adressid=0){
      $sql = "INSERT INTO log set datetime=NOW(),userid='".$uid."',adressid='".$adressid."'";
      $this->execute($sql);
    }

    function getAbfragen(){
      $abfragen = array();
      $abfragen[0] = "";
      $sql = "SELECT id, name FROM abfrage ORDER BY name ASC";
      $res = mysql_query($sql);
      while($row = mysql_fetch_row($res)){
        $abfragen[$row[0]] = $row[1];
      }
      return $abfragen;
    }

    function getTeams($year){
        $sql = "SELECT team, gruppe FROM team WHERE jahr='$year' ORDER BY idteam ASC";
        $res = mysql_query($sql, $this->_link) or die ("ERROR in query:<br>".$sql."<br>".mysql_error());
        while ($row = mysql_fetch_row($res)){
            $val[$row[0]] = $row[1];
        }
        return $val;
    }

    function getTeamInfo($id){
    	$sql = "SELECT
    			idteam,
    			team,
    			land,
    			link,
    			linkdetail,
    			jahr,
    			pfadmannschaftsfoto,
    			legendemannschaftsfoto,
    			vereinsinfo,
    			vereinsfarben,
    			vereinsadresse,
    			unterkunft,
    			jahr,
    			namebildgross,
    			betreuer1,
    			betreuer2
    	        FROM team
    	        WHERE idteam=".$id;
    	$res = $this->execute($sql);
    	$row = mysql_fetch_assoc($res);
    	mysql_free_result($res);
    	return $row;
    }

    function getBetreuerName($id){
    	$sql = "SELECT CONCAT(vorname,' ',name) FROM personendaten WHERE personendatenID=$id";
    	$res = $this->execute($sql);
    	$row = mysql_fetch_row($res);
    	mysql_free_result($res);
    	return $row[0];
    }

    function getAllTeams($year){
        $sql = "SELECT idteam, team, land, link, vereinsinfo FROM team WHERE jahr='$year' ORDER BY idteam";
        $res = mysql_query($sql, $this->_link) or die ("ERROR in query:<br>".$sql."<br>".mysql_error());
        while ($row = mysql_fetch_row($res)){
            $val[$row[0]]['name'] = $row[1];
            $val[$row[0]]['land'] = $row[2];
            $val[$row[0]]['link'] = $row[3];
            $val[$row[0]]['vereinsinfo'] = $row[4];
        }
        mysql_free_result($res);
        return $val;
    }

    function getTeamsIDOfGame($id){
        $sql = "SELECT idteam1, idteam2 FROM spiel WHERE idgame=$id";
        $res = $this->execute($sql);
        $row = mysql_fetch_row($res);
        mysql_free_result($res);
        return $row;
    }

    function isGroupDefined($year){
        $sql = "SELECT COUNT(gruppe) FROM team WHERE jahr='$year' AND gruppe!='0'";
        $res = $this->execute($sql);
        $row = mysql_fetch_row($res);
        mysql_free_result($res);
        if ($row[0] == 0){
            return false;
        }else{
            return true;
        }
    }

    function getAllGamesID($year,$art){
        $ret_val = array();
        $sql = "SELECT idgame,idteam1,idteam2 FROM spiel WHERE jahr=$year AND art='$art'";
        $res = $this->execute($sql);
        while ($row = mysql_fetch_row($res)){
            $ret_val[$row[0]] = array($row[0],$row[1],$row[2]);
        }
        mysql_free_result($res);
        return $ret_val;
    }

    function  areRefreesDefined($year){
        $sql = "SELECT idref FROM ref WHERE jahr='$year'";
        $res = mysql_query($sql);
        $nr = mysql_num_rows($res);
        mysql_free_result($res);
        if ($nr == 0){
            return false;
        }else{
            return true;
        }
    }

    function getTeamsInGroup($year){
        $group1 = array();
        $group2 = array();
        $sql = "SELECT team, idteam, link, linkdetail, vereinsinfo FROM team WHERE jahr='$year' AND gruppe='1' ORDER BY idteam";
        $res = $this->execute($sql);
        while ($row = mysql_fetch_row($res)){
            $group1[$row[1]] = array($row[0], $row[1], $row[2], $row[3], $row[4], 0);
        }
        mysql_free_result($res);
        $sql = "SELECT team, idteam, link, linkdetail, vereinsinfo FROM team WHERE jahr='$year' AND gruppe='2' ORDER BY idteam";
        $res = $this->execute($sql);
        while ($row = mysql_fetch_row($res)){
            $group2[$row[1]] = array($row[0], $row[1], $row[2], $row[3], $row[4], 0);
        }
        mysql_free_result($res);
        return array($group1, $group2);
    }

    function getRefrees($year){
        $ref = array();
        $sql = "SELECT idref, CONCAT(vorname, ' ', name) FROM ref WHERE FIND_IN_SET($year, jahr) ORDER BY vorname, name";
        $res = mysql_query($sql);
        while ($row = mysql_fetch_row($res)){
            $ref[$row[0]] = $row[1];
        }
        mysql_free_result($res);
        return $ref;
    }

    function showGames($year, $art, $condition){
        $sql = "SELECT COUNT(idgame) FROM spiel WHERE jahr=$year AND art='$art' AND anzeigen='ja'";
        $res = $this->execute($sql);
        $row = mysql_fetch_row($res);
        mysql_free_result($res);
        if ($row[0] == $condition){
            return true;
        }else{
            return false;
        }
    }

    function getGames($year, $art){
        $val = array();
        /*$sql = "SELECT
                g.idgame,
                g.spielnr,
                s.stadion,
                DATE_FORMAT(g.datum,'%d.%m.%Y'),
                TIME_FORMAT(g.zeit,'%H:%i'),
                t1.team,
                t2.team,
                g.tor1,
                g.tor2,
                IFNULL(g.bericht,'')
                FROM spiel g, team t1, team t2, stadion s
                WHERE 1
                AND t1.idteam = g.idteam1
                AND t2.idteam = g.idteam2
                AND s.idstadion = g.idstadion
                AND art='$art'
                AND anzeigen='ja'
                AND t1.jahr=$year
                ORDER BY g.spielnr ASC
                ";*/
        $sql = "SELECT
                g.idgame,
                g.spielnr,
                s.stadion,
                DATE_FORMAT(g.datum,'%d.%m.%Y'),
                TIME_FORMAT(g.zeit,'%H:%i'),
                t1.team,
                t2.team,
                g.tor1,
                g.tor2,
                IFNULL(g.bericht,'')
                FROM stadion s,spiel g LEFT JOIN team t1
                ON (t1.idteam = g.idteam1)
                LEFT JOIN team t2
                ON (t2.idteam = g.idteam2)
                WHERE 1
                AND s.idstadion = g.idstadion
                AND art='$art'
                AND anzeigen='ja'
                AND g.jahr=$year
                ORDER BY g.spielnr ASC
                ";
        $res = mysql_query($sql);
        while ($row = mysql_fetch_row($res)){
        	$val[$row[0]] = array($row[0], $row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9]);
        }
        mysql_free_result($res);
        return $val;
    }

    function getFinalGames($year){
    	$sql = "SELECT s.description,t1.team, t2.team, s.tor1, s.tor2
                FROM spiel s, team t1, team t2
                WHERE s.art = 'FINALSPIEL'
                AND s.jahr = '$year'
                AND t1.idteam = s.idteam1
                AND t2.idteam = s.idteam2";
    	$res = mysql_query($sql);
    	while ($row = mysql_fetch_row($res)){
    		$val[] = $row;
    	}
    	mysql_free_result($res);
    	return $val;
    }

    function getReport($idgame){
                $sql = "SELECT
        g.spielnr,
        s.stadion,
        DATE_FORMAT(g.datum,'%d.%m.%Y'),
        TIME_FORMAT(g.zeit,'%H:%i'),
        t1.team,
        t2.team,
        g.tor1,
        g.tor2,
        g.bericht
        FROM spiel g, team t1, team t2, stadion s
        WHERE 1
        AND t1.idteam = g.idteam1
        AND t2.idteam = g.idteam2
        AND s.idstadion = g.idstadion
        AND anzeigen='ja'
        AND idgame='$idgame'
        ORDER BY g.spielnr ASC
        ";
        $res = mysql_query($sql);
                while ($row = mysql_fetch_row($res)){
                        $val = array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7], $row[8]);
                }
                mysql_free_result($res);
                return $val;
    }

        function allGamesPlayed($year, $art, $nrOfGames, $group1, $group2){
                $sql = "SELECT COUNT(*) FROM spiel
                        WHERE art='$art'
                        AND jahr=$year
                        AND tor1 IS NOT NULL
                        AND tor2 IS NOT NULL";
                $res = mysql_query($sql);
                $row = mysql_fetch_row($res);
                mysql_free_result($res);
                if ($row[0] == $nrOfGames){
                        return true;
                }else{
                        return false;
                }
        }

  function getRanking($year, $art, &$group1, &$group2){
    if ($this->isRankEntered($year, $art)) {
        foreach ($group1 as $key => $team) {
            $points1[$team[1]] = $this->getPoints($team[1], $art);
        }
        arsort($points1);
        foreach ($group2 as $key => $team) {
            $points2[$team[1]] = $this->getPoints($team[1], $art);
        }
        arsort($points2);
        foreach ($group1 as $id => $info){
            for ($i=2; $i<count($info); $i++){
                $group1[$id][$i] = $points1[$id][$i-2];
            }
        }
        foreach ($group2 as $id => $info){
            for ($i=2; $i<count($info); $i++){
                $group2[$id][$i] = $points2[$id][$i-2];
            }
        }
        $this->sortArray($group1);
        $this->sortArray($group2);
    } else {
    }
  }

  function sortArray(&$group){
    foreach($group as $id => $team){
        $g[$id] = $team[2];
    }
    arsort($g);
    foreach($g as $id => $points){
        $group_new[$id] = array($group[$id][0], $group[$id][1], $group[$id][2], $group[$id][3], $group[$id][4], $group[$id][5] );
    }
    $group = $group_new;
  }

  function getPoints($team, $art){
    $sql = "SELECT
            idteam1,
            idteam2,
            tor1,
            tor2,
            IF(tor1=tor2,1,
                IF((idteam1='$team' AND tor1>tor2),3,
                    IF((idteam2='$team' AND tor2>tor1),3,0)
                )
            ) AS Pkt,
            IF(idteam1='$team',tor1,
                IF(idteam2='$team',tor2,0)
            ) AS tor,
            IF(idteam1='$team',tor2,
                IF(idteam2='$team',tor1,0)
            ) AS gegentor
            FROM spiel
            WHERE 1
            AND (idteam1='$team' OR idteam2='$team')
            AND (tor1 IS NOT NULL OR tor2 IS NOT NULL)
            AND art = '$art'
            ";
            //echo $sql."<br>";
            $res = mysql_query($sql);
            $points = 0;
            $spiel  = 0;
            $goal   = 0;
            $goalagainst = 0;
            while ($row = mysql_fetch_row($res)){
                $points += $row[4];
                $spiel++;
                $goal += $row[5];
                $goalagainst += $row[6];
            }
            mysql_free_result($res);
            return array($points, $spiel, $goal, $goalagainst);
  }

  function isRankEntered($year, $art){
    $sql = "SELECT
            IF(COUNT(*)=12,'true','false') AS result
            FROM team
            WHERE 1
            AND jahr='$year';";
    $res = mysql_query($sql);
    $row = mysql_fetch_row($res);
    return $row[0];
  }

        function getAllNews($show='ja',$year){
                if (empty($year)){
                  $year = date('Y');
                }
                $sql = "SELECT idnews, titel, REPLACE(inhalt,'\r\n','<br>'), DATE_FORMAT(ts_enter,'%d.%m.%Y')
                        FROM news
                        WHERE anzeigen='$show'
                        AND jahr='$year'
                        ORDER BY ts_enter DESC";
                $res = $this->execute($sql);
                $news = array();
                while ($row = mysql_fetch_row($res)){
                        $news[$row[0]]['titel'] = $row[1];
                        $news[$row[0]]['inhalt'] = $row[2];
                        $news[$row[0]]['datum'] = $row[3];
                }
                mysql_free_result($res);
                return $news;
        }

        function getColumnsInfos($table){
                $sql = "DESCRIBE $table";
                $res = $this->execute($sql);
                //$row = mysql_fetch_row($res);
                $ret_val = array();
                while ($row = mysql_fetch_assoc($res)){
                        $ret_val[] = $row;
                }
                mysql_free_result($res);
                return $ret_val;

        }

        function getColDescription($tbl,$col,$field){
  	      $sql = "DESCRIBE $tbl $col";
  	      $res = $this->execute($sql);
  	      $row = mysql_fetch_array($res);
  	      mysql_free_result($res);
  	      $error = $this->getError($sql);
  	      return array($row[$field],$error);
        }

        function getColLength($table){
                $col_arr = $this->getColumnsInfos($table);
                foreach ($col_arr as $key => $col) {
                        $sql = "SELECT DISTINCT `".$col['Field']."` FROM ".$table;
                        $res = $this->execute($sql);
                        $maxlen = 0;
                        while ($row = mysql_fetch_row($res)){
                                if (strlen($row[0]) > 0 ){
                                        $maxlen = strlen($row[0]);
                                }
                        }
                        $col_arr[$key]['MaxLength'] = $maxlen;
                }
                return $col_arr;
        }

        function select(&$col_arr, $table, $order, $where, $abfrageid=0){
                if (!in_array("*",$col_arr)){
                   if ($abfrageid <> 0){
                     $col = "p.personendatenid AS PersonendatenID";
                   }else{
                     $col = "PersonendatenID";
                   }
                   foreach ($col_arr as $val){
                     if (eregi("\.",$val)) {
                       // ` not needed
                       $col .= ",".$val;
                     }else{
                       $col .= ",`".$val."`";
                     }
                   }
                   //$col = "`".implode("`,`",$col_arr)."`";
                }else{
                  $col = implode(",",$col_arr);
                }
                if ($abfrageid <> 0 ){
                  $sql = $this->getSingleCol("abfrage","abfrage","id=$abfrageid");
                  $sql_new = str_replace("###COLUMNS###",$col,$sql);
                  $sql = $sql_new;
                }else{
                  $sql = "SELECT ".$col." FROM ".$table." WHERE 1 $where";
                }
                $res = $this->execute($sql);
                $ret_val = array();
                //if (mysql_num_rows($res) == 1){
                        //$ret_val = mysql_fetch_assoc($res);
                //}else {
                        while ($row = mysql_fetch_assoc($res)){
                                $ret_val[] = $row;
                        }
                //}
                mysql_free_result($res);
                return $ret_val;
        }

        function getKontakte(){
                $sql = "SELECT KontaktID, Kontaktperson FROM kontaktperson ORDER BY Kontaktperson";
                $res = $this->execute($sql);
                $ret_val = array();
                while ($row = mysql_fetch_row($res)){
                        $ret_val[$row[0]] = $row[1];
                }
                mysql_free_result($res);
                return $ret_val;
        }

		function getGeschichtsKategorien($year){
			$sql = "SELECT k.KategorieID, k.KategorieName
					FROM geschichte g, kategorien k
					WHERE g.KategorieID = k.KategorieID
					AND g.Jahr='$year'";
			$res = $this->execute($sql);
			$ret_val = array();
			while ($row = mysql_fetch_row($res)){
				$ret_val[$row[0]] = $row[1];
			}
			mysql_free_result($res);
			return $ret_val;
		}

        function getGeschichte($id){
                $sql = "SELECT
                        g.GeschichteID AS `GeschichteID`,
                        k.KategorieName AS `Kategorienname`,
                        g.Jahr AS `Jahr`,
                        g.Betrag AS `Betrag`,
                        g.Bemerkungen AS `Bemerkung`
                        FROM kategorien k, geschichte g
                        WHERE k.KategorieID = g.KategorieID
                        AND g.PersonendatenID ='$id'
                        ORDER BY Jahr ASC";
                $res = $this->execute($sql);
                $ret_val = array();
                while ($row = mysql_fetch_assoc($res)){
                        $ret_val[] = $row;
                }
                mysql_free_result($res);
                return $ret_val;
        }

        function getKatID($name){
        	$sql = "SELECT KategorieID FROM kategorien WHERE KategorieName='$name' LIMIT 1";
        	$res = $this->execute($sql);
        	$row = mysql_fetch_row($res);
        	mysql_free_result($res);
        	return $row[0];
        }

        function getKategorien(){
                $sql = "SELECT KategorieID, KategorieName FROM kategorien ORDER BY KategorieName";
                $res = $this->execute($sql);
                $ret_val = array();
                while ($row = mysql_fetch_row($res)){
                        $ret_val[$row[0]] = $row[1];
                }
                mysql_free_result($res);
                return $ret_val;
        }

        function createFilter(&$data,$keyword){
          if (is_null($data) or !isset($data)){
            return null;
          }
          $val = " AND ";
          foreach ($data as $key => $col){
            $val .= "`".$col."` LIKE '%".$keyword."%' OR ";
          }
          $val = substr($val,0,strlen($val)-3);
          return $val;
        }

        function areTeamLogosReady($col){
        	//$sql = "SELECT COUNT(*) FROM team WHERE ".$col." IS NOT NULL AND jahr=".date("Y");
        	$sql = "SELECT COUNT(*) FROM team WHERE ".$col." IS NOT NULL AND jahr=2007";
        	$res = $this->execute($sql);
        	$row = mysql_fetch_row($res);
        	if ($row[0] == 8){
        		return true;
        	}else{
        		return false;
        	}
        }

        function getOKStab($year){
        	if (!isset($year)){
        		$year = date("Y");
        	}
        	$sql = "SELECT p.personendatenID,p.vorname,p.name,p.funktion,p.`E-Mail`,namebildklein
        			FROM  `personendaten` p, geschichte g, kategorien k
					WHERE g.Jahr=".$year."
					AND k.kategorieName =  'OK-Stab'
					AND k.KategorieID=g.KategorieID
					AND p.personendatenID = g.personendatenid
					ORDER BY platzaufweb ASC";
			//echo $sql;
			$res = $this->execute($sql);
			$ret_val = array();
			while($row = mysql_fetch_row($res)){
				$ret_val[$row[0]] = array($row[1], $row[2], $row[3],$row[4],$row[5]);
			}
			mysql_free_result($res);
			return $ret_val;
        }

        function getSponsoren($year,$list,$order='') {
        	$ret_val = array();
        	$sql = "SELECT p.personendatenID, p.pfadlogo, p.Website, p.Firma, k.KategorieName, p.vorname, p.name, p.ort,g.Betrag, g.Bemerkungen FROM personendaten p, geschichte g, kategorien k
        			WHERE p.personendatenID=g.personendatenID
        			AND g.kategorieID=k.kategorieID
        			AND g.Jahr=$year
        			AND k.KategorieName IN ($list)
        			ORDER BY $order k.KategorieName, p.firma ASC, p.vorname ASC, p.name ASC";
        	//echo $sql;
        	$res = $this->execute($sql);
        	while ($row = mysql_fetch_row($res)){
        		$ret_val[$row[0]] = array($row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9]);
        	}
        	mysql_free_result($res);
        	return $ret_val;
        }

        function getShopArticle(){
          $retVal = array();
          $sql = "SELECT idartikel, artikel, beschrieb, FORMAT(preis,2) AS preis, picture, groesse,farbe " .
          		 "FROM shop_artikel " .
          		 "WHERE anzeigen='Ja' " .
          		 "ORDER BY position ASC";
          $res = $this->execute($sql);
          while ($row = mysql_fetch_assoc($res)){
          	$retVal[$row['idartikel']] = $row;
          }
          mysql_free_result($res);
          return $retVal;
        }

        function insertBestellung(&$aVal,$aFields){
          $fields = array();
          $values = array();
          foreach ($aVal as $key => $val){
          	if (in_array($key,$aFields)){
          	  $fields[] = $key;
          	  $values[] = $aVal[$key];
          	}else{
              if (!empty($aVal[$key]) && $key != "bestellen"){
          	    $bestellung .= $key." = ".$val."\n";
              }
          	}
          }
          $sql = "INSERT INTO shop_bestellung (`".implode("`,`",$fields)."`,`bestellung`,`bemerkung`,`ts_enter`) VALUES ('".implode("','",$values)."','$bestellung','$bemerkung',Now())";
          $this->execute($sql);
          return true;
        }

        function getSingleCol($table, $col, $condition){
          $sql = "SELECT $col FROM $table WHERE $condition";
          $res = $this->execute($sql);
          $row = mysql_fetch_row($res);
          return $row[0];
        }



}
?>
