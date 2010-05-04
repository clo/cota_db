<?

class html {
  
  var $style = "style='width:200px'";


	function header($title,$bgcolor,$style, $js) {
		echo "<html>\n<head>\n";
		if (!empty($title) ) {
			$this->title($title);
		}
		echo "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>\n";
		if (!empty($style)) {
			echo "<link rel='stylesheet' href='$style' type='text/css'>";
		}
		if (!empty($js)) {
			echo "<script language='JavaScript' src='$js' type='text/javascript'></script>\n";
      echo "<script language='JavaScript' src='js/calendar1.js' type='text/javascript'></script>\n";
      echo "<script language='JavaScript' src='js/calendar2.js' type='text/javascript'></script>\n";
		}
		if (!empty($bgcolor)) {
			echo "<body bgcolor=$bgcolor>\n";
		} else {
			echo "<body>\n";
		}
	}

	function footer() {
		echo "</body>\n</html>\n";
	}

	function title($title) {
		echo "<title>".$title."</title>\n";
	}
	
	function image($src, $border, $title, $link, $target) {
		if (!empty($link)) {
			echo "<a href='$link'><img src='$src' border='$border' title='$title' target='$target'></a>\n";
		} else {
			echo "<img src='$src' border='$border' title='$title' target='$target'>\n";
		}
	}
	
function bold($str) {
	echo "<b>$str</b>";
}

function tableHeader($cellsp, $cellpad, $border, $width, $align) {
  echo "<table width='$width' cellspacing='$cellsp' cellpadding='$cellpad' border='$border' align='$align'>\n";
}
function tableHeaderNew($cellsp, $cellpad, $border, $width, $h, $align) {
    echo "<table width='$width' height='$h' cellspacing='$cellsp' cellpadding='$cellpad' border='$border' align='$align'>\n";
}

function tableRow_new($data, $sort, $dir, $action, $time, $idoffertype) {   
    global $html_tableHeaderColor, $html_tableRow1, $html_tableRow2, $view_sort;
    if (!empty($data)) {
      $nrOfRow = count($data);
      //print table headers
      $temp_key = array_keys($data);
      $header = array_keys($data[$temp_key[0]]);
      echo "<tr bgcolor='$html_tableHeaderColor'>\n";
      foreach($header as $h) {
        if (eregi("modify|view|delete",$h)){
          echo "<td><b>".$h."</b></td>\n";
        }else{
          if ($dir == "ASC" AND $sort == $h) {
            $image = "<image src='pic/asc_order.gif' border='0' title='$view_order_asc'>";
          }elseif($dir == "DESC" AND $sort == $h){
            $image = "<image src='pic/desc_order.gif' border='0' title='$view_order_desc'>";
          }else{
            $image = "";
          }
          echo "<td><b><a href='$action&sort=$h&dir=$dir&time=$time&idoffertype=$idoffertype' title='$view_sort&nbsp;$h'>".$h."</a></b>&nbsp;$image</td>\n";
        }
      }
      echo "</tr>\n";
    }//end if empty
    //print data
    $i=0; //needed for color alternating
    if (!empty($temp_key)) {
      foreach ($temp_key as $k => $value) {
          $in = $i%2;
          if ($in==0) {
            $col="bgcolor='$html_tableRow1'";
          }else{
            $col="bgcolor='$html_tableRow2'";
          }
          echo "<tr $col>\n";
          foreach ($data[$value] as $key => $val) {
			      echo "<td>".$val."</td>\n";
		      }
          echo "</tr>\n";
          $i++;
      }
    }//end if emtpy
  }

function tableRow($data, $sort, $dir, $action) {   
    global $html_tableHeaderColor, $html_tableRow1, $html_tableRow2, $view_sort;
    if (!empty($data)) {
      $nrOfRow = count($data);
      //print table headers
      $temp_key = array_keys($data);
      $header = array_keys($data[$temp_key[0]]);
      echo "<tr bgcolor='$html_tableHeaderColor'>\n";
      foreach($header as $h) {
        if (eregi("modify|view|delete",$h)){
          echo "<td><b>".$h."</b></td>\n";
        }else{
          if ($dir == "ASC" AND $sort == $h) {
            $image = "<image src='pic/asc_order.gif' border='0' title='$view_order_asc'>";
          }elseif($dir == "DESC" AND $sort == $h){
            $image = "<image src='pic/desc_order.gif' border='0' title='$view_order_desc'>";
          }else{
            $image = "";
          }
          echo "<td><b><a href='$action&sort=$h&dir=$dir' title='$view_sort&nbsp;$h'>".$h."</a></b>&nbsp;$image</td>\n";
        }
      }
      echo "</tr>\n";
    }//end if empty
    //print data
    $i=0; //needed for color alternating
    if (!empty($temp_key)) {
      foreach ($temp_key as $k => $value) {
          $in = $i%2;
          if ($in==0) {
            $col="bgcolor='$html_tableRow1'";
          }else{
            $col="bgcolor='$html_tableRow2'";
          }
          echo "<tr $col>\n";
          foreach ($data[$value] as $key => $val) {
			      echo "<td>".$val."</td>\n";
		      }
          echo "</tr>\n";
          $i++;
      }
    }//end if emtpy
}

  
  function tableTitle($title) {
    echo "<tr>\n";
    for ($i=0; $i<count($title); $i++) {
        echo "<td><b>".$title[$i]."</b></td>\n";
    }
    echo "</tr>\n";
  }

	function tableFooter() {
		echo "</table>\n";
	}

	function formHeader($name, $action, $id='') {
		if (!empty($id)){
		  $id="id='$id'";
		}
		echo "<form $id name='$name' action='$action' method='post'>\n";
	}
	
    function formHeaderJS($name, $action, $js) {
      echo "<form name='$name' action='$action' method='post' $js>\n";
    }
    
    function formHeaderNew($name, $action, $target) {
      echo "<form name='$name' action='$action' method='post' target='$target'>\n";
    }
	
    function formFooter() {
	  echo "</form>\n";
	}

	function hr($width, $align, $color) {
	    echo "<hr width='$width' align='$align' color='$color' noshade >\n";
	}

	function inSelect($name, $data) {
		echo "<select name='$name'>\n";
		for ($i=0; $i < count($data); $i++) {
			echo "<option value='".key($data[$i])."'>$data[$i]\n";
		}
		echo "</select>";
	}
	
	function inSelect_new($name, &$data, $setvalue, $style="") {
		echo "<select name='$name' id='$name' $style>\n";
		foreach ($data as $key => $val) {
			if ($setvalue == $key){
				echo "<option value='".$key."' selected>$data[$key]</option>\n";
			}else{
				echo "<option value='".$key."'>$data[$key]</option>\n";
			}
		}
		echo "</select>\n";
	}

	function inTextareaTable($descr, $name, $value="") {
		echo "<tr>\n";
		echo "<td>".$descr.":</td>\n";
		echo "<td><textarea name='$name'>$value</textarea></td>\n";
		echo "</tr>\n";
	}

	function inText($name, $value) {
		echo "<input type='text' name='$name' value='$value'>\n";
	}

	function inTextTable($descr, $name, $value, $error="") {
		if (!empty($error)){
		  $err = "<td nowrap align='left'>&nbsp;";
		  $err .= $error;
		  $err .= "</td>";
		  $class = "class='inputerr'";
		}
		$this->tr();
		$this->td();
		echo $descr;
		$this->tde();
		$this->td();
		echo "<input $class type='text' name='$name' value='$value' $this->style>\n";
		$this->tde();
		echo $err;
		$this->tre();
	}
	
	function tr(){
	  echo "<tr>";
    }
	
    function tre(){
	  echo "</tr>\n";
    }
	
    function td($align='left',$halign='top'){
	  echo "<td align='$align' halign='$halign'>";
    }
	
    function tde(){
	  echo "</td>\n";
    }
	
	function inHidden($name, $value) {
		echo "<input type='hidden' name='$name' value='$value'>\n";
	}

	function inSelectTable($descr, $name, $val_arr, $def_value) {
		echo "<tr>\n";
		echo "<td>".$descr.": </td><td>";
		echo "<select name='$name' $this->style>\n";
		foreach ($val_arr as $key => $value) {
			$sel = "";
			if (!empty($def_value)) {
				if ($def_value == $key) {
					$sel = "selected";
				}
			}
			echo "<option value='$key' $sel>$value</option>\n";
		}
		echo "</select>\n";
		echo "</td><tr>\n";
	}
	
  function inSelectListTable($descr, $name, $val_arr, $def_value){
    echo "<tr>\n";
    echo "<td valign='top'>".$descr.": </td><td>";
    echo "<select name='$name' $this->style size='5' multiple='multiple'>\n";
    foreach ($val_arr as $key => $value) {
      echo $key;
      if (!empty($def_value)){
        if (in_array($value, $def_value)) {
          $sel = "selected";
        }else{
          $sel = "";
        }
      }else{
        $sel = "selected";
      }
      echo "<option value='$value' $sel>$value $def_value[$key]</option>\n";
    }
    echo "</select>\n";
    echo "</td><tr>\n";
  }

	/*function inSelect($name, $val_arr) {
		echo "<select name='$name'>\n";
		echo "<pre>";
		var_dump($val_arr);
		echo "</pre>";

		foreach ($val_arr as $key => $value) {
			echo "<option value='$key'>$value[0]\n";
		}
		echo "</select>\n";
	}*/

	function inSubmit($name, $value) {
		echo "<input type='submit' name='$name' value='$value'>\n";
	}
    
  function inSubmitJS($name, $value, $action) {
    echo "<input $action type='submit' name='$name' value='$value'>\n";
  }
    
  function inSubmitTable($descr, $name, $value){
     echo "<tr>\n";
     echo "<td>$descr</td>";
     echo "<td><input type='submit' name='$name' value='$value'></td>\n";
     echo "</tr>";
  }
    
  function inImage($img, $border, $width, $height) {
    echo "<input type='image' src='$img' border='$border' width='$width' height='$height'>\n";
  }

	function inReset($val) {
		list($name, $value) = split(";", $val);
		echo "<input type='reset' name='$name' value='$value'>\n";
	}
    
  function inResetTable($descr, $name, $value){
    echo "<tr>\n";
    echo "<td>$descr</td>";
    echo "<td><input type='reset' name='$name' value='$value'></td>\n";
    echo "</tr>";
  }
  
  function inPasswordTable($descr, $name, $value){
    echo "<tr>\n";
    echo "<td>$descr</td>";
    echo "<td><input type='password' name='$name' value='$value' $this->style></td>\n";
    echo "</tr>";
  }

	function printArrayAsTable($val_arr) {
		foreach ($val_arr as $key => $value) {
			echo "<tr><td><b>$key:</b></td><td>$value</td></tr>\n";
		}
	}

	function inButtonTable($val_arr) {
		echo "<tr>\n";
	 	if (isset($val_arr["Title"])) {
			echo "<td>".$val_arr["Title"].":</td>\n";
		}
	 	if (isset($val_arr["Submit"])) {
		 	echo "<td>";
		 	echo $this->inSubmit($val_arr["Submit"]);
		 	echo "\n";
		} else {
			echo "<td>\n";
		}
	 	if (isset($val_arr["Reset"])) {
		 	$this->inReset($val_arr["Reset"]);
		 	echo "</td>\n";
		} else {
			echo "</td>\n";
		}
		echo "</tr>\n";
	}

	function link($link, $descr, $target) {
		echo "<a href='$link' target='$target'>".$descr."</a>\n";
	}
    
  function linkJS ($link, $descr, $target, $action){
    echo "<a $action=\"$link\" href='' >$descr</a>\n";
  }
    
  function linkImage($link, $src, $descr) {
     echo "<a href='$link' title='$descr'><img src='$src' border='0'></a>\n";
  }
  
  function br(){
    echo "<br>\n";
  }

	function table($data_arr, $space, $padding, $border, $ev, $color) {
		echo "<table onLoad=\"location.reload(true)\" border='$border' cellpadding='$padding' cellspacing='$space'>\n";
		//todo:show table header
		echo "<tr>\n";
		foreach ($data_arr[4] as $key => $value) {
			if (!eregi("nv_", $key)) {
				echo "<td><b>\n";
				//echo "$key => $value<br>";
				echo strtoupper($key)."\n";
				echo "</b></td>\n";
			}
		}
		echo "</tr>\n";

		//show table data
		foreach ($data_arr as $key => $value) {
			if (!empty($ev)) {
				$id = $data_arr[$key]['IDRelease'];
				$ev = "onDblClick=\"javascript:goForm('$id')\"";
			}
			$bgcolor = "bgcolor='".$data_arr[$key]['nv_Color']."'";
			echo "<tr $bgcolor $ev>\n";
			foreach ($data_arr[$key] as $k => $v) {

				if (!eregi("nv_", $k)) {
					echo "<td>".$data_arr[$key][$k]."</td>\n";
				}
			}
			echo "</tr>\n";
		}
		echo "</table>\n";
	}
	function headline($title, $h) {
		echo "<$h>\n";
		echo "$title\n";
		echo "</$h>\n";
	}

	function go($page) {
		echo "<a href=\"javascript:history.go($page)\">back</a>";
	}

	function getNrOfCol($col) {
		$col_arr = split(",", $col);
		$nrOfCol = count($col_arr);
		return $nrOfCol;
	}
    
  function dump($var) {
    echo "<pre>\n";
    var_dump($var);
    echo "</pre>\n";
  }
  
  function showOfferDetails($d, $id) {
    global $form_enteroffer, $form_salesperson, $form_seller, $form_site, $form_country,
           $form_region, $form_enterdate, $form_customerinfo, $form_clientnr, $form_parent,
           $form_businessperiod, $form_client, $form_inter, $form_opendate, $form_address,
           $form_pripub, $form_closedate, $form_city, $form_caterer, $form_prob, 
           $form_offerinfo, $form_customertype, $form_gainreason, $form_gainedfrom, 
           $form_offertype, $form_invest, $form_annualprofit, $form_country, $form_region,
           $form_region, $form_customid, $form_loginid;
    $width="100%";
    $html = new html();
    $html->tableHeader(2,0,0,$width,"");  //$cellsp, $cellpad, $border 
    echo "<tr>";
    echo "<td colspan='3'>".$html->bold($form_salesperson)."</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>$form_seller:&nbsp;".$d[$form_seller]."&nbsp;(".$d[$form_loginid].")</td>";
    echo "<td>$form_site:&nbsp;".$d[$form_site]."</td>";
    echo "<td>$form_country:&nbsp;".$d[$form_country]."</td>";
    echo "<td>$form_region:&nbsp;".$d[$form_region]."</td>";
    
//todo: data can be found out over several tables GRRRRR!
//    echo "<td>$form_site</td><td>".$d[$form_site]."</td>";
//    echo "<td>$form_country</td><td>".$d[$form_country]."</td>";
//    echo "<td>$form_region</td><td>".$d[$form_region]."</td>";
    echo "<td>$form_enterdate</td><td>".$d[$form_enterdate]."</td>";
    echo "</tr>";
    $html->tableFooter();
    $html->hr($width, "left", "");  //color works only for IE
    $html->tableHeader(2,0,0,$width,"");
    echo "<tr>";
    echo "<td colspan='3'>".$html->bold($form_customerinfo);
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>$form_clientnr</td><td>".$d[$form_clientnr]."</td>";
    echo "<td>$form_parent</td><td>".$d[$form_parent]."</td>";
    echo "<td>$form_businessperiod</td><td>".$d[$form_businessperiod]."</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>$form_client</td><td><b>".$d[$form_client]."</b></td>";
    echo "<td>$form_inter</td><td>".$d[$form_inter]."</td>";
    echo "<td>$form_opendate</td><td>".$d[$form_opendate]."</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>$form_address</td><td>".$d[$form_address]."</td>";
    echo "<td>$form_pripub</td><td>".$d[$form_pripub]."</td>";
    echo "<td>$form_closedate</td><td>".$d[$form_closedate]."</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>$form_city</td><td>".$d[$form_city]."</td>";
    echo "<td>$form_caterer</td><td>".$d[$form_caterer]."</td>";
    echo "<td>$form_prob</td><td>".$d[$form_prob]."</td>";
    echo "</tr>";
    $html->tableFooter();
    $html->hr($width, "left", "");  //color works only for IE
    $html->tableHeader(2,0,0,$width,"");
    echo "<tr>";
    echo "<td colspan='3'>".$html->bold($form_offerinfo)."</td>";
    echo "</tr>";
    
    // **** offertype ****
    $offertype = getOfferProcess($id);
    getOfferType($offertype_arr);
    echo "<tr valign='top'><td rowspan='9'>$form_offertype</td><td>\n";
    $html->tableHeader(2,0,0,$width,"");
    if (!empty($offertype)) {
      foreach($offertype as $otid => $date){
        echo "<tr><td>$offertype_arr[$otid]</td><td>$date</td></tr>";
      }
    }else{
        echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
    }
    $html->tableFooter();
    echo "</td>";
    //echo "<td>$form_offertype</td><td>".$d[$form_offertype]."</td>";
    // **** customertype ****
    echo "<td>";
    $html->tableHeader(2,0,0,$width,"");
    echo "<tr><td>$form_customertype</td><td>".$d[$form_customertype]."</td></tr>";
    
    // **** gainreason ****
    echo "<tr><td>$form_gainreason</td><td>".$d[$form_gainreason]."</td></tr>";
    // **** gainlostsite ****
    echo "<tr><td>$form_gainedfrom</td><td>".$d[$form_gainedfrom]."</td></tr>";
    // ----- invest according precalculation -----
    echo "<tr><td>$form_invest</td><td>".$d[$form_invest]."</td></tr>";    
    // ----- annual profit % invest according precalculation -----
    echo "<tr><td>$form_annualprofit</td><td>".$d[$form_annualprofit]."</td></tr>";
    // ----- show custom id of the offer -----
    echo "<tr><td>$form_customid</td><td>".$d[$form_customid]."</td></tr>";
    $html->tableFooter();
    echo "</td>";
    $html->tableFooter();
    
    $html->hr($width, "left", "");  //color works only for IE
    
  }
  
  function showOfferEquipment($d) {
    global $form_machinetype, $form_marketsector, $form_businesstype, $form_nomach,
         $form_transactions, $form_sale, $form_rental, $form_products, $form_business,
         $form_economy, $form_services, $form_invest, $form_remark, $form_annualsale,
         $html_tableRow2;
    $width="100%";
    $i = 1;
    $html = new html();
    if (!empty($d)) {
      foreach ($d as $id => $val) {
        //intialize v
        $v['nomach']=$val[$form_nomach];
        $v['machinetype']=$val[$form_machinetype];
        $v['transactions']=$val[$form_transactions];
        $v['sale']=$val[$form_sale];
        $v['rental']=$val[$form_rental];
        $v['products']=$val[$form_products];
        $v['business']=$val[$form_business];
        $v['economy']=$val[$form_economy];
        $v['services']=$val[$form_services];
        $v['anualsale']=$val[$form_annualsale];
        $v['invest']=$val[$form_invest];
        $v['remark']=$val[$form_remark];
        $v['annualsale']=$val[$form_annualsale];
        $v['marketsector']=$val[$form_marketsector];
        $v['businesstype']=$val[$form_businesstype];
        $v['machinetype']=$val[$form_machinetype];
        $html->tableHeader(2,1,0,$width,"");
        $col = "bgcolor=$html_tableRow2";
        echo "<tr>";
        echo "<td rowspan='7' width='10' valign='top'><b>".$i."</b></td>";
        echo "<td $col>$form_nomach<br>$v[nomach]</td>\n";
        echo "<td $col>$form_machinetype<br>$v[machinetype]</td>\n";
        echo "<td $col width='10%'>$form_transactions<br>$v[transactions]</td>\n";
        echo "<td $col width='10%'>$form_sale<br>$v[sale]</td>\n";
        echo "<td $col width='10%'>$form_rental<br>$v[rental]</td>\n";
        echo "<td $col width='10%'>$form_products<br>$v[products]</td>\n";
        echo "<td $col width='10%'>$form_business<br>$v[business]</td>\n";
        echo "<td $col width='10%'>$form_economy<br>$v[economy]</td>\n";
        echo "<td $col width='10%'>$form_services<br>$v[services]</td>\n";
        echo "</tr>";
        echo "<tr>";
        echo "<td $col colspan='2'>$form_marketsector<br>";
        echo "$v[marketsector]";
        echo "</td>";
        echo "<td colspan='5'>&nbsp;</td>";
        //echo "<td $col colspan='3'>$form_invest<br>$v[invest]</td>";
        echo "<td $col colspan='3'>$form_annualsale<br>$v[annualsale]</td>";
        //echo "<td>$form_gainedfrom</td><td><input type='text' name='v[$i][gainedfrom]' value='$gainedfrom'></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td $col colspan='2'>$form_businesstype<br>";
        echo "$v[businesstype]";
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td $col colspan='2'>$form_remark</td>";
        echo "</tr>";
        echo "<tr><td $col colspan='2'>$v[remark]&nbsp;</td><tr>";
        $html->tableFooter();
        $html->hr($width, "left", "");  //color works only for IE
        $i++;
      } //end foreach
    }//end if empty
    $html->hr($width, "left", "");  //color works only for IE
  }
  
  function showCustomerDetails($d) {
    global $form_clientnr, $form_parent, $form_client, $form_token, $form_zip,
           $form_city, $form_address, $form_contactpersonname, $form_phone, $form_fax,
           $form_email, $form_language, $form_caterer, $form_inter, $form_pripub;
    $html = new html();
    $html->tableHeader(2,1,0,"","");
    //Customernumber
    echo "<tr>";
    echo "<td>$form_clientnr:</td><td>$d[$form_clientnr]</td>";
    echo "</tr>";
    //parentnumber
    echo "<tr>";
    echo "<td>$form_parent:</td><td>$d[$form_parent]</td>";
    echo "</tr>";
    //Customername
    echo "<tr>";
    echo "<td>$form_client:</td><td><b>$d[$form_client]</b></td>";
    echo "</tr>";
    echo "<tr>";
    //Token
    echo "<tr>";
    echo "<td>$form_token:</td><td>$d[$form_token]</td>";
    echo "</tr>";
    echo "<tr>";
    //address
    echo "<tr>";
    echo "<td>$form_address:</td><td>$d[$form_address]</td>";
    echo "</tr>";
    //zip city
    echo "<tr>";
    echo "<td>$form_zip/$form_city:</td><td>$d[$form_zip] $d[$form_city]</td>";
    echo "</tr>";
    //contactperson
    echo "<tr>";
    echo "<td>$form_contactpersonname:</td><td>$d[$form_contactpersonname]</td>";
    echo "</tr>";
    //Phonenumber
    echo "<tr>";
    echo "<td>$form_phone:</td><td>$d[$form_phone]</td>";
    echo "</tr>";
    //Faxnumber
    echo "<tr>";
    echo "<td>$form_fax:</td><td>$d[$form_fax]</td>";
    echo "</tr>";
    //Email
    echo "<tr>";
    echo "<td>$form_email:</td><td>$d[$form_email]</td>";
    echo "</tr>";
    //Language
    $lan_arr = getLanguage();
    echo "<tr>";
    echo "<td>$form_language:</td><td>$d[$form_language]</td>";
    echo "</tr>";
    //interantional customer
    echo "<tr>";
    echo "<td>$form_inter:</td><td>$d[$form_inter]</td>";
    echo "</tr>";
    //Privat/public customer
    echo "<tr>";
    echo "<td>$form_pripub:</td><td>$d[$form_pripub]</td>";
    echo "</tr>";
    //caterer
    echo "<tr>";
    echo "<td>$form_caterer:</td><td>$d[$form_caterer]</td>";
    echo "</tr>";
    $html->tableFooter();
    //$html->linkImage("javascript:history.go(-1)", "pic/back.gif", "");

  }
  
  function showoffercalculation($d) {
    global $form_transactions, $form_sale, $form_rental, $form_products,
           $form_business, $form_economy, $form_services, $form_invest, 
           $form_annualsale, $form_nomach, $html_tableRow2, $form_calculation,
           $form_ytdsales, $form_annualprofit, $form_annualprofitbuseco,
           $form_ytdprofit,$form_totalannualprofit,$form_annualprofit1;
    $width="100%";
    if (!empty($d)) {
      //intialize v
      $v['nomach']=$d[$form_nomach];
      $v['transactions']=$d[$form_transactions];
      $v['sale']=$d[$form_sale];
      $v['rental']=$d[$form_rental];
      $v['products']=$d[$form_products];
      $v['business']=$d[$form_business];
      $v['economy']=$d[$form_economy];
      $v['services']=$d[$form_services];
      $v['anualsale']=$d[$form_annualsale]; //todo: calculate
      //$v['invest']=$d[$form_invest];
      $v['ytdsales']=$d[$form_ytdsales];
      $v['ytdprofit']=$d[$form_ytdprofit];
      $v['anualprofit']=$d[$form_annualprofit];
      $v['anualprofit1']=$d[$form_annualprofit1];
      $v['totalannualprofit']=$d[$form_totalannualprofit];
      $html = new html();
      $html->tableHeader(2,1,0,$width,"");
      echo "<tr><td colspan='3'>".$html->bold($form_calculation)."</td></tr>";
      $col = "bgcolor=$html_tableRow2";
      echo "<tr>";
      echo "<td $col>$form_nomach<br>$v[nomach]</td>\n";
      echo "<td $col>$form_machinetype<br>$v[machinetype]</td>\n";
      echo "<td $col>$form_transactions<br>$v[transactions]</td>\n";
      echo "<td $col>$form_sale<br>$v[sale]</td>\n";
      echo "<td $col>$form_rental<br>$v[rental]</td>\n";
      echo "<td $col>$form_products<br>$v[products]</td>\n";
      echo "<td $col>$form_business<br>$v[business]</td>\n";
      echo "<td $col>$form_economy<br>$v[economy]</td>\n";
      echo "<td $col>$form_services<br>$v[services]</td>\n";
      echo "</tr>";
      echo "<tr>";
      echo "<td $col colspan='2'>$form_annualsale<br>";
      echo "$v[anualsale]";
      echo "</td>";
      echo "<td colspan='2'>&nbsp;</td>";
      
      echo "<td $col colspan='2'>$form_annualprofit1<br>";
      echo "$v[anualprofit1]";
      echo "</td>";
      echo "<td colspan='1'>&nbsp;</td>";
//    echo "<td $col colspan='2'>$form_annualprofitbuseco<br>";
//    echo "$v[anualprofitbuseco]";
//    echo "</td>";
      echo "<td $col colspan='3'>$form_totalannualprofit<br>$v[anualprofit]</td>";
      //echo "<td>$form_gainedfrom</td><td><input type='text' name='v[$i][gainedfrom]' value='$gainedfrom'></td>";
      echo "</tr>";
      echo "<tr>";
      echo "<td $col colspan='2'>$form_ytdsales<br>";
      echo "$v[ytdsales]";
      echo "</td><td colspan='5'>&nbsp;</td>";
      echo "<td $col colspan='2'>$form_ytdprofit<br>$v[ytdprofit]</td>";
      //echo "<td>&nbsp;</td>";
      //echo "<td $col colspan='3'>$form_invest<br>$v[invest]</td>";
      echo "</tr>";
      $html->tableFooter();
      $html->hr($width, "left", "");  //color works only for IE
    } 
  }//end if empty

  function printTableHeader(&$data){
    $refkey = $this->getValidKey($data);
    $aKey = $this->getKeysOfArray($data[$refkey]);
    echo "<tr>";
    foreach ($aKey as $key => $col ) {
      echo "<td><b>".strtoupper($col)."</b></td>";
    }
    echo "</tr>";
  }

  function getKeysOfArray($data){
    
    return array_keys($data);
  }

  function getValidKey($data){
    foreach ($data as $key => $data){
      return $key;    
    }
  }
}

?>