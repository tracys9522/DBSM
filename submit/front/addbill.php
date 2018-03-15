<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

   	$machineid = $_POST['machineid'];
	$problemid = $_POST['problemid'];
	$empid = $_POST['empid'];
	$cost = $_POST['cost'];
	$hour = $_POST['hour'];
   	$timeout = date('Y-m-d G:i:s');

   	addbill($machineid,$problemid,$empid,$cost,$hour,$timeout);
}

function addbill($machineid,$problemid,$empid,$cost,$hour,$timeout){

	//connect to your database
	$conn=oci_connect('tsun','krit922954', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";
       exit;
	}
	
	$cost1 = floatval($cost);
	$hour1 = floatval($hour);
	
	$sql = "call addbill(:machineid,:problemid,:empid,:cost,:hour,to_date(:timeout,'YYYY-MM-DD HH24:MI:SS'))";
  	$query = oci_parse($conn,$sql);
	
	oci_bind_by_name($query, ':machineid', $machineid);
	oci_bind_by_name($query, ':problemid', $problemid);
	oci_bind_by_name($query, ':empid', $empid);
	oci_bind_by_name($query, ':cost', $cost1);
	oci_bind_by_name($query, ':hour', $hour1);
	oci_bind_by_name($query, ':timeout', $timeout);
	
	// Execute the query
    $result = oci_execute($query);

	if ($result){
        echo 'bill added';
    }
    else{
		$e = oci_error($query);
       	echo $e['message'];
	}
	OCILogoff($conn);
}
?>
