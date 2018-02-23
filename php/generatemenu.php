
<?php
//connect to your database
	$conn=oci_connect('username','password', 'localhost/XE');
	if(!$conn) {
	     print "<br> connection failed:";
        exit;
	}
	$queryString = 'Select ITEMNAME from FoodItem';
	$query = oci_parse($conn, $queryString);
	$res = oci_execute($query);
	
	if (!$res) {
		$e = oci_error($query);
        		echo $e['message'];
		exit;
	}
	$checkBoxStrings = array();

	// create a list of checkbox options from the list of items retrieved from the database

	while($row=oci_fetch_assoc($query)) {
		$label = $row['ITEMNAME'];
		$str = "<label>$label</label><input type = 'checkbox' name='check_list[]' value = '{$row['ITEMNAME']}' />"  ;
		array_push($checkBoxStrings,$str);
    }
	OCILogoff($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
      <title>Take your Order</title>
   </head>
   <body>
   <form method="post" action="http://url/generateBill.php">
  	<fieldset>
        	<legend style="color:blue;font-size:30px">Take your order</legend>
			<?php
				for ($i = 0; $i < count($checkBoxStrings); $i++) {

					echo $checkBoxStrings[$i];
				}
			?>
        </fieldset>
			<br/> <br/><br/>
            <input type="submit" value="submit">
        	<input type="reset" value="reset">
 </form>
