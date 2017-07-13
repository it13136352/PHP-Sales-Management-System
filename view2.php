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

$maxRows_view2 = 10;
$pageNum_view2 = 0;
if (isset($_GET['pageNum_view2'])) {
  $pageNum_view2 = $_GET['pageNum_view2'];
}
$startRow_view2 = $pageNum_view2 * $maxRows_view2;

$colname_view2 = "-1";
if (isset($_GET['order_id'])) {
  $colname_view2 = $_GET['order_id'];
}
mysql_select_db($database_link, $link);
$query_view2 = sprintf("SELECT * FROM `order` WHERE order_id = %s ORDER BY customer_id ASC", GetSQLValueString($colname_view2, "int"));
$query_limit_view2 = sprintf("%s LIMIT %d, %d", $query_view2, $startRow_view2, $maxRows_view2);
$view2 = mysql_query($query_limit_view2, $link) or die(mysql_error());
$row_view2 = mysql_fetch_assoc($view2);

if (isset($_GET['totalRows_view2'])) {
  $totalRows_view2 = $_GET['totalRows_view2'];
} else {
  $all_view2 = mysql_query($query_view2);
  $totalRows_view2 = mysql_num_rows($all_view2);
}
$totalPages_view2 = ceil($totalRows_view2/$maxRows_view2)-1;
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
    <td><a href="edit.php?order_id=<?php echo $row_view2['order_id']; ?>"><?php echo $row_view2['order_id']; ?></a></td>
      <?php echo $row_view2['order_id']; ?>
      <td><?php echo $row_view2['customer_id']; ?></td>
      <td><?php echo $row_view2['totel_price']; ?></td>
      <td><?php echo $row_view2['statues']; ?></td>
    </tr>
    <?php } while ($row_view2 = mysql_fetch_assoc($view2)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($view2);
?>
