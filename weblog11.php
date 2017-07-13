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
  $insertSQL = sprintf("INSERT INTO reg_cust (User_Name, Shop_Name, Address, TP_shop, TP_mobile, Email, Type) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['User_Name'], "text"),
                       GetSQLValueString($_POST['Shop_Name'], "text"),
                       GetSQLValueString($_POST['Address'], "text"),
                       GetSQLValueString($_POST['TP_shop'], "int"),
                       GetSQLValueString($_POST['TP_mobile'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Type'], "text"));

  mysql_select_db($database_link, $link);
  $Result1 = mysql_query($insertSQL, $link) or die(mysql_error());

  $insertGoTo = "weblog11.php";
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
  $MM_redirectLoginSuccess = "startOrderweb.php";
  $MM_redirectLoginFailed = "weblog11.php";
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

<!------------------------------------------------>
<!DOCTYPE html>
<html lang="en">

<!----------------validation-------------------------->
<script type='text/javascript'>

function formValidator(){
	// Make quick references to our fields
	var uname = document.getElementById('uname');
	var sname = document.getElementById('sname');
	var addr = document.getElementById('addr');
	var tp = document.getElementById('tp');
	var tps = document.getElementById('tps');
	var email = document.getElementById('email');
	
	// Check each input in the order that it appears in the form!
		
	if(notEmpty(uname, "Please enter username") && isAlphabet(uname, "Please enter only letters for your name")){
	if(notEmpty(sname, "Please enter shop name") && isAlphanumeric(sname, "Numbers and Letters Only for shop name")){
	if(notEmpty(addr, "Please enter address") && isAlphanumeric(addr, "Numbers and Letters Only for Address")){
	if( notEmpty(tp, "Please enter shop phone number") && isNumeric(tp,"Please enter a valid shop phone number") && length(tp, "Please enter 10 numbers") ){
	if(notEmpty(tps, "Please enter mobile phone number") && isNumeric(tps, "Please enter a valid mobile phone number") && length(tp, "Please enter 10 numbers")){
	if(notEmpty(email, "Please enter email address") && emailValidator(email, "Please enter a valid email address")){
							return true;
						}
					}
				
				}
			}
		}
	}
	
	
	return false;
	
}

function notEmpty(elem, helperMsg){
	if(elem.value.length == 0){
		alert(helperMsg);
		elem.focus(); // set the focus to this input
		return false;
	}
	return true;
}

function isNumeric(elem, helperMsg){
	var numericExpression = /^[0-9]+$/;
	if(elem.value.match(numericExpression)){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
}

function isAlphabet(elem, helperMsg){
	var alphaExp = /^[a-zA-Z]+$/;
	if(elem.value.match(alphaExp)){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
}

function isAlphanumeric(elem, helperMsg){
	var alphaExp = /^[0-9a-zA-Z]+$/;
	if(elem.value.match(alphaExp)){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
}

function lengthRestriction(elem, min, max){
	var uInput = elem.value;
	if(uInput.length >= min && uInput.length <= max){
		return true;
	}else{
		alert("Please enter between " +min+ " and " +max+ " characters");
		elem.focus();
		return false;
	}
}

function length(elem, helperMsg){
	var uInput = elem.value;
	if(uInput.length == 10){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
}

function madeSelection(elem, helperMsg){
	if(elem.value == "Please Choose"){
		alert(helperMsg);
		elem.focus();
		return false;
	}else{
		return true;
	}
}

function emailValidator(elem, helperMsg){
	var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	if(elem.value.match(emailExp)){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
}
</script>

<!--------------------------------------------------->
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Link5 Solution(SLIIT)</title>
<style type="text/css">
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
</style>

	<link href="themes/1/js-image-slider.css" rel="stylesheet" type="text/css" />
    <script src="themes/1/js-image-slider.js" type="text/javascript"></script>
    <link href="generic.css" rel="stylesheet" type="text/css" />



    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="dash.html">CUSTOMER WEB VIEW</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading">
                                            <strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading">
                                            <strong>Link5</strong>
                                        

  
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading">
                                            <strong>Link5</strong>

                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-footer">
                            <a href="#">Read All New Messages</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">View All</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Web User <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="weblog.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->    
  <!------------------------------------------------------>
   
   <div class="row">
  <div class="col-xs-12 col-sm-6 col-md-8">
  <!----------->
	 <div class="row" id="sliderFrame" align="left">
        <div id="slider">
            <!--<a href="http://www.menucool.com/javascript-image-slider" target="_blank">-->
            <img src="img/img1.jpg" alt="Welcome to link Five.com" />
            <img src="img/img5.jpg" alt="Buy easy..." />
            <img src="img/img3.jpg" alt="Best Producs" />
            <img src="img/img4.jpg" alt="Super Quality" />
            <!--<img src="images/image-slider-5.jpg" />-->
        </div>
       
    </div>

  <!------------->
  </div>
  <div class="col-xs-6 col-md-4">
  
  
<!--------------------------------------------------->
 <div class="active" align="right"><font color="#C0C0C0"> </br>
 <h1>Login...&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h1>
 </font></div>

<div id="login" class="active" align="right" style="margin-right:33px;">
<form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" name="form1">

<table width="400" border="0" cellpadding="0" cellspacing="" height="100">
  <tr>
    <td><input type="text" class="form-control" name="username" id="username" placeholder="Username" autocomplete="off"  /></td>
  </tr>
  <tr>
    <td><table width="400" border="0" cellpadding="0" cellspacing="" height="100">
  <tr>
    <td><input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="off"  /></td>
    </tr>
    <tr>
    <td><input type="submit" value="Sign in" class="btn btn-primary btn-lg btn-block active"  /></td>
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
<!---------------------------------------------------------->

<!--------------------------------------------------------->

<!----------------------------------------------------->

 <div class="active" align="right"><font color="#C0C0C0"> 
 <h1>Rgister Now &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h1>
 </font></div>
 
     <div class="active"  style="margin-right:30px;" align="right" ><font color="#C0C0C0"> 
     
  <form method="post" onsubmit='return formValidator()' name="form1" >
  <table align="right" width="480" border="0" cellpadding="0" cellspacing="" height="300">
    <tr valign="centerline">
      <td nowrap align="center"><strong>User Name:</strong></td>
      <td><input type="text" class="form-control" name="User_Name" id='uname' value="" size="50"></td>
    </tr>
    <tr valign="centerline">
      <td nowrap align="center"><strong>Shop Name:</strong></td>
      <td><input type="text" class="form-control" name="Shop_Name" id='sname' value="" size="50"></td>
    </tr>
    <tr valign="centerline">
      <td nowrap align="center"><strong>Address:</strong></td>
      <td><input type="text" class="form-control" name="Address" id='addr' value="" size="50"></td>
    </tr>
    <tr valign="centerline">
      <td nowrap align="center"><strong>TP shop:</strong></td>
      <td><input type="text" class="form-control" name="TP_shop" id='tp' value="" size="50"></td>
    </tr>
    <tr valign="centerline">
      <td nowrap align="center"><strong>TP mobile:</strong></td>
      <td><input type="text" class="form-control" name="TP_mobile" id='tps' value="" size="50"></td>
    </tr>
    <tr valign="centerline">
      <td nowrap align="center"><strong>Email:</strong></td>
      <td><input type="text" class="form-control" name="Email" id='email' value="" size="50"></td>
    </tr>
    <tr valign="centerline">
      <td nowrap align="center"><strong>Type:</strong></td>
      <td><input type="text" class="form-control" name="Type" value="Online" size="50"></td>
    </tr>
    <tr valign="centerline">
      <td nowrap align="center">&nbsp;</td>
      <td><input type="submit" class="btn btn-primary btn-lg btn-block active" value="Register"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
</font>       
</div>
<!--------------->
     
     </div>
</div>
 <!--------------->    
</div>
    <!-- /#wrapper -->

<!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

<!--------------------------------------------------->
 <div class="footer"><font color="#C0C0C0">© <?php 
$copyYear = 2015; 
$curYear = date('Y'); 
echo $copyYear . (($copyYear != $curYear) ? '-' . $curYear : '');
?>, Link5 Software Solution. All rights reserved.<br />
Design and Develop by <a href="http://www.thamara.lilydigital.com/">LINK5 Sri Lanaka,</a> Powerd by LINK5 Software Solution.ltd.</font></div>
<!---------------------------------------------------->
</body>
</html>
<?php
mysql_free_result($weblog);

mysql_free_result($weblog1);

mysql_free_result($reg1);

mysql_free_result($regiser1);
?>
