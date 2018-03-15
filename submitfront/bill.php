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

   generateBill($machineid);
}

function prepareInput($inputData){
	$inputData = trim($inputData);
  	$inputData  = htmlspecialchars($inputData);
  	return $inputData;
}

function generateBill($machineid){

	//connect to your database
	$conn=oci_connect('tsun','krit922954', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";
       exit;
	}

  	$query = oci_parse($conn,"begin :r := generateBill(:machineid); end;");
	$query1 = oci_parse($conn,"begin :r1 := custinfo(:machineid); end;");
	$query3 = oci_parse($conn,"select p.problemid, d.description from problemReport p, problem d where p.machineid = :machineid and p.problemid = d.problemid");
	$query4 = oci_parse($conn,"begin :r4 := repairinfo(:machineid); end;");

	// Program variables are bound to SQL statement
	oci_bind_by_name($query, ':machineid', $machineid);
	oci_bind_by_name($query,':r',$r,100);

	oci_bind_by_name($query1,':r1',$r1,100);
	oci_bind_by_name($query1,':machineid',$machineid);


	//oci_bind_by_name($query3,':r3',$r3,500);
	oci_bind_by_name($query3,':machineid',$machineid);

	oci_bind_by_name($query4,':r4',$r4,500);
	oci_bind_by_name($query4,':machineid',$machineid);

	// Execute the query
    $result = oci_execute($query);
	oci_execute($query1);
	$result3 = oci_execute($query3);
	$result4 = oci_execute($query4);

	if ($result){
        echo 'bill = ', $r ,'<br/><br/>';
		echo 'cust info <br/>',$r1,'<br/><br/>';
		echo 'problem info<br/>';
		//echo 'problem info <br/>',$r3,'<br/><br/>';
		while($row = oci_fetch_array($query3)){
			echo $row[0].' '.$row[1].'<br/>';
		}
		echo '<br/> repair info <br/>',$r4;
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
