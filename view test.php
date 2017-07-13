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

$maxRows_thamara = 10;
$pageNum_thamara = 0;
if (isset($_GET['pageNum_thamara'])) {
  $pageNum_thamara = $_GET['pageNum_thamara'];
}
$startRow_thamara = $pageNum_thamara * $maxRows_thamara;

mysql_select_db($database_link, $link);
$query_thamara = "SELECT * FROM users";
$query_limit_thamara = sprintf("%s LIMIT %d, %d", $query_thamara, $startRow_thamara, $maxRows_thamara);
$thamara = mysql_query($query_limit_thamara, $link) or die(mysql_error());
$row_thamara = mysql_fetch_assoc($thamara);

if (isset($_GET['totalRows_thamara'])) {
  $totalRows_thamara = $_GET['totalRows_thamara'];
} else {
  $all_thamara = mysql_query($query_thamara);
  $totalRows_thamara = mysql_num_rows($all_thamara);
}
$totalPages_thamara = ceil($totalRows_thamara/$maxRows_thamara)-1;
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
    <td>id</td>
    <td>username</td>
    <td>password</td>
    <td>email</td>
    <td>fullName</td>
    <td>phoneNo</td>
    <td>phoneNoland</td>
    <td>role</td>
    <td>area</td>
    <td>regdate</td>
    <td>type</td>
    <td>key</td>
    <td>timeSatmp</td>
    <td>warehouseId</td>
    <td>distributorID</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="edit.php?id=<?php echo $row_thamara['id']; ?>"><?php echo $row_thamara['id']; ?></a></td>
      <td><?php echo $row_thamara['username']; ?></td>
      <td><?php echo $row_thamara['password']; ?></td>
      <td><?php echo $row_thamara['email']; ?></td>
      <td><?php echo $row_thamara['fullName']; ?></td>
      <td><?php echo $row_thamara['phoneNo']; ?></td>
      <td><?php echo $row_thamara['phoneNoland']; ?></td>
      <td><?php echo $row_thamara['role']; ?></td>
      <td><?php echo $row_thamara['area']; ?></td>
      <td><?php echo $row_thamara['regdate']; ?></td>
      <td><?php echo $row_thamara['type']; ?></td>
      <td><?php echo $row_thamara['key']; ?></td>
      <td><?php echo $row_thamara['timeSatmp']; ?></td>
      <td><?php echo $row_thamara['warehouseId']; ?></td>
      <td><?php echo $row_thamara['distributorID']; ?></td>
      <td><a href="delete.php?id=<?php echo $row_thamara['id']; ?>">delete</a></td>
    </tr>
    <?php } while ($row_thamara = mysql_fetch_assoc($thamara)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($thamara);
?>
