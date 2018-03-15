<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
   </head>
  <body>

<?php

showjob();
function showjob(){

	//connect to your database
	$conn=oci_connect('tsun','krit922954', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";
       exit;
	}
	
	$query = oci_parse($conn,"select * from repairJob where status = 'UNDER_REPAIR'");

	// Execute the query
    $result = oci_execute($query);
 	while($row = oci_fetch_array($query)){
		echo ''.$row[0].' '.$row[1].' '.$row[2].' '.$row[3].' '.$row[4].' '.$row[5].'</br>';	
		$query1 = oci_parse($conn,"begin :r := showRepairJobs(:machineid); end;");
		oci_bind_by_name($query1, ':machineid', $row[0]);
		oci_bind_by_name($query1,':r',$r,300);
		oci_execute($query1);
		echo $r.'</br></br>';
	}
	
	OCILogoff($conn);
}
?>
  <p>
    <input type ="button" value="Back" onclick="window.location.href = 'employee.html'">
  </p>
   </body>
</html>
