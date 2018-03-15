<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

   $machineid = $_POST['machineid'];
	$status = $_POST['status'];

   updatestatus($machineid,$status);
}

function updatestatus($machineid,$status){

	//connect to your database
	$conn=oci_connect('tsun','krit922954', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";
       exit;
	}

  	$query = oci_parse($conn,"call updateStatus(:machineid,upper(:status))");
	
	oci_bind_by_name($query, ':machineid', $machineid);
	oci_bind_by_name($query, ':status', $status);

	// Execute the query
    $result = oci_execute($query);

	if ($result){
        echo 'status updated';
		if($status == 'READY'){
			echo '<script type="text/javascript">
           	window.location = "addproblem.html"
      		</script>';		
		}
		if($status == 'DONE'){
			echo '<script type="text/javascript">
           window.location = "addbill.html"
      		</script>';
		}
    }
    else{
		$e = oci_error($query);
       	echo $e['message'];
	}
	OCILogoff($conn);
}

?>

