<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
   <body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $contractid = $_POST['contractId'];
  $tdate = date("Y-m-d");

  	$conn=oci_connect('etseng','9679476', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";
       exit;
	}

  $query = oci_parse($conn, "Select contractid from servicecontract");
  oci_execute($query);

  while(($row = oci_fetch_array($query, OCI_BOTH)) != false){
    if($row[2]<= $date || $date <=$row[3]){
      echo "Your service contract is valid and your machine has been accepted for repair. You will not be charged for repairs.";
    }
    else{
      echo "Your machine has been accepted for repair. However, your service contract is invalid.";
    }
  }
  echo "Your machine has been accepted for repair. However, your service contract is invalid.";

}  
?>
  <p>
   <a href='http://students.engr.scu.edu/~etseng/cstatus.php'> Follow this link to check the status of your repairs</a> 
   </body>
</html>

