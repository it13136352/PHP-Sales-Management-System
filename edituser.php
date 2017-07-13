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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE users SET username=%s, password=%s, email=%s, fullName=%s, phoneNo=%s, phoneNoland=%s, `role`=%s, area=%s, regdate=%s, type=%s, `key`=%s, timeSatmp=%s, warehouseId=%s, distributorID=%s WHERE id=%s",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['fullName'], "text"),
                       GetSQLValueString($_POST['phoneNo'], "text"),
                       GetSQLValueString($_POST['phoneNoland'], "int"),
                       GetSQLValueString($_POST['role'], "text"),
                       GetSQLValueString($_POST['area'], "text"),
                       GetSQLValueString($_POST['regdate'], "text"),
                       GetSQLValueString($_POST['type'], "text"),
                       GetSQLValueString($_POST['key'], "text"),
                       GetSQLValueString($_POST['timeSatmp'], "date"),
                       GetSQLValueString($_POST['warehouseId'], "text"),
                       GetSQLValueString($_POST['distributorID'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_link, $link);
  $Result1 = mysql_query($updateSQL, $link) or die(mysql_error());
}

$colname_edituser = "-1";
if (isset($_GET['id'])) {
  $colname_edituser = $_GET['id'];
}
mysql_select_db($database_link, $link);
$query_edituser = sprintf("SELECT * FROM users WHERE id = %s", GetSQLValueString($colname_edituser, "int"));
$edituser = mysql_query($query_edituser, $link) or die(mysql_error());
$row_edituser = mysql_fetch_assoc($edituser);
$totalRows_edituser = mysql_num_rows($edituser);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id:</td>
      <td><?php echo $row_edituser['id']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Username:</td>
      <td><input type="text" name="username" value="<?php echo htmlentities($row_edituser['username'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Password:</td>
      <td><input type="text" name="password" value="<?php echo htmlentities($row_edituser['password'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Email:</td>
      <td><input type="text" name="email" value="<?php echo htmlentities($row_edituser['email'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">FullName:</td>
      <td><input type="text" name="fullName" value="<?php echo htmlentities($row_edituser['fullName'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">PhoneNo:</td>
      <td><input type="text" name="phoneNo" value="<?php echo htmlentities($row_edituser['phoneNo'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">PhoneNoland:</td>
      <td><input type="text" name="phoneNoland" value="<?php echo htmlentities($row_edituser['phoneNoland'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Role:</td>
      <td><input type="text" name="role" value="<?php echo htmlentities($row_edituser['role'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Area:</td>
      <td><input type="text" name="area" value="<?php echo htmlentities($row_edituser['area'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Regdate:</td>
      <td><input type="text" name="regdate" value="<?php echo htmlentities($row_edituser['regdate'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Type:</td>
      <td><input type="text" name="type" value="<?php echo htmlentities($row_edituser['type'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Key:</td>
      <td><input type="text" name="key" value="<?php echo htmlentities($row_edituser['key'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">TimeSatmp:</td>
      <td><input type="text" name="timeSatmp" value="<?php echo htmlentities($row_edituser['timeSatmp'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">WarehouseId:</td>
      <td><input type="text" name="warehouseId" value="<?php echo htmlentities($row_edituser['warehouseId'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">DistributorID:</td>
      <td><input type="text" name="distributorID" value="<?php echo htmlentities($row_edituser['distributorID'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_edituser['id']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($edituser);
?>
