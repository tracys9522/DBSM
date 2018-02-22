<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     // collect input data
	// Get the Name
   $name = $_POST['name'];
	 // Get the price
	 $phoneno = $_POST['phoneno'];

     // Validate input
    if (!empty($name)){
		$name = prepareInput($name);
     }
	  if (!empty($phoneno)){
		$phoneno = prepareInput($phoneno);
     }
	// Call the function to insert name, calories,price
	// into FoodItem table

	insertFoodInputIntoDB($name,$phoneno);

}
function prepareInput($inputData){
	$inputData = trim($inputData);
  	$inputData  = htmlspecialchars($inputData);
  	return $inputData;
}



function insertFoodInputIntoDB($name,$phoneno){

	//connect to your database
	$conn=oci_connect('username','passwd', 'localhost/XE');
	if(!$conn) {
	     print "<br> connection failed:";
           exit;
	}
	// convert the string to a number
	$calories = intval($calories);
	$price = (float) $price;

$query = oci_parse($conn, "Insert Into FoodItem(itemname,calories,price) values(:name,:calories,:price)");

	// Program variables are bound to SQL statement

	oci_bind_by_name($query, ':name', $name);
	oci_bind_by_name($query, ':phoneno', $phoneno);

	// Execute the query
	$res = oci_execute($query);
	if ($res)
		echo '<br><br> <p style="color:green;font-size:20px">Data successfully inserted</p>';
	else{
		$e = oci_error($query);
        	echo $e['message'];
	}
	OCILogoff($conn);
}
?>
