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

$maxRows_item = 10;
$pageNum_item = 0;
if (isset($_GET['pageNum_item'])) {
  $pageNum_item = $_GET['pageNum_item'];
}
$startRow_item = $pageNum_item * $maxRows_item;

mysql_select_db($database_link, $link);
$query_item = "SELECT * FROM item";
$query_limit_item = sprintf("%s LIMIT %d, %d", $query_item, $startRow_item, $maxRows_item);
$item = mysql_query($query_limit_item, $link) or die(mysql_error());
$row_item = mysql_fetch_assoc($item);

if (isset($_GET['totalRows_item'])) {
  $totalRows_item = $_GET['totalRows_item'];
} else {
  $all_item = mysql_query($query_item);
  $totalRows_item = mysql_num_rows($all_item);
}
$totalPages_item = ceil($totalRows_item/$maxRows_item)-1;
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
  
      <td><a href="edititem.php?item_id=<?php echo $row_item['item_id']; ?>"><?php echo $row_item['item_id']; ?></a></td>
      <td><?php echo $row_item['item_name']; ?></td>
      <td><?php echo $row_item['unite_price']; ?></td>
    </tr>
    <?php } while ($row_item = mysql_fetch_assoc($item)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($item);
?>
