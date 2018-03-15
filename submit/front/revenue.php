<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
   </head>
  <body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

   $start = $_POST['start'];
	$end = $_POST['end'];

   // Validate input
   if (!empty($start)){
	 $machineid = prepareInput($start);
   }
   if (!empty($end)){
	 $end = prepareInput($end);
   }


   generateRevenue($start,$end);
}

function prepareInput($inputData){
	$inputData = trim($inputData);
  	$inputData  = htmlspecialchars($inputData);
  	return $inputData;
}

function generateRevenue($start,$end){

	//connect to your database
	$conn=oci_connect('tsun','krit922954', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";
       exit;
	}

  	$query = oci_parse($conn,"begin :r := generateRevenue(to_date(:start,'YYYY-MM-DD'),to_date(:end,'YYYY-MM-DD'));end;");

	// Program variables are bound to SQL statement
	oci_bind_by_name($query, ':start', $start);
	oci_bind_by_name($query, ':end', $end);
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
    <input type ="button" value="Go Back" onclick="window.location.href = 'employee.html'">
  </p>
   </body>
</html>
