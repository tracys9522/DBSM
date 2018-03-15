<?php

showlog();
function showlog(){

	//connect to your database
	$conn=oci_connect('tsun','krit922954', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";
       exit;
	}

  	$query = oci_parse($conn,"select * from repairLog");

	// Execute the query
    oci_execute($query);
	while($row = oci_fetch_array($query)){
		echo 'machineid: ',$row[0],'</br>';
		echo 'service contract id: ',$row[1],'</br>';
		echo 'arrival date: ',$row[2],'</br>';
		echo 'customer id: ',$row[3],'</br>';
		echo 'covered? ',$row[4],'</br>';
		echo '</br></br>';
	}
	
	OCILogoff($conn);
}
?>
