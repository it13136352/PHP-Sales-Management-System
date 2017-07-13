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

$maxRows_stock2 = 10;
$pageNum_stock2 = 0;
if (isset($_GET['pageNum_stock2'])) {
  $pageNum_stock2 = $_GET['pageNum_stock2'];
}
$startRow_stock2 = $pageNum_stock2 * $maxRows_stock2;

mysql_select_db($database_link, $link);
$query_stock2 = "SELECT * FROM stock";
$query_limit_stock2 = sprintf("%s LIMIT %d, %d", $query_stock2, $startRow_stock2, $maxRows_stock2);
$stock2 = mysql_query($query_limit_stock2, $link) or die(mysql_error());
$row_stock2 = mysql_fetch_assoc($stock2);

if (isset($_GET['totalRows_stock2'])) {
  $totalRows_stock2 = $_GET['totalRows_stock2'];
} else {
  $all_stock2 = mysql_query($query_stock2);
  $totalRows_stock2 = mysql_num_rows($all_stock2);
}
$totalPages_stock2 = ceil($totalRows_stock2/$maxRows_stock2)-1;
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
    <td>item_id</td>
    <td>item_name</td>
    <td>item_size</td>
    <td>unit_price</td>
    <td>quantity</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="editstock.php?item_id=<?php echo $row_stock2['item_id']; ?>"><?php echo $row_stock2['item_id']; ?></a></td>
      <td><?php echo $row_stock2['item_name']; ?></td>
      <td><?php echo $row_stock2['item_size']; ?></td>
      <td><?php echo $row_stock2['unit_price']; ?></td>
      <td><?php echo $row_stock2['quantity']; ?></td>
    </tr>
    <?php } while ($row_stock2 = mysql_fetch_assoc($stock2)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($stock2);
?>
