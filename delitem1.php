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

if ((isset($_GET['item_id'])) && ($_GET['item_id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM item WHERE item_id=%s",
                       GetSQLValueString($_GET['item_id'], "int"));

  mysql_select_db($database_link, $link);
  $Result1 = mysql_query($deleteSQL, $link) or die(mysql_error());

  $deleteGoTo = "AddNewItem1.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

mysql_select_db($database_link, $link);
$query_delitem1 = "SELECT * FROM item";
$delitem1 = mysql_query($query_delitem1, $link) or die(mysql_error());
$row_delitem1 = mysql_fetch_assoc($delitem1);
$totalRows_delitem1 = mysql_num_rows($delitem1);

mysql_free_result($delitem1);
?>
