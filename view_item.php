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

$maxRows_viewitem = 10;
$pageNum_viewitem = 0;
if (isset($_GET['pageNum_viewitem'])) {
  $pageNum_viewitem = $_GET['pageNum_viewitem'];
}
$startRow_viewitem = $pageNum_viewitem * $maxRows_viewitem;

$colname_viewitem = "-1";
if (isset($_GET['item_id'])) {
  $colname_viewitem = $_GET['item_id'];
}
mysql_select_db($database_link, $link);
$query_viewitem = sprintf("SELECT * FROM item WHERE item_id = %s", GetSQLValueString($colname_viewitem, "int"));
$query_limit_viewitem = sprintf("%s LIMIT %d, %d", $query_viewitem, $startRow_viewitem, $maxRows_viewitem);
$viewitem = mysql_query($query_limit_viewitem, $link) or die(mysql_error());
$row_viewitem = mysql_fetch_assoc($viewitem);

if (isset($_GET['totalRows_viewitem'])) {
  $totalRows_viewitem = $_GET['totalRows_viewitem'];
} else {
  $all_viewitem = mysql_query($query_viewitem);
  $totalRows_viewitem = mysql_num_rows($all_viewitem);
}
$totalPages_viewitem = ceil($totalRows_viewitem/$maxRows_viewitem)-1;
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
      <td><?php echo $row_viewitem['item_id']; ?></td>
      <td><?php echo $row_viewitem['item_name']; ?></td>
      <td><?php echo $row_viewitem['unite_price']; ?></td>
    </tr>
    <?php } while ($row_viewitem = mysql_fetch_assoc($viewitem)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($viewitem);
?>
