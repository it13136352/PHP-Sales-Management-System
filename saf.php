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

$maxRows_as = 10;
$pageNum_as = 0;
if (isset($_GET['pageNum_as'])) {
  $pageNum_as = $_GET['pageNum_as'];
}
$startRow_as = $pageNum_as * $maxRows_as;

$colname_as = "-1";
if (isset($_GET['Cust_Id'])) {
  $colname_as = $_GET['Cust_Id'];
}
mysql_select_db($database_link, $link);
$query_as = sprintf("SELECT * FROM reg_cust WHERE Cust_Id = %s", GetSQLValueString($colname_as, "int"));
$query_limit_as = sprintf("%s LIMIT %d, %d", $query_as, $startRow_as, $maxRows_as);
$as = mysql_query($query_limit_as, $link) or die(mysql_error());
$row_as = mysql_fetch_assoc($as);

if (isset($_GET['totalRows_as'])) {
  $totalRows_as = $_GET['totalRows_as'];
} else {
  $all_as = mysql_query($query_as);
  $totalRows_as = mysql_num_rows($all_as);
}
$totalPages_as = ceil($totalRows_as/$maxRows_as)-1;
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
    <td>Cust_Id</td>
    <td>User_Name</td>
    <td>Password</td>
    <td>Shop_Name</td>
    <td>Address</td>
    <td>TP_shop</td>
    <td>TP_mobile</td>
    <td>Email</td>
    <td>Type</td>
  </tr>
  <?php do { ?>
    <tr>
    
      <td><a href="custedit.php?Cust_Id=<?php echo $row_as['Cust_Id']; ?>"><?php echo $row_as['Cust_Id']; ?></a></td>
      <td><?php echo $row_as['User_Name']; ?></td>
      <td><?php echo $row_as['Password']; ?></td>
      <td><?php echo $row_as['Shop_Name']; ?></td>
      <td><?php echo $row_as['Address']; ?></td>
      <td><?php echo $row_as['TP_shop']; ?></td>
      <td><?php echo $row_as['TP_mobile']; ?></td>
      <td><?php echo $row_as['Email']; ?></td>
      <td><?php echo $row_as['Type']; ?></td>
    </tr>
    <?php } while ($row_as = mysql_fetch_assoc($as)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($as);
?>
