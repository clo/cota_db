<?
function replace(&$data,$str,$with){
	$newdata = array();
	foreach($data as $key => $val){
		$newkey = str_replace($str, $with, $key);
		$newdata[$newkey] = $val;
	}
  $data = $newdata;
	return $data;
}

function getDirContents($dir,$reg){
   ini_set("max_execution_time",10);
   if (!is_dir($dir)){die ("Error in function getDirContents: no directory: $dir!");}
   if ($root=@opendir($dir)){
       while ($file=readdir($root)){
           if($file=="." || $file==".."){continue;}
           if(is_dir($dir."/".$file)){
               $files=array_merge($files,GetDirContents($dir."/".$file));
           }else{
           	 	if (preg_match("/$reg/",$file)){
           			$files[]=$dir."/".$file;
           	 	}
           }
       }
   }
   if (!empty($files)){
     sort($files);
   }
   return $files;
}

function checkFormData($msg){
  
  return false;
}

function getKeys(&$spo_arr,$id){
  $aKat = array();
  foreach ($spo_arr as $val){
  	$aKat[$val[$id]] = $val[$id];
  }
  return $aKat;
}

function printSponsoren(&$spo_arr,&$kat_arr,$maxSponsorInRow){
  foreach ($spo_arr as $idk => $val){
    foreach ($kat_arr as $kategorieName){
      if (!isset($nrOfCol[$kategorieName])){
  	    $nrOfCol[$kategorieName] = 0;
      }
      if ($kategorieName == $val[3]){
        $nrOfCol[$kategorieName]++;
      }
    }
  }
  foreach ($kat_arr as $kategorieName){
    echo "<table width='98%' border=0>\n";
    echo "<tr><td align='center'><h4><b>$kategorieName</b></h4></td></tr>\n";
    echo "<br>";
    //echo "<tr><td>&nbsp;</td></tr>";
    echo "</table>";
    echo "<table width='98%' border=0>\n";
    $nrOfCol = count($spo_arr[$kategorieName]);
    $cnt = 1;
    foreach($spo_arr as $idk => $val){
      if ($kategorieName == $val[3]){
        $link = $val[1];
      	$img = "";
      	//ist bild vorhanden
      	if (!empty($val[0])){
      	  $img = "<img src='$val[0]' alt='$val[2]' border='0' title='$val[2]'>";
      	}
      	//ist link vorhanden
      	if (!empty($val[1])){
      	  $link = $val[1];
      	  if (!preg_match("/^http:\/\//",$val[1])){
      	    $link = "http://".$val[1];
      	  }
      	  if (!empty($img)){
      		$link = "<a href='$link' target='_new'>$img</a>";
      	  }else{
      		$link = "<a href='$val[1]' alt='$val[2]'  title='$val[2]' target='_new'>$val[2]</a>";
      	  }
      	}else{
      	  if (!empty($img)){
      	    $link = "<a href='$link' target='_new'>$img</a>";
      	  }else{
      		$link = $val[2];
      	  }
      	}
      				
      	if ($cnt == 1){
      	  echo "<tr>";
      	  $cnt = 1;
      	}
      	echo "<td align='center'>$link&nbsp;&nbsp;</td>\n";
      	if ($cnt >= $maxSponsorInRow){
      	  echo "</tr>";
      	  $cnt = 1;
      	}
      	$cnt++;
      }
    }
    echo "</table>\n";
  }
}


function getCurrentUrl(){
  return 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
}
?>
