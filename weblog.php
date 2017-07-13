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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO reg_cust (User_Name, Shop_Name, Address, TP_shop, TP_mobile, Email) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['User_Name'], "text"),
                       GetSQLValueString($_POST['Shop_Name'], "text"),
                       GetSQLValueString($_POST['Address'], "text"),
                       GetSQLValueString($_POST['TP_shop'], "int"),
                       GetSQLValueString($_POST['TP_mobile'], "text"),
                       GetSQLValueString($_POST['Email'], "text"));

  mysql_select_db($database_link, $link);
  $Result1 = mysql_query($insertSQL, $link) or die(mysql_error());

  $insertGoTo = "../userManagement/window.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "role";
  $MM_redirectLoginSuccess = "website.php";
  $MM_redirectLoginFailed = "weblog.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_link, $link);
  	
  $LoginRS__query=sprintf("SELECT username, password, role FROM users WHERE username=%s AND password=%s AND type='Active'",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $link) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'role');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
	
	
	$time_log = date("g:i A");
  $date_log = date("d/m/Y");
  $massage =/*$user_name.*/" Browsing ";
  
  $riskLeval = "low";
  $fromlog = "syscommSingIn";
  $user_login_id =$_SESSION['MM_Username'];
    $insertSQL = sprintf("INSERT INTO systemLogs (`date`, `time`, massage, `user`, riskLeval, logFrom) VALUES (%s, %s, %s, %s, %s, %s)",
                   
                       GetSQLValueString($date_log, "text"),
                       GetSQLValueString($time_log, "text"),
                       GetSQLValueString($massage, "text"),
                       GetSQLValueString($user_login_id, "text"),
                       GetSQLValueString($riskLeval, "text"),
					   GetSQLValueString($fromlog, "text"));

  mysql_select_db($database_link, $link);
  $Result1 = mysql_query($insertSQL, $link) or die(mysql_error());
	
	
    header("Location: " . $MM_redirectLoginSuccess );
	
	
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Link5 Solution(SLIIT)</title>
<style type="text/css">
#login {
	width: 302px;
	background: #fff;
	background: -webkit-gradient(linear,left top,left bottom,color-stop(0%,#fff),color-stop(100%,#ddd));
	background: -webkit-linear-gradient(top,#fff 0,#ddd 100%);
	background: -moz-linear-gradient(top,#fff 0,#ddd 100%);
	background: -ms-linear-gradient(top,#fff 0,#ddd 100%);
	background: -o-linear-gradient(top,#fff 0,#ddd 100%);
	background: linear-gradient(top,#fff 0,#ddd 100%);
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	border-left: solid 1px #eee;
	border-right: solid 1px #eee;
	border-bottom: solid 1px #ccc;
	-webkit-box-shadow: 0 1px 0 rgba(0,0,0,.1);
	box-shadow: 0 1px 0 rgba(0,0,0,.1);
	padding: 10px;
	margin-top: 0%;
	margin-right: auto;
	margin-left: auto;
}
body {
	background-color: #CCC;
	background:url(img/desktop/background.jpg) center center no-repeat fixed;
	background-size:cover;
	-webkit-background-size:cover;
	-moz-background-size:cover;
	-o-background-size:cover;
	-ms-background-size:cover;
	
}
#username{
	border: 1px solid #ccc;
-webkit-box-shadow: inset 0 1px 0 #eee,#fff 0 1px 0;
box-shadow: inset 0 1px 0 #eee,#fff 0 1px 0;
-webkit-border-radius: 3px;
-moz-border-radius: 3px;
border-radius: 3px;
width: 291px;
height: 25px;
display: inline-block;
padding: 4px;
margin: 0;
outline: 0;
background-color: #fff;
}
#password{
	border: 1px solid #ccc;
-webkit-box-shadow: inset 0 1px 0 #eee,#fff 0 1px 0;
box-shadow: inset 0 1px 0 #eee,#fff 0 1px 0;
-webkit-border-radius: 3px;
-moz-border-radius: 3px;
border-radius: 3px;
width: 210px;
height: 25px;
display: inline-block;
padding: 4px;
margin: 0;
outline: 0;
background-color: #fff;}
  .myButton {
        
        -moz-box-shadow: 0px 1px 0px 0px #f0f7fa;
        -webkit-box-shadow: 0px 1px 0px 0px #f0f7fa;
        box-shadow: 0px 1px 0px 0px #f0f7fa;
        
        background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #33bdef), color-stop(1, #019ad2));
        background:-moz-linear-gradient(top, #33bdef 5%, #019ad2 100%);
        background:-webkit-linear-gradient(top, #33bdef 5%, #019ad2 100%);
        background:-o-linear-gradient(top, #33bdef 5%, #019ad2 100%);
        background:-ms-linear-gradient(top, #33bdef 5%, #019ad2 100%);
        background:linear-gradient(to bottom, #33bdef 5%, #019ad2 100%);
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#33bdef', endColorstr='#019ad2',GradientType=0);
        
        background-color:#33bdef;
        
        -moz-border-radius:6px;
        -webkit-border-radius:6px;
        border-radius:6px;
        
        border:1px solid #057fd0;
        
        display:inline-block;
        color:#ffffff;
        font-family:arial;
        font-size:13px;
        font-weight:bold;
        padding:6px 10px;
        text-decoration:none;
        
        text-shadow:0px -1px 0px #5b6178;
        
    }
    .myButton:hover {
        
        background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #019ad2), color-stop(1, #33bdef));
        background:-moz-linear-gradient(top, #019ad2 5%, #33bdef 100%);
        background:-webkit-linear-gradient(top, #019ad2 5%, #33bdef 100%);
        background:-o-linear-gradient(top, #019ad2 5%, #33bdef 100%);
        background:-ms-linear-gradient(top, #019ad2 5%, #33bdef 100%);
        background:linear-gradient(to bottom, #019ad2 5%, #33bdef 100%);
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#019ad2', endColorstr='#33bdef',GradientType=0);
        
        background-color:#019ad2;
    }
    .myButton:active {
        position:relative;
        top:1px;
    }

.forgot {
	font-size: 11px;
line-height: 13px;
color: #999;
text-shadow: 0 1px 0 rgba(255,255,255,.6);
font-family:Arial, Helvetica, sans-serif;
}
.remember-forgot{
		font-size: 11px;
line-height: 13px;
color: #999;
text-shadow: 0 1px 0 rgba(255,255,255,.6);
font-family:Arial, Helvetica, sans-serif;}
.pal_logo {
	margin-top: 8%;
	margin-right: auto;
	margin-left: auto;
}
.footer {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	line-height: 12px;
	margin-right: auto;
	margin-left: auto;
	text-align: center;
	margin-bottom: 2px;
	position: absolute;
	left: 0px;
	right: 0px;
	bottom: 4px;
	padding: 3px;
	margin-top: 2px;
	shadow: 2px 0px 4px #00647c;
	-moz-box-shadow: 2px 0px 4px #00647c;
	-webkit-box-shadow: 2px 0px 4px #00647c;
	box-shadow: 2px 0px 4px #00647c;
	background-image: url(img/desktop/login.);
}
a:link {
	color: #333;
	text-decoration: none;
}
a:visited {
	color: #333;
	text-decoration: none;
}
a:hover {
	color: #CCC;
	text-decoration: none;
}
a:active {
	color: #333;
	text-decoration: none;
}
</style>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Link5 Solution(SLIIT)</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<body>
<div class="pal_logo" align="center"><font color="#CC0099" size="+5"><b>LINK5 Online Orders</b></font></div>
<br />
<br />
<table>
<tr>
<td>
<div id="login" >
<form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" name="form1">
<table width="302" border="0" cellpadding="0" cellspacing="0" height="107">
  <tr>
    <td><input type="text" name="username" id="username" placeholder="Username" autocomplete="off"  /></td>
  </tr>
  <tr>
    <td><table width="302" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><input type="password" name="password" id="password" placeholder="Password" autocomplete="off"  /></td>
    <td><input type="submit" value="Sign in" class="myButton"  /></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td><div class="remember-forgot"><span class="separator">·</span><a class="forgot" href="/account/resend_password">Forgot password?</a>
        </div></td>
  </tr>
</table>
</form>
</div>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>

</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td align="right"><font size="+3"><b>Register Here......</b></font>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="right">
    <tr valign="centerline">
      <td nowrap align="center"><strong>User Name:</strong></td>
      <td><input type="text" class="form-control" name="User_Name" value="" size="32"></td>
    </tr>
    <tr valign="centerline">
      <td nowrap align="center"><strong>Shop Name:</strong></td>
      <td><input type="text" class="form-control" name="Shop_Name" value="" size="32"></td>
    </tr>
    <tr valign="centerline">
      <td nowrap align="center"><strong>Address:</strong></td>
      <td><input type="text" class="form-control" name="Address" value="" size="32"></td>
    </tr>
    <tr valign="centerline">
      <td nowrap align="center"><strong>TP shop:</strong></td>
      <td><input type="text" class="form-control" name="TP_shop" value="" size="32"></td>
    </tr>
    <tr valign="centerline">
      <td nowrap align="center"><strong>TP mobile:</strong></td>
      <td><input type="text" class="form-control" name="TP_mobile" value="" size="32"></td>
    </tr>
    <tr valign="centerline">
      <td nowrap align="center"><strong>Email:</strong></td>
      <td><input type="text" class="form-control" name="Email" value="" size="32"></td>
    </tr>
    <tr valign="centerline">
      <td nowrap align="center"><strong>Type:</strong></td>
      <td>Online</td>
    </tr>
    <tr valign="centerline">
      <td nowrap align="center">&nbsp;</td>
      <td><input type="submit" class="btn btn-primary btn-lg btn-block active" value="Insert record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
</td>
</tr>
</table>
<br>
<br>


<div class="footer">© <?php 
$copyYear = 2013; 
$curYear = date('Y'); 
echo $copyYear . (($copyYear != $curYear) ? '-' . $curYear : '');
?>, Link5 Software Solution. All rights reserved.<br />
Design and Develop by <a href="http://www.thamara.lilydigital.com/">LINK5 Sri Lanaka,</a> Powerd by LINK5 Software Solution.ltd.</div>
</body>
</html>