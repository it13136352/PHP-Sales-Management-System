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

$maxRows_view = 10;
$pageNum_view = 0;
if (isset($_GET['pageNum_view'])) {
  $pageNum_view = $_GET['pageNum_view'];
}
$startRow_view = $pageNum_view * $maxRows_view;

$colname_view = "-1";
if (isset($_GET['item_id'])) {
  $colname_view = $_GET['item_id'];
}
mysql_select_db($database_link, $link);
$query_view = sprintf("SELECT * FROM item WHERE item_id = %s ORDER BY item_name ASC", GetSQLValueString($colname_view, "int"));
$query_limit_view = sprintf("%s LIMIT %d, %d", $query_view, $startRow_view, $maxRows_view);
$view = mysql_query($query_limit_view, $link) or die(mysql_error());
$row_view = mysql_fetch_assoc($view);

if (isset($_GET['totalRows_view'])) {
  $totalRows_view = $_GET['totalRows_view'];
} else {
  $all_view = mysql_query($query_view);
  $totalRows_view = mysql_num_rows($all_view);
}
$totalPages_view = ceil($totalRows_view/$maxRows_view)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<form id="form1" name="form1" method="post" action="">
<table border="1">
  <tr>
    <td>item_id</td>
    <td>item_name</td>
    <td>unite_price</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_view['item_id']; ?></td>
      <td><?php echo $row_view['item_name']; ?></td>
      <td><?php echo $row_view['unite_price']; ?></td>
    </tr>
    <?php } while ($row_view = mysql_fetch_assoc($view)); ?>
</table>
</form>
</body>
</html>
<?php
mysql_free_result($view);
?>
