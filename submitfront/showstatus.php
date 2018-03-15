<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
   </head>
  <body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

   $machineid = $_POST['machineid'];

   // Validate input
   if (!empty($machineid)){
	 $machineid = prepareInput($machineid);
   }

   showstatus($machineid);
}

function prepareInput($inputData){
	$inputData = trim($inputData);
  	$inputData  = htmlspecialchars($inputData);
  	return $inputData;
}

function showstatus($machineid){

	//connect to your database
	$conn=oci_connect('tsun','krit922954', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";
       exit;
	}

  	$query = oci_parse($conn,"begin :r := showStatus(:machineid); end;");

	// Program variables are bound to SQL statement
	oci_bind_by_name($query, ':machineid', $machineid);
	oci_bind_by_name($query,':r',$r,300);

	// Execute the query
    $result = oci_execute($query);

	if ($result){
        echo $r;
    }
    else{
		$e = oci_error($query);
       	echo $e['message'];
	}
	OCILogoff($conn);

}
?>
  <p>
    <input type ="button" value="Back" onclick="window.location.href = 'employee.html'">
  </p>
   </body>
</html>
