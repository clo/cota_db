function exportsql(){
	var path = window.location.href;
	var path_arr = path.split("/");
	var newLink = "http:";
	var kat_str = "";
	var kat_arr = Array();
	for (var i=0; i<document.forms['geschichte'].elements['kat'].length; i++){
		if (document.forms['geschichte'].elements['kat'][i].selected == true){
			kat_arr[i] = document.forms['geschichte'].elements['kat'][i].name;
			//alert(kat_arr[i]);			
		}else{
			kat_arr[i] = "undef";
		}
	}
	kat_str = kat_arr.join(";");
	for (var i=1; i<path_arr.length-1; i++){
		newLink = newLink + "/" + path_arr[i];
	}
	newLink = newLink + "/";
	//prompt("", newLink);
	var col_arr = new Array();
	//alert("LENGTH: " + document.forms['geschichte'].elements['col'].length);
	for (var i=0; i<document.forms['geschichte'].elements['col'].length; i++){
		if (document.forms['geschichte'].elements['col'][i].selected == true){
			col_arr[i] = document.forms['geschichte'].elements['col'][i].name;
		}else{
			col_arr[i] = "undef";
		}
	}
	var col_str = col_arr.join(";");
	col_strNew = col_str.replace(/undef;/, "");
	//alert("STRING: " + col_strNew);
	//prompt("",newLink + "../lib/sql2xls.php?col=" + col_str);
	//window.open(link + "../lib/sql2xls.php?col=" + col,"Fenster1","width=310,height=400,left=0,top=0");
	location.href = newLink +  "../lib/sql2xls.php?col=" + col_strNew + "&kat=" + kat_str;
	//alert(kat_str);
	alert("Export erfolgreich ausgeführt.");
}

function createSQL(col){
  return "personendatenID";
}

function sitereload() {
	var akt = "";
	for (var i=0; i<document.forms['geschichte'].elements['akt'].length; i++){
		if (document.forms['geschichte'].elements['akt'][i].selected == true){
			akt = document.forms['geschichte'].elements['akt'][i].name;
		}
	}
	var link = location.href;
    link_arr = link.split("?");
    link = link_arr[0] + "?mode=form&export=export&akt=" + akt
    location.href = link 
}