<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

   $itemid2 = uniqid();
   $custid2 = $_POST['custid2'];
   $item2 = $_POST['item2'];
   //$model2 = $_POST['model2'];
   $price2 = $_POST['price2'];
   $year2 = $_POST['year2'];
   $serviceContract2 = $_POST['serviceContract2'];

  if(isset($_POST['model2']))
  {
    $model2 = $_POST['model2'];
  }
  else
  {
    $model2 = null;
  }

   if (!empty($item2)){
	 $item = prepareInput($item2);
	 $itemid2 = prepareInput($itemid2);
   }

   if (!empty($custid2)){
	 $custid2 = prepareInput($custid2);
   }

   if (!empty($model2)){
	 $model2 = prepareInput($model2);
   }
   if (!empty($price2)){
	 $price2 = prepareInput($price2);
   }

   if (!empty($year2)){
	 $year2 = prepareInput($year2);
   }

  if (!empty($serviceContract2)){
	  $serviceContract2 = prepareInput($serviceContract2);
   }
   insertRepair2IntoDB($itemid,$custid,$model,$price,$year,$item, $serviceContract);
   //insertRepair2IntoDB($itemid2,$custid,$model2,$price2,$year2,$item2, $serviceContract2);

}


function insertRepair2IntoDB($itemid2,$custid2,$model2,$price2,$year2,$item2, $serviceContract2){

	//connect to your database
	$conn=oci_connect('etseng','9679476', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";
       exit;
	}

	//$price2 = (float) $price2;

	$query = oci_parse($conn, "Insert Into repairItem(itemid,custid,model,price,year,item, serviceContractType) values(:itemid2,:custid2,UPPER(:model2),:price2,:year2,UPPER(:item2), :serviceContract2)");

	// Program variables are bound to SQL statement
	
	oci_bind_by_name($query, ':itemid2',$itemid2);
	oci_bind_by_name($query, ':custid2',$custid2);
	oci_bind_by_name($query, ':model2', $model2);
	oci_bind_by_name($query, ':price2', $price2);
	oci_bind_by_name($query, ':year2', $year2);
	oci_bind_by_name($query, ':item2', $item2);
	oci_bind_by_name($query, ':serviceContract2', $serviceContract2);

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
?>
