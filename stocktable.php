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

$maxRows_ert = 10;
$pageNum_ert = 0;
if (isset($_GET['pageNum_ert'])) {
  $pageNum_ert = $_GET['pageNum_ert'];
}
$startRow_ert = $pageNum_ert * $maxRows_ert;

mysql_select_db($database_link, $link);
$query_ert = "SELECT * FROM stock ";
$query_limit_ert = sprintf("%s LIMIT %d, %d", $query_ert, $startRow_ert, $maxRows_ert);
$ert = mysql_query($query_limit_ert, $link) or die(mysql_error());
$row_ert = mysql_fetch_assoc($ert);

if (isset($_GET['totalRows_ert'])) {
  $totalRows_ert = $_GET['totalRows_ert'];
} else {
  $all_ert = mysql_query($query_ert);
  $totalRows_ert = mysql_num_rows($all_ert);
}
$totalPages_ert = ceil($totalRows_ert/$maxRows_ert)-1;
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
      <td><a href="stock3.php?item_id=<?php echo $row_thamara['item_id']; ?>"><?php echo $row_thamara['item_id']; ?></a></td>
      <td><?php echo $row_ert['item_id']; ?></td>
      <td><?php echo $row_ert['item_name']; ?></td>
      <td><?php echo $row_ert['item_size']; ?></td>
      <td><?php echo $row_ert['unit_price']; ?></td>
      <td><?php echo $row_ert['quantity']; ?></td>
    </tr>
    <?php } while ($row_ert = mysql_fetch_assoc($ert)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($ert);
?>
