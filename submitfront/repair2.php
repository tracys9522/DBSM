<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>

<?php

$custid  = '';
$status = 'UNDER_REPAIR';
$coverage = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $itemid = $_POST['itemid'];
   $phoneno = $_POST['phoneno'];
   $item = $_POST['item'];
   $price = $_POST['price'];
   $year = $_POST['year'];
   $serviceContract = $_POST['serviceContract'];
   $contractid = $_POST['contractId'];
   $tdate = date('YYYY-MM-DD');
   $ts = date('Y-m-d G:i:s');

  if(isset($_POST['model']))
  {
    $model = $_POST['model'];
  }
  else
  {
    $model = null;
  }
   // Validate input 
   if(!empty($contract)){
	 $contractid = prepareInput($contractid);
   }
  
   if(!empty($itemid)){
	 $itemid = prepareInput($itemid);
   }
   if(!empty($ts)){
	$ts = prepareInput($ts);
   }
   if (!empty($item)){
	 $item = prepareInput($item);
	 $itemid = prepareInput($itemid);
   }
    if(!empty($phoneno)){
	  $phoneno = prepareInput($phoneno);
   }
   if (!empty($model)){
	 $model = prepareInput($model);
   }
   if (!empty($price)){
	 $price = prepareInput($price);
   }
   if (!empty($year)){
	 $year = prepareInput($year);
   }
  if (!empty($serviceContract)){
	  $serviceContract = prepareInput($serviceContract);
   }

   insertRepairIntoDB($itemid,$phoneno,$model,$price,$year,$item, $serviceContract, $contractid, $ts, $status, $tdate);
}
   
function prepareInput($inputData){
  $inputData = trim($inputData);
  $inputData  = htmlspecialchars($inputData);
  return $inputData;
}

function insertRepairIntoDB($itemid,$phoneno,$model,$price,$year,$item, $serviceContract, $contractid, $ts, $status, $tdate){

	$conn=oci_connect('tsun','krit922954', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";
       exit;
	}
	$array = oci_parse($conn, "select * from customer");
	oci_execute($array);
	while(($row = oci_fetch_array($array, OCI_BOTH)) != false){
	  if($row[2] == $phoneno)
	    $custid = $row[0];
	}
	$query = oci_parse($conn, "Insert Into repairItem(itemid,custid,model,price,year,item, serviceContractType) values(:itemid,:custid,UPPER(:model),:price,:year, UPPER(:item),:serviceContract)");

	// Program variables are bound to SQL statement
	oci_bind_by_name($query, ':itemid',$itemid);
	oci_bind_by_name($query, ':custid',$custid);
	oci_bind_by_name($query, ':model', $model);
	oci_bind_by_name($query, ':price', $price);
	oci_bind_by_name($query, ':year', $year);
	oci_bind_by_name($query, ':item', $item);
	oci_bind_by_name($query, ':serviceContract', $serviceContract);
	
	$res = oci_execute($query);
	
	$rJ = oci_parse($conn, "insert into repairjob(machineid,servicecontractid,arrivaltime,customerid,coverage,status) values(:itemid, :contractid, to_date(:ts, 'YYYY-MM-DD HH24:MI:SS'), :custid, 'N', :status)");
	oci_bind_by_name($rJ, ':itemid', $itemid);
	oci_bind_by_name($rJ, ':contractid', $contractid);
	//oci_bind_by_name($rJ, ':coverage', $coverage);
	oci_bind_by_name($rJ, ':ts', $ts);
	oci_bind_by_name($rJ, ':custid', $custid);
	oci_bind_by_name($rJ, ':status', $status);
	oci_execute($rJ);
		
	if($serviceContract != 'NONE'){
		$r = oci_parse($conn,"call checkcoverage(:contractid,:itemid)");
		oci_bind_by_name($r, ':contractid', $contractid);
		oci_bind_by_name($r, ':itemid', $itemid);
		oci_execute($r);
	}

	// Execute the query
	if ($res)
		echo '<br><br> <p style="color:green;font-size:20px">Data successfully inserted</p>';
	else{
		$e = oci_error($query);
        	echo $e['message'];
	}
	echo "<p></p>";
	echo "This is your machine id for your " .$item. ".";
	echo "<p></p>";
	echo $itemid;
	OCILogoff($conn);

	if($serviceContract == 'SINGLE'){
		echo '<script type="text/javascript">
           window.location = "done.html"
      	</script>';
	}
}
?>
<body>
  <p>
	<input type ="button" value="done" onclick= "window.location.href = 'done.html'">
  </body>
</head>
