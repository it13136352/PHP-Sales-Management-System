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
 

  $insertGoTo = "ordernewrep.php";
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



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

</head>

<body bgcolor="#999999">

<div align="center" >
<table>
<tr>
<td>
<img src="img/20149_h_64863.png" />
</td>
</tr>
</table>
<br />


<form method="post" action="ordernewrep.php">
<table>
<tr>
<td>
<select name="itemsize"  class="form-control" id="itemsize">
  <option value="Select">label</option>
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
      &nbsp;</td>
      <td>Quentity</td>
      <td><input name="qt" type="text" id="qt" /></td>
      <td>
      <input type="submit" id="addPro" value="Add" />
      </td>
        <input type="hidden" name="MM_insert" value="form1" />
        </tr>
        </table>
</form>

<?php include 'orderItemsrep.php';?>
</div>

</body>
</html>
<?php
mysql_free_result($product);
?>
