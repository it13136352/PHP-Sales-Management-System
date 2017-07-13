<?php

function manageInventry($productId,$newQt){

// $orderId=$_GET["order_id"];
require_once('Connections/link.php'); 

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

mysql_select_db($database_link, $link);

$result = mysql_query("SELECT * FROM `stock` WHERE `item_name`='$productId' ORDER BY id DESC") or die(mysql_error());  
$row = mysql_fetch_array( $result );
$itemName=$row['item_name'];
$itemID=$row['item_id'];
$lastStork=$row['quantity'];
echo $newQtLast=$lastStork-$newQt;


$result = mysql_query("INSERT INTO `linkfive_link`.`stock` (`item_id`, `item_name`, `item_size`, `unit_price`, `quantity`, `dameges`) VALUES ('$itemID', '$itemName', 'sm', '12', '$newQtLast', '0');") 
 or die(mysql_error());  
	
}


?>