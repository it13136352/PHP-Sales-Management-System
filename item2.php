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

$maxRows_item2 = 10;
$pageNum_item2 = 0;
if (isset($_GET['pageNum_item2'])) {
  $pageNum_item2 = $_GET['pageNum_item2'];
}
$startRow_item2 = $pageNum_item2 * $maxRows_item2;

mysql_select_db($database_link, $link);
$query_item2 = "SELECT * FROM item";
$query_limit_item2 = sprintf("%s LIMIT %d, %d", $query_item2, $startRow_item2, $maxRows_item2);
$item2 = mysql_query($query_limit_item2, $link) or die(mysql_error());
$row_item2 = mysql_fetch_assoc($item2);

if (isset($_GET['totalRows_item2'])) {
  $totalRows_item2 = $_GET['totalRows_item2'];
} else {
  $all_item2 = mysql_query($query_item2);
  $totalRows_item2 = mysql_num_rows($all_item2);
}
$totalPages_item2 = ceil($totalRows_item2/$maxRows_item2)-1;
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
    <td>unite_price</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="editeitem1.php?item_id=<?php echo $row_item2['item_id']; ?>"><?php echo $row_item2['item_id']; ?></a></td>
      <td><?php echo $row_item2['item_name']; ?></td>
      <td><?php echo $row_item2['unite_price']; ?></td>
      <td><a href="Delitem.php?item_id=<?php echo $row_item2['item_id']; ?>">delete</a></td>
    </tr>
    <?php } while ($row_item2 = mysql_fetch_assoc($item2)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($item2);
?>
