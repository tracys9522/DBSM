<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>

<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {

   $itemid = uniqid();
   $custid = $_POST['custid'];
   $item = $_POST['item'];
   //$model = $_POST['model'];
   $price = $_POST['price'];
   $year = $_POST['year'];
   //$selection = $_POST['SC'];
   $serviceContract = $_POST['serviceContract'];


  if(isset($_POST['model']))
  {
    $model = $_POST['model'];
  }
  else
  {
    $model = null;
  }



   // Validate input
   if (!empty($item)){
	 $item = prepareInput($item);
	 $itemid = prepareInput($itemid);
   }

   if (!empty($custid)){
	 $custid = prepareInput($custid);
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
	  

   insertRepairIntoDB($itemid,$custid,$model,$price,$year,$item, $serviceContract);
   //insertRepair2IntoDB($itemid2,$custid,$model2,$price2,$year2,$item2, $serviceContract2);

}

   //getContract($selection);

function prepareInput($inputData){
  $inputData = trim($inputData);
  $inputData  = htmlspecialchars($inputData);
  return $inputData;
}

function insertRepairIntoDB($itemid,$custid,$model,$price,$year,$item, $serviceContract){

	//connect to your database
	$conn=oci_connect('etseng','9679476', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";
       exit;
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

	// Execute the query
	$res = oci_execute($query);
	if ($res)
		echo '<br><br> <p style="color:green;font-size:20px">Data successfully inserted</p>';
	else{
		$e = oci_error($query);
        	echo $e['message'];
	}
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

  <p>
  <input type ="button" value="Done" onclick= "window.location.href = 'serviceContract.html'">

   </head>
  <body>
