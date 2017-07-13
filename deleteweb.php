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

if ((isset($_GET['Cust_Id'])) && ($_GET['Cust_Id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM reg_cust WHERE Cust_Id=%s",
                       GetSQLValueString($_GET['Cust_Id'], "int"));

  mysql_select_db($database_link, $link);
  $Result1 = mysql_query($deleteSQL, $link) or die(mysql_error());

  $deleteGoTo = "viewwebuser.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_deleteweb = "-1";
if (isset($_GET['Cust_Id'])) {
  $colname_deleteweb = $_GET['Cust_Id'];
}
mysql_select_db($database_link, $link);
$query_deleteweb = sprintf("SELECT * FROM reg_cust WHERE Cust_Id = %s", GetSQLValueString($colname_deleteweb, "int"));
$deleteweb = mysql_query($query_deleteweb, $link) or die(mysql_error());
$row_deleteweb = mysql_fetch_assoc($deleteweb);
$totalRows_deleteweb = mysql_num_rows($deleteweb);

mysql_free_result($deleteweb);
?>
