<?php

 if ($_SERVER["REQUEST_METHOD"] == "POST") {//to run PHP script on submit
	if(!empty($_POST['check_list'])){
	// Loop to store and display values of individual
	// checked checkbox.
	$selections = array();
	foreach($_POST['check_list'] as $selected){
		//echo $selected."</br>";
		array_push($selections,$selected);
	}
	}
	calculateBill($selections);
}
function calculateBill($selections){
	$conn=oci_connect('username','password', 'localhost/XE');
	if(!$conn) {
	     print "<br> connection failed:";
        exit;
	}
	$total = 0;
	echo '<br><br> <p style="color:green;font-size:30px">Customer Bill</p>';

	foreach($selections as $selected){

		$queryString = 'Select CALORIES,PRICE from FoodItem where ITEMNAME=:selected';
		$query = oci_parse($conn, $queryString);
		oci_bind_by_name($query, ':selected', $selected);
		$res = oci_execute($query);

		if (!$res){
			$e = oci_error($query);
        	echo $e['message'];
		}
	    $row=oci_fetch_array($query,OCI_BOTH);
		echo " Item Name: ";
		echo "<font color='red'>  $selected </font>";
		echo " Calories: ";
		echo "<font color='blue'> $row[0] </font>";
		echo " Price: $";
		echo "<font color='green'>$row[1] </font></br>";
		$total = $total + floatval($row[1]);
	}
		echo "</br>";
		echo "<font color='green'>Grand Total = $ $total </font>";
	OCILogoff($conn);
}
?>
