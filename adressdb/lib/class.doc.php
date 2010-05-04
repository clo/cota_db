<?
class doc {
  var $path = "";
  
  function doc($path=""){
    $this->path=$path;
  }
  
  function getFolders($dir=null){
    if (empty($dir)){
    	$dir = $this->path;
    }
    if (is_dir($dir)){
      if ($dh = opendir($dir)) {
        $dir_arr = array();
        while (($file = readdir($dh)) !== false) {
          if (!eregi("\.|\.\.",$file)){
            $dir_arr[] = $file;
          }
        }
        closedir($dh);
      }
    }	 
    return $dir_arr;
  }
  
  function getFiles($dir=null){
    if (empty($dir)){
    	$dir = $this->path;
    }
    if (is_dir($dir)){
      if ($dh = opendir($dir)) {
        $file_arr = array();
        while (($file = readdir($dh)) !== false) {
          if ($file != ".." && $file != "."){
            $file_arr[] = $file;
          }
        }
        closedir($dh);
      }
    }	 
    return $file_arr;
  }
  
  function getInfoText($dir=null){
  	if (empty($dir)){
  	  $dir = $this->path;
  	}
    if (is_file($dir."/info.txt")){
      $fh = fopen($dir."/info.txt","r");
      $content = fread($fh, filesize($dir."/info.txt"));
      $file_arr = split("\n",$content);
      foreach($file_arr as $key => $val){
      	list($k,$v) = split("=",$val);
      	$info_arr[$k] = $v;
      }
      fclose($fh);
      return $info_arr;
    }else{
      return null;
    }
  }
  
  function docAvailable($dir=null){
  	if (empty($dir)){
  	  $dir = $this->path;
  	}
  	$available = false;
  	if (is_dir($dir)){
  	  if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
          if ($file != ".." && $file != "."){
            $available = true;
            return true;
            //break;
          }
        }
        closedir($dh);
      }else{
        echo "ERROR: docAvailable - Verzeichnis nicht vorhanden.";
  	  }
  	}
    return false;
  }
  
  function formatLinkName($link){
  	$newlink = str_replace("_"," ",$link);
  	return $newlink;
  }
}
?>