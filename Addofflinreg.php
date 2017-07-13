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
  $insertSQL = sprintf("INSERT INTO reg_cust (User_Name, Password, Shop_Name, Address, TP_shop, TP_mobile, Email, Type) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['User_Name'], "text"),
                       GetSQLValueString($_POST['Password'], "text"),
                       GetSQLValueString($_POST['Shop_Name'], "text"),
                       GetSQLValueString($_POST['Address'], "text"),
                       GetSQLValueString($_POST['TP_shop'], "int"),
                       GetSQLValueString($_POST['TP_mobile'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Type'], "text"));

  mysql_select_db($database_link, $link);
  $Result1 = mysql_query($insertSQL, $link) or die(mysql_error());

  $insertGoTo = "Addofflinreg.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_viewoffline = 10;
$pageNum_viewoffline = 0;
if (isset($_GET['pageNum_viewoffline'])) {
  $pageNum_viewoffline = $_GET['pageNum_viewoffline'];
}
$startRow_viewoffline = $pageNum_viewoffline * $maxRows_viewoffline;

mysql_select_db($database_link, $link);
$query_viewoffline = "SELECT Cust_Id, User_Name, Shop_Name, Address, TP_shop, TP_mobile, Type FROM reg_cust WHERE reg_cust.Type = 'Offline'";
$query_limit_viewoffline = sprintf("%s LIMIT %d, %d", $query_viewoffline, $startRow_viewoffline, $maxRows_viewoffline);
$viewoffline = mysql_query($query_limit_viewoffline, $link) or die(mysql_error());
$row_viewoffline = mysql_fetch_assoc($viewoffline);

if (isset($_GET['totalRows_viewoffline'])) {
  $totalRows_viewoffline = $_GET['totalRows_viewoffline'];
} else {
  $all_viewoffline = mysql_query($query_viewoffline);
  $totalRows_viewoffline = mysql_num_rows($all_viewoffline);
}
$totalPages_viewoffline = ceil($totalRows_viewoffline/$maxRows_viewoffline)-1;
?>
<!DOCTYPE html>
<html lang="en">

<!---------------validation--------------------------->
<script type='text/javascript'>

function formValidator(){
	// Make quick references to our fields
	var username = document.getElementById('username');
	var pwd = document.getElementById('pwd');
	var sname = document.getElementById('sname');
	var addr = document.getElementById('addr');
	var tp = document.getElementById('tp');
	var tps = document.getElementById('tps');
	var email = document.getElementById('email');
	
	// Check each input in the order that it appears in the form!
		
	if(notEmpty(username, "Please enter username") && isAlphabet(username, "Please enter only letters for your name")){
		
		if(notEmpty(pwd, "Please enter password") && lengthRestriction(pwd, 6, 10)){
			
			if(notEmpty(sname, "Please enter shop name") && isAlphanumeric(sname, "Numbers and Letters Only for shop name")){
		
		if(notEmpty(addr, "Please enter address") && isAlphanumeric(addr, "Numbers and Letters Only for Address")){
			
			if( notEmpty(tp, "Please enter shop phone number") && isNumeric(tp,"Please enter a valid shop phone number") && length(tp, "Please enter 10 numbers") ){
				
				if(notEmpty(tps, "Please enter mobile phone number") && isNumeric(tps, "Please enter a valid mobile phone number") && length(tp, "Please enter 10 numbers")){
				
						if(notEmpty(email, "Please enter email address") && emailValidator(email, "Please enter a valid email address")){
							return true;
						}
					}
				
		}}
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
	var alphaExp = /^[0-9a-zA-Z ]*$/;
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
<!----------------------------------------------------->
<head>

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
                <a class="navbar-brand" href="repwindow.php">RepManagement</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> User <b class="caret"></b></a>
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
                            <a href="repindex.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="repwindow.php"><i class="fa fa-fw fa-dashboard"></i> Sales Rep</a>
                    </li>
                    <li>
                        <a href="Addofflinreg.php"><i class="fa fa-fw fa-bar-chart-o"></i> Client Registration</a>
                    </li>
                   
                    <li>
                        <a href="ordernewrep.php"><i class="fa fa-fw fa-edit"></i>Get Orders</a>
                    </li>
                    
                    
                     <li>
                        <a href="orderconcoferm.php"><i class="fa fa-fw fa-edit"></i>View Conferm Orders</a>
                    </li>
                    
                    
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Manage Offline Customer</h1>
                       <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="repwindow.php">Sales Rep</a>
                            </li>
                                                      
                        </ol>
                      
                          <form method="post" name="form1" action="<?php echo $editFormAction; ?>" onsubmit='return formValidator()'>
                            <table align="center"  width="480" border="0" cellpadding="0" cellspacing="" height="400" >
                              <tr valign="centerline">
                                <td nowrap align="right"><strong>User Name:</strong></td>
                                <td><input type="text" class="form-control" name="User_Name" id="username" value="" size="32"></td>
                              </tr>
                              <tr valign="centerline">
                                <td nowrap align="right"><strong>Password:</strong></td>
                                <td><input type="text" class="form-control" name="Password" value="" id="pwd" size="32"></td>
                              </tr>
                              <tr valign="centerline">
                                <td nowrap align="right"><strong>Shop Name:</strong></td>
                                <td><input type="text" class="form-control" name="Shop_Name" value="" id="sname" size="32"></td>
                              </tr>
                              <tr valign="centerline">
                                <td nowrap align="right"><strong>Address:</strong></td>
                                <td><input type="text" class="form-control" name="Address" value="" id="addr" size="32"></td>
                              </tr>
                              <tr valign="centerline">
                                <td nowrap align="right"><strong>TP Shop:</strong></td>
                                <td><input type="text" class="form-control" name="TP_shop" value="" id="tp" size="32"></td>
                              </tr>
                              <tr valign="centerline">
                                <td nowrap align="right"><strong>TP Mobile:</strong></td>
                                <td><input type="text" class="form-control" name="TP_mobile" value="" id="tps" size="32"></td>
                              </tr>
                              <tr valign="centerline">
                                <td nowrap align="right"><strong>Email:</strong></td>
                                <td><input type="text" class="form-control" name="Email" value="" id="email" size="32"></td>
                              </tr>
                              <tr valign="centerline">
                                <td nowrap align="right"><strong>Type:</strong></td>
                                <td><select name="Type" class="form-control">
                                  <option value="Offline"  <?php if (!(strcmp("Offline", ""))) {echo "SELECTED";} ?>>Offline</option>
                                  <option value="Online" <?php if (!(strcmp("Online", ""))) {echo "SELECTED";} ?>>Online</option>
                                </select></td>
                              </tr>
                              <tr valign="centerline">
                                <td nowrap align="right">&nbsp;</td>
                                <td><input type="submit"  class="btn btn-primary btn-lg btn-block active" value="Insert record" ></td>
                              </tr>
                            </table>
                            <input type="hidden" name="MM_insert" value="form1">
                          </form>
                          <p>&nbsp;</p>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                <table class="table table-condensed"  border="2" width="100"  height="80">
                  <tr bgcolor="#FFFF99">
                    <td>Customer Id</td>
                    <td>User Name</td>
                    <td>Shop Name</td>
                    <td>Address</td>
                    <td>TP Shop</td>
                    <td>TP Mobile</td>
                    <td>Type</td>
                  </tr>
                  <?php do { ?>
                    <tr>
                     
         <td bgcolor="#CCCCCC"><a href="editoffcust.php?Cust_Id=<?php echo $row_viewoffline['Cust_Id']; ?>"><?php echo $row_viewoffline['Cust_Id']; ?></a></td>              
                      <td bgcolor="#CCCCCC"><?php echo $row_viewoffline['User_Name']; ?></td>
                      <td bgcolor="#CCCCCC"><?php echo $row_viewoffline['Shop_Name']; ?></td>
                      <td bgcolor="#CCCCCC"><?php echo $row_viewoffline['Address']; ?></td>
                      <td bgcolor="#CCCCCC"><?php echo $row_viewoffline['TP_shop']; ?></td>
                      <td bgcolor="#CCCCCC"><?php echo $row_viewoffline['TP_mobile']; ?></td>
                      <td bgcolor="#CCCCCC"><?php echo $row_viewoffline['Type']; ?></td>
                    </tr>
                    <?php } while ($row_viewoffline = mysql_fetch_assoc($viewoffline)); ?>
                </table>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
<?php
mysql_free_result($viewoffline);
?>
