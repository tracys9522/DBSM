<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

   $item = $_POST['item'];
   $model = $_POST['model'];
   $price = $_POST['price'];
   $year = $_POST['year'];


   // Validate input
   if (!empty($item)){
	 $item = prepareInput($item);
   }

   if (!empty($model)){
	 $model = prepareInput($model);
   }
   if (!empty($price)){
	 $price = prepareInput($price);
   }

   if (!empty($year)){
	 $year = prepareInput($year);
   }

   insertRepairIntoDB($item,$model,$price,$year);

}

function prepareInput($inputData){
  $inputData = trim($inputData);
  $inputData  = htmlspecialchars($inputData);
  return $inputData;
}

function insertRepairIntoDB($item,$model,$price,$year){

	//connect to your database
	$conn=oci_connect('tsun','krit922954', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";
       exit;
	}

	$price = (float) $price;

	$query = oci_parse($conn, "Insert Into repairItem(itemid,item,model,price,year) values(NULL,UPPER(:item),UPPER(:model),:price,:year)");

	// Program variables are bound to SQL statement
	oci_bind_by_name($query, ':item', $item);
	oci_bind_by_name($query, ':model', $model);
	oci_bind_by_name($query, ':price', $price);
	oci_bind_by_name($query, ':year', $year);

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
