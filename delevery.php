<?php 
require_once('Connections/link.php'); 
// include("inventryFunction.php");

?>
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


  $colname_getItemListByOrderID=$_GET['order_id'];

mysql_select_db($database_link, $link);
$query_getItemListByOrderID = sprintf("SELECT * FROM order_details WHERE order_id = %s", GetSQLValueString($colname_getItemListByOrderID, "int"));
$getItemListByOrderID = mysql_query($query_getItemListByOrderID, $link) or die(mysql_error());
$row_getItemListByOrderID = mysql_fetch_assoc($getItemListByOrderID);
$totalRows_getItemListByOrderID = mysql_num_rows($getItemListByOrderID);


 do { 

$peoname=$row_getItemListByOrderID['item_name']; 

// manageInventry($row_getItemListByOrderID['item_name'],$row_getItemListByOrderID['quentity']);


$result = mysql_query("SELECT * FROM `stock` WHERE `item_name`='$peoname' ORDER BY id DESC") or die(mysql_error());  
$row = mysql_fetch_array( $result );
$itemName=$row['item_name'];
$itemID=$row['item_id'];
$lastStork=$row['quantity'];
$newQt=$row_getItemListByOrderID['quentity'];
$newQtLast=$lastStork-$newQt;


$result = mysql_query("INSERT INTO `linkfive_link`.`stock` (`item_id`, `item_name`, `item_size`, `unit_price`, `quantity`, `dameges`) VALUES ('$itemID', '$itemName', 'sm', '12', '$newQtLast', '0');") 
 or die(mysql_error());  


} while ($row_getItemListByOrderID = mysql_fetch_assoc($getItemListByOrderID)); 

$result2 = mysql_query("UPDATE `order` SET statues='Delivered' WHERE order_id='$colname_getItemListByOrderID' ") 
or die(mysql_error());



?>

<html>
<head>
<meta http-equiv="refresh" content="0;URL=orderView1.php">
</head>
<body>
</body>
</html>