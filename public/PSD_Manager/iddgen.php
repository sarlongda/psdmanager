<?php
 
function checknumber($id) {
  //Function that calculates checknumber
  //input: any number/string
  //output: corresponding checknumber
  $p = 7;
  $sum = 0;
 
   for($i=0; $i < strlen($id); $i++) {
     $char = $id{$i};
     
     if($char >= '0' && $char <= '9')
     $int = intval($char);
     else
     //Converting letters to integers (A = 10, B = 11, ...)
     $int = ord($char)-55;
     
     //Multiplication with 7, 1, 3
     $sum += $int*$p;
     
     if($p==1)
     $p=7;
     else if($p==3)
     $p=1;
     else if($p==7)
     $p=3;
   }
 //checknumber = last number of the sum  
 $checknumber = substr(strval($sum), -1);
 return $checknumber;
}

function specialchars($string) {
	//function that replaces umlauts, necessary in machine readable area
	$search = array("Ä", "Ö", "Ü", "ä", "ö", "ü", "ß");
	$replace = array("AE", "OE", "UE", "ae", "oe", "ue", "ss");
	return str_replace($search, $replace, $string);
}
?>
 
 
<!-- CSS -->
<style>
label {
	display: inline-block;
	width: 300px;
	text-align: right;
}
input {
	width: 400px;
}
input#submit {
	width: 710px;
}
input[type=button] {
	width: auto;
}
p#error {
	color: red;
}
span#seperation {
	-webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
</style>

<!-- Generator -->
<div style="font-family: Courier New">
<h1> German ID-Number Generator </h1><br>
<form action="?gen=1" method="post">
<label for="zip_aic">Zipcode OR Authority Ident Code</label>
<input type="text" maxlength="5" name="zip_aic" value="<?php echo isset($_POST['zip_aic']) ? $_POST['zip_aic'] : '' ?>"/><br>
<label for ="serial_no"> Sequential Number:</label>
<input id = "serial_no" type="text" maxlength="5" name="serial_no" width="250px" value="<?php echo isset($_POST['serial_no']) ? $_POST['serial_no'] : '' ?>"/> <input type="button" value="Random" onclick=random() /><br>
<label for ="dob"> DOB (DD.MM.YY):</label>
<input type="text" maxlength="8" name="dob" value="<?php echo isset($_POST['dob']) ? $_POST['dob'] : '' ?>"/><br>
<label for ="expiry"> Eypiry Date (DD.MM.YY):</label>
<input type="text" maxlength="8" name="expiry" value="<?php echo isset($_POST['expiry']) ? $_POST['expiry'] : '' ?>"/><br>
<label for="name"> Name:</label>
<input type="text" maxlength="100" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '' ?>"/><br>
<input id="submit" type="submit" value="Generate">
</form>
</div>

<script>
  function random() {
	var rand = "";
	var charset = "CDFGHJKLMNPRTVWXYZ0123456789";
	for (var i = 0; i < 5; i++)
		rand += charset.charAt(Math.floor(Math.random() * charset.length))
	document.getElementById("serial_no").value = rand;
  }
	
</script>
<br><hr>
<?php

//Evaluation
if(isset($_GET['gen'])) {
  $addr = "f:/htdocs/psdmanager/public/Test/PSD_TEST.exe test test test";
  exec($addr, $output, $return);
  // Read Vars
  $zip_aic = $_POST['zip_aic'];
  $serial = $_POST['serial_no'];
  $dob = $_POST['dob'];
  $dob_split = explode(".", $dob);
  $expiry = $_POST['expiry'];
  $expiry_split = explode(".", $expiry);
  $name = $_POST['name'];
  $name_split = explode(" ", $name);
  
  // Calculate random serial number (downright)
  $random_serial = rand(100000, 999999);
  
  //Read Database of Authority Ident Codes, Identifiers: 'AIC', 'ZIP', 'AUTHORITY' 
  //Example: $aic[n]['IDENTIFIER'] => $aic[1]['ZIP']
  $aic_list = array_map('str_getcsv', file('aic.csv'));
  array_walk($aic_list, function(&$a) use ($aic_list) {
	  $a = array_combine($aic_list[0], $a);
  });
  array_shift($aic_list);
  
  if(strlen($zip_aic) == 4 && substr($zip_aic, 0, 1) == 'L') {
	  $aic = $zip_aic;
	  for ($i = 0; $i <= sizeof($aic_list)-1; $i++) {
		$authority_pos = strpos($aic_list[$i]['AIC'], $aic);
		 if (is_int($authority_pos) == TRUE) {
			 $authority = $aic_list[$i]['AUTHORITY'];
			 break;
		 }	
	  }
  } else if (strlen($zip_aic) == 5 && ctype_digit($zip_aic) == TRUE) {
	   for ($i = 0; $i <= sizeof($aic_list)-1; $i++) {
		   $diff = abs($aic_list[$i]['ZIP'] - $zip_aic);
		   if($i == 0) {
			   $min = $diff;
			   $idx_min = $i;
		   }
		   else if ($diff < $min) {
			   $min = $diff;
			   $idx_min = $i;
		   }
	   }
	   $aic = $aic_list[$idx_min]['AIC'];
  } else if ($zip_aic != "") {
	   $error = TRUE;
	   echo "<p id='error'>".htmlspecialchars("Error! Enter valid ZIP or Authority Ident Code")."</p>";
  }
  if(!empty($aic) && $aic != "" && $serial != "" && $dob_split != "" && $expiry_split != "") {
  // Calculate checknumbers for given values
      // Section one: ID-Number
	  $section_one = $aic.$serial;
	  $section_one = $section_one.checknumber($section_one);
	  // Section two: DOB
	  $section_two = $dob_split[2].$dob_split[1].$dob_split[0];
	  $section_two = $section_two.checknumber($section_two);
	  // Section three: Expiry Date
	  $section_three = $expiry_split[2].$expiry_split[1].$expiry_split[0];
	  $section_three = $section_three.checknumber($section_three);
	  // Section four: All Sections combined
	  $section_four = $section_one.$section_two.$section_three;
	  
	  // Format name for machine readable area
	  $name_output = strtoupper($name_split[count($name_split)-1])."<<";
	  $name_length = strlen($name_split[count($name_split)-1]);
	  for ($i = count($name_split); $i > 1; $i--) {
		$name_output .= strtoupper($name_split[count($name_split)-$i])."<";
		$name_length += strlen($name_split[count($name_split)-$i]);
	  }
	  $name_output .= str_repeat("<", 100);
	  $name_output = strtoupper(specialchars($name_output));
	  
	  //Output
	  // ID-Number / Serial Number
	  echo "<div style='font-family: Courier New'>";
	  echo "<h2>ID-Number (top right) / Serial Number (bottom right): </h2><br />";
	  echo "<div style='display: inline-block;'>".$aic.$serial."</div>"; 
	  echo "<span id='seperation'> / </span>";
	  echo "<div style='display: inline-block;'>".$random_serial."</div>";
	  echo "<br /><hr />";
	  // Authority
	  echo "<h2>Issuing Authority </h2><br />";
	  if(!empty($idx_min)) {
		echo $aic_list[$idx_min]['AUTHORITY']."<br><br>";
		echo "(Used ZIP:".$aic_list[$idx_min]['ZIP'].")";
	  } else if (!empty($authority)) {
		echo $authority;
	  } else {
		echo htmlspecialchars("Authority unknown");  
	  }
	  echo "<br /><hr />";
	  // Machine-readable Area
	  echo "<h2>Machine-readable Area: </h2><br />";
	  echo "IDD&lt;&lt;".$section_one.str_repeat("&lt;", 15);
	  echo "<br />";
	  echo $section_two."&lt;".$section_three."D".str_repeat("&lt;",13).checknumber($section_four);
	  echo "<br />";
	  echo htmlspecialchars(substr($name_output, 0, 30));

	  
	  echo "</div>";
  } else if (empty($error)) {
	  echo "<p id='error'>".htmlspecialchars("Error! Check form for completeness.")."</p>";
  }
}
?>
 