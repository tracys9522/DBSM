<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>

<?php
//session_start();
$custid  = '';
$status = 'UNDER_REPAIR';
$coverage = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

   $itemid = $_POST['itemid'];
   //$custid = $_POST['custid'];
   $phoneno = $_POST['phoneno'];
   $item = $_POST['item'];
   //$model = $_POST['model'];
   $price = $_POST['price'];
   $year = $_POST['year'];
   //$selection = $_POST['SC'];
   $serviceContract = $_POST['serviceContract'];

   $contractid = $_POST['contractId'];
   $tdate = date('YYYY-MM-DD');
   $ts = date('Y-m-d G:i:s');

  //$_SESSION["cType"] = $serviceContract;


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

   /*if (!empty($custid)){
	 $custid = prepareInput($custid);
   }*/

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

  /*if($serviceContract != 'GROUP'){
	  $cError = "*Need a group contract to add another item";
   }*/
	  

   insertRepairIntoDB($itemid,$phoneno,$model,$price,$year,$item, $serviceContract, $contractid, $ts, $status, $tdate);
   //insertRepair2IntoDB($itemid2,$custid,$model2,$price2,$year2,$item2, $serviceContract2);

}


   //getContract($selection);

function prepareInput($inputData){
  $inputData = trim($inputData);
  $inputData  = htmlspecialchars($inputData);
  return $inputData;
}

function insertRepairIntoDB($itemid,$phoneno,$model,$price,$year,$item, $serviceContract, $contractid, $ts, $status, $tdate){

	//connect to your database
	$conn=oci_connect('etseng','9679476', '//dbserver.engr.scu.edu/db11g');
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

	//$price2 = (float) $price2;

	$query = oci_parse($conn, "Insert Into repairItem(itemid,custid,model,price,year,item, serviceContractType) values(:itemid,:custid,UPPER(:model),:price,:year, UPPER(:item),:serviceContract)");

	// Program variables are bound to SQL statement
	
	oci_bind_by_name($query, ':itemid',$itemid);
	oci_bind_by_name($query, ':custid',$custid);
	oci_bind_by_name($query, ':model', $model);
	oci_bind_by_name($query, ':price', $price);
	oci_bind_by_name($query, ':year', $year);
	oci_bind_by_name($query, ':item', $item);
	oci_bind_by_name($query, ':serviceContract', $serviceContract);

	$query2 = oci_parse($conn, "Select * from servicecontract");
  oci_execute($query2);

  while(($row = oci_fetch_array($query2, OCI_BOTH)) != false && $contractid != NULL){
    if($contractid != $row[0]){
	echo "Your machine has been accepted for repair. However, your service contract is invalid.";
	$coverage = 'N';
     }
    else{
      if($row[2]>=$tdate || $tdate >=$row[3]){
	echo "Your service contract is valid and your machine has been accepted for repair. You will not be charged for repairs.";
	$coverage = 'Y';
      }
      else{
	echo "Your machine has been accepted for repair. However, your service contract is invalid.";
	$coverage = 'N';
      }
    }
  }


	if($serviceContract == 'NONE'){
	echo "Your machine has been accepted for repair.";
	$coverage = 'N';
	}

	$res = oci_execute($query);

	$rJ = oci_parse($conn, "insert into repairjob(machineid,servicecontractid,arrivaltime,customerid,coverage,status) values(:itemid, :contractid, to_date(:ts, 'YYYY-MM-DD HH24:MI:SS'), :custid, :coverage, :status)");
	oci_bind_by_name($rJ, ':itemid', $itemid);
	oci_bind_by_name($rJ, ':contractid', $contractid);
	oci_bind_by_name($rJ, ':ts', $ts);
	oci_bind_by_name($rJ, ':custid', $custid);
	oci_bind_by_name($rJ, ':coverage', $coverage);
	oci_bind_by_name($rJ, ':status', $status);

	oci_execute($rJ);

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
}

/*function getContract($selection)
{
	$conn=oci_connect('etseng','9679476', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";
       exit;
	}

        if($selection == "yesSC")
	{
	      
	}
	elseif($selection == "noSC")
}*/
?>
<body>
  <p>
    Add another item for repair?<br/>
     <input type ="button" value="No" onclick= "window.location.href = 'done.html'">
    <input type ="button" value="Yes" onclick="window.location.href= 'repair2.html'">
  </body>
   </head>

