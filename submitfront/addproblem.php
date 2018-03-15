<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
   </head>
  <body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

   	$machineid = $_POST['machineid'];
	$problemid = $_POST['problemid'];

   addprob($machineid,$problemid);
}

function addprob($machineid,$problemid){

	//connect to your database
	$conn=oci_connect('tsun','krit922954', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";
       exit;
	}

  	$query = oci_parse($conn,"call addproblem(:machineid,:problemid)");
	
	oci_bind_by_name($query, ':machineid', $machineid);
	oci_bind_by_name($query, ':problemid', $problemid);
	
	// Execute the query
    $result = oci_execute($query);

	if ($result){
        echo 'problem added';
    }
    else{
		$e = oci_error($query);
       	echo $e['message'];
	}
	OCILogoff($conn);

}
?>

  <p> 
	<input type ="button" value="Add Another Problem" onclick="window.location.href = 'addproblem.html'">
    <input type ="button" value="Go Back" onclick="window.location.href = 'employee.html'">
  </p>
   </body>
</html>
