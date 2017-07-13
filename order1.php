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

$maxRows_order = 10;
$pageNum_order = 0;
if (isset($_GET['pageNum_order'])) {
  $pageNum_order = $_GET['pageNum_order'];
}
$startRow_order = $pageNum_order * $maxRows_order;

mysql_select_db($database_link, $link);
$query_order = "SELECT * FROM `order`";
$query_limit_order = sprintf("%s LIMIT %d, %d", $query_order, $startRow_order, $maxRows_order);
$order = mysql_query($query_limit_order, $link) or die(mysql_error());
$row_order = mysql_fetch_assoc($order);

if (isset($_GET['totalRows_order'])) {
  $totalRows_order = $_GET['totalRows_order'];
} else {
  $all_order = mysql_query($query_order);
  $totalRows_order = mysql_num_rows($all_order);
}
$totalPages_order = ceil($totalRows_order/$maxRows_order)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table border="1">
  <tr>
    <td>order_id</td>
    <td>customer_id</td>
    <td>totel_price</td>
    <td>statues</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="edit.php?order_id=<?php echo $row_order['order_id']; ?>"><?php echo $row_order['order_id']; ?></a></td>
      <td><?php echo $row_order['customer_id']; ?></td>
      <td><?php echo $row_order['totel_price']; ?></td>
      <td><?php echo $row_order['statues']; ?></td>
    </tr>
    <?php } while ($row_order = mysql_fetch_assoc($order)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($order);
?>
