<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
   </head>
  <body>

<?php
//session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $custid = $_POST['custid'];
   $name = $_POST['name'];
   $phoneno = $_POST['phoneno'];
   // Validate input
 if (!empty($custid)){
	 $custid = prepareInput($custid);
   }
   if (!empty($name)){
	 $name = prepareInput($name);
   }
   if (!empty($phoneno)){
	 $phoneno = prepareInput($phoneno);
   }
   insertCustomerIntoDB($custid,$name,$phoneno);
}
function prepareInput($inputData){
	$inputData = trim($inputData);
  $inputData  = htmlspecialchars($inputData);
  return $inputData;
}
function insertCustomerIntoDB($custid,$name,$phoneno){
	//connect to your database
	$conn=oci_connect('tsun','krit922954', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";
       exit;
	}
  $query = oci_parse($conn, "Insert Into customer(customerid, name,phoneno) values(:customerid,:name,:phoneno)");
	// Prog  <body>ram variables are bound to SQL statement
	oci_bind_by_name($query, ':customerid', $custid);
	oci_bind_by_name($query, ':name', $name);
	oci_bind_by_name($query, ':phoneno', $phoneno);
	// Execute the query
	$res = oci_execute($query);
	if ($res){
		echo '<p style="color:green;font-size:20px">Welcome '.$name.'</p>';
		echo '<p></p>';
		echo '<button type="button" onclick="history.back();">Back</button>';
	}	
	else{
		$e = oci_error($query);
        	echo $e['message'];
	}
	OCILogoff($conn);
}
?>
  <p>
    Add item for repair
    <input type ="button" value="Continue" onclick="window.location.href = 'repair.html'">
  </p>
   </body>
</html>
