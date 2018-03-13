<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){

  $machineid = $_POST['machineid'];

  showStatus($machineid);

}

function showStatus($machineid){
	//connect to your database
	$conn=oci_connect('etseng','9679476', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";
       exit;
	}

       $query = oci_parse($conn, "select * from repairjob");
       oci_execute($query);

       while(($row = oci_fetch_array($query, OCI_BOTH)) != false){
	  if($row[0] == $machineid){
	      echo "Machine ID: " .$row[0]. "";
	      echo "<p></p>";
	      echo "Status: " .$row[4]. "";
	  }
	  
      }
OCILogoff($conn);
}
?>