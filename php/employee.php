<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

   $name = $_POST['name'];
   $phone = $_POST['phoneno'];

   // Validate input
   if (!empty($name)){
	 $name = prepareInput($name);
   }

   if (!empty($phoneno)){
	 $phoneno = prepareInput($phoneno);
   }

   insertEmployeeIntoDB($name,$phoneno);
}

function prepareInput($inputData){
	$inputData = trim($inputData);
  $inputData  = htmlspecialchars($inputData);
  return $inputData;
}

function insertEmployeeIntoDB($name,$phoneno){

	//connect to your database
	$conn=oci_connect('tsun','pass', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";
       exit;
	}

  $phoneno = (char) $phoneno;

  $query = oci_parse($conn, "Insert Into repairPerson(name,phoneno) values(:name,:phoneno)");

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
