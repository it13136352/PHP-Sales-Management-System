<?php require_once('Connections/link.php'); ?>
<?php


if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

mysql_select_db($database_link, $link);

$repid="1";
$customer_id="5";

	$result2 = mysql_query("SELECT * FROM  `order` WHERE rep_id='$repid' AND statues='Pending' AND `customer_id`='$customer_id'  ORDER BY  `order`.`order_id` DESC ") or die(mysql_error()); 
	$row2 = mysql_fetch_array( $result2 );

$orderid=$row2["order_id"];

	
	
$producrID=$_POST["itemsize"];
// $producrID=22;
$result = mysql_query("SELECT * FROM item WHERE item_id='$producrID'") or die(mysql_error());  

$row = mysql_fetch_array( $result );




if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
$orderid=$orderid;
$item_name=$row['item_name'];
$quentity=$_POST["qt"];
$unit_price=$row['unite_price'];
 $totalPrice=$unit_price*$quentity;
	
  $insertSQL = sprintf("INSERT INTO order_details (order_id, item_name, quentity, unit_price, total_price) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($orderid, "int"),
                       GetSQLValueString($item_name, "text"),
                       GetSQLValueString($quentity, "int"),
                       GetSQLValueString($unit_price, "double"),
                       GetSQLValueString($totalPrice, "text"));

  mysql_select_db($database_link, $link);
  $Result1 = mysql_query($insertSQL, $link) or die(mysql_error());
  
  
$item_name="";
$quentity="";
$unit_price="";
$totalPrice="";
 

  $insertGoTo = "ordernewweb.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_link, $link);
$query_product = "SELECT * FROM item ORDER BY item_name ASC";
$product = mysql_query($query_product, $link) or die(mysql_error());
$row_product = mysql_fetch_assoc($product);
$totalRows_product = mysql_num_rows($product);

?>

<!DOCTYPE html>
<html>

<!---------------validation--------------------------->
<script type='text/javascript'>

function formValidator(){
	// Make quick references to our fields
	var selectitem = document.getElementById('selectitem');
	var qt = document.getElementById('qt');
	
	
	// Check each input in the order that it appears in the form!
		if(madeSelection(selectitem, "Please Choose a item")){
		
				
				if(notEmpty(qt, "Please enter quentity") && isNumeric(qt, "Please enter only Numeric values")){
	
							return true;
						}
					}
				
	
	
	
	
	return false;
	
}

function notEmpty(elem, helperMsg){
	if(elem.value.length == 0){
		alert(helperMsg);
		elem.focus(); // set the focus to this input
		return false;
	}
	return true;
}

function isNumeric(elem, helperMsg){
	var numericExpression = /^[0-9]+$/;
	if(elem.value.match(numericExpression)){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
}


function madeSelection(elem, helperMsg){
	if(elem.value == "--Select Item--"){
		alert(helperMsg);
		elem.focus();
		return false;
	}else{
		return true;
	}
}

</script>
<!----------------------------------------------------->

<head>
	
     <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	
	<title>Link Five(SLIIT)</title>
    
    </head>
	
	<style>
		
		img.bg {
			/* Set rules to fill background */
			min-height: 100%;
			min-width: 1024px;
			
			/* Set up proportionate scaling */
			width: 100%;
			height: auto;
			
			/* Set up positioning */
			position: fixed;
			top: 0;
			left: 0;
		}
		
		@media screen and (max-width: 1024px){
			img.bg {
				left: 50%;
				margin-left: -512px; }
		}
		
		#page-wrap { position: relative; width: 550px; margin: 50px auto; padding: 20px; background: white; -moz-box-shadow: 0 0 20px black; -webkit-box-shadow: 0 0 20px black; box-shadow: 0 0 20px black; }
		p { font: 15px/2 Georgia, Serif; margin: 0 0 30px 0; text-indent: 40px; }
	</style>
    


<body>

	<img src="img/depositphotos_7500800-Handshake-isolated-on-business-background.jpg" class="bg">
	
	<div id="page-wrap" align="center"  >
<img src="img/20149_h_64863.png" width="500" height="250" />
<div align="center"  >
	  
	  
	  
  <br/>


<form method="post" action="ordernewweb.php" onsubmit='return formValidator()'>
<table width="500" border="0" cellpadding="0" height="75">
<tr >
<td >
<select name="itemsize"  class="form-control" id="itemsize">
  <option value="Select" select id="selectitem">~~Select Item~~</option>
  <?php
do {  
?>
  <option value="<?php echo $row_product['item_id']?>"><?php echo $row_product['item_name']?></option>
  <?php
} while ($row_product = mysql_fetch_assoc($product));
  $rows = mysql_num_rows($product);
  if($rows > 0) {
      mysql_data_seek($product, 0);
	  $row_product = mysql_fetch_assoc($product);
  }
?>
</select>
      </td>
      <td >Quantity :</td>
      <td ><input name="qt" class="form-control" type="text" id="qt" /></td>
      <td >
      <input type="submit" id="addPro"  class="btn btn-primary btn-lg btn-block active" value="Add" onclick=
"alert('Are you sure you want to Add?')" />
      </td>
        <input type="hidden" name="MM_insert" value="form1" />
    </tr>
  </table>
</form>

<?php include 'orderItemsweb.php';?>
	
	</div>
	<div><a href="weblog11.php"> <img src="img/back.button.jpg" height="50" width="50"></a></div>
    
</body>


</html>
<?php
mysql_free_result($product);
?>
