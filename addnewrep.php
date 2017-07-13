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
  $insertSQL = sprintf("INSERT INTO users (username, password, email, fullName, phoneNo, phoneNoland, `role`, type) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['fullName'], "text"),
                       GetSQLValueString($_POST['phoneNo'], "text"),
                       GetSQLValueString($_POST['phoneNoland'], "int"),
                       GetSQLValueString($_POST['role'], "text"),
                       GetSQLValueString($_POST['type'], "text"));

  mysql_select_db($database_link, $link);
  $Result1 = mysql_query($insertSQL, $link) or die(mysql_error());

  $insertGoTo = "addnewrep.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_link, $link);
$query_insertrep = "SELECT username, password, email, fullName, phoneNo, phoneNoland, `role`, type FROM users";
$insertrep = mysql_query($query_insertrep, $link) or die(mysql_error());
$row_insertrep = mysql_fetch_assoc($insertrep);
$totalRows_insertrep = mysql_num_rows($insertrep);

$maxRows_vivewrep = 10;
$pageNum_vivewrep = 0;
if (isset($_GET['pageNum_vivewrep'])) {
  $pageNum_vivewrep = $_GET['pageNum_vivewrep'];
}
$startRow_vivewrep = $pageNum_vivewrep * $maxRows_vivewrep;

mysql_select_db($database_link, $link);
$query_vivewrep = "SELECT id, username, password, email, fullName, phoneNo, phoneNoland, `role`, type FROM users WHERE role = 'Rep'";
$query_limit_vivewrep = sprintf("%s LIMIT %d, %d", $query_vivewrep, $startRow_vivewrep, $maxRows_vivewrep);
$vivewrep = mysql_query($query_limit_vivewrep, $link) or die(mysql_error());
$row_vivewrep = mysql_fetch_assoc($vivewrep);

if (isset($_GET['totalRows_vivewrep'])) {
  $totalRows_vivewrep = $_GET['totalRows_vivewrep'];
} else {
  $all_vivewrep = mysql_query($query_vivewrep);
  $totalRows_vivewrep = mysql_num_rows($all_vivewrep);
}
$totalPages_vivewrep = ceil($totalRows_vivewrep/$maxRows_vivewrep)-1;
?>
\
<!---------------validation--------------------------->
<script type='text/javascript'>

function formValidator(){
	// Make quick references to our fields
	var username = document.getElementById('username');
	var pwd = document.getElementById('pwd');
	var email = document.getElementById('email');
	var fname = document.getElementById('fname');
	var tp = document.getElementById('tp');
	var tps = document.getElementById('tps');
	
	
	// Check each input in the order that it appears in the form!
		
	if(notEmpty(username, "Please enter username") && isAlphabet(username, "Please enter only letters for your name")){
		
		if(notEmpty(pwd, "Please enter password") && lengthRestriction(pwd, 6, 10)){
			
			if(notEmpty(email, "Please enter email address") && emailValidator(email, "Please enter a valid email address")){
			
			if(notEmpty(fname, "Please enter shop name") && isAlphanumeric(fname, "Numbers and Letters Only for shop name")){
			
			if( notEmpty(tp, "Please enter shop phone number") && isNumeric(tp,"Please enter a valid shop phone number") && length(tp, "Please enter 10 numbers") ){
				
				if(notEmpty(tps, "Please enter mobile phone number") && isNumeric(tps, "Please enter a valid mobile phone number") && length(tps, "Please enter 10 numbers")){
	
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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

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
                <a class="navbar-brand" href="dash.html">Update REP</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <?php /*?><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a><?php */?>
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
                                            <strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
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
               <?php /*?>     <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a><?php */?>
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
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>User<b class="caret"></b></a>
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
                            <a href="index.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="dash.html"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="addheadusers.php"><i class="fa fa-fw fa-bar-chart-o"></i> User Management</a>
                    </li>
                    <li>
                        <a href="replocation.php"><i class="fa fa-fw fa-table"></i>Rep Location</a>
                    </li>
                    <li>
                        <a href="stockin.php"><i class="fa fa-fw fa-edit"></i>Store</a>
                    </li>
                    <li>
                        <a href="AddNewItem1.php"><i class="fa fa-fw fa-edit"></i>Add Item</a>
                    </li>
                    <li>
                        <a href="addnewrep.php"><i class="fa fa-fw fa-desktop"></i> REP Management</a>
                    </li>
                    
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i>Sales Management<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="orderView1.php">View Orders</a>
                            </li>
                            <li>
                                <a href="viewwebuser.php">View New Client</a>
                            </li>
                        </ul>
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
                        <h1 class="page-header">
                            REP
                            <small>Management</small><br>
                        </h1>
                       
                </div>
                <form method="post" name="form1" action="<?php echo $editFormAction; ?>" onsubmit='return formValidator()'>
                  <table align="center">
                    <tr valign="baseline">
                      <td nowrap align="right">Username:</td>
                      <td><input type="text" name="username" value="" id="username" class="form-control" size="60"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">Password:</td>
                      <td><input type="text" name="password" value="" id="pwd" class="form-control" size="60"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">Email:</td>
                      <td><input type="text" name="email" value="" id="email" class="form-control" size="60"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">FullName:</td>
                      <td><input type="text" name="fullName" value="" id="fname" class="form-control" size="60"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">PhoneNo:</td>
                      <td><input type="text" name="phoneNo" value="" id="tp" class="form-control" size="60"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">PhoneNoland:</td>
                      <td><input type="text" name="phoneNoland" value="" id="tps" class="form-control" size="60"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">Role:</td>
                      <td><input type="text" name="role" value="Rep" class="form-control" size="60"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">Type:</td>
                      <td><input type="text" name="type" value="Active" class="form-control" size="60"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">&nbsp;</td>
                      <td><input type="submit" value="Insert record" class="btn btn-primary btn-lg btn-block active"></td>
                    </tr>
                  </table>
                  <input type="hidden" name="MM_insert" value="form1">
                </form>
                
                <p>&nbsp;</p>
                
                <br>
                <table border="1">
                  <tr bgcolor="#FFFF99">
                    <td>id</td>
                    <td>username</td>
                    <td>password</td>
                    <td>email</td>
                    <td>fullName</td>
                    <td>phoneNo</td>
                    <td>phoneNoland</td>
                    <td>role</td>
                    <td>type</td>
                  </tr>
                  <?php do { ?>
                    <tr>
                       <td bgcolor="#CCCCCC"><a href="updaterep.php?id=<?php echo $row_vivewrep['id']; ?>"><?php echo $row_vivewrep['id']; ?></a></td>
                      <td bgcolor="#CCCCCC"><?php echo $row_vivewrep['username']; ?></td>
                      <td bgcolor="#CCCCCC"><?php echo $row_vivewrep['password']; ?></td>
                      <td bgcolor="#CCCCCC"><?php echo $row_vivewrep['email']; ?></td>
                      <td bgcolor="#CCCCCC"><?php echo $row_vivewrep['fullName']; ?></td>
                      <td bgcolor="#CCCCCC"><?php echo $row_vivewrep['phoneNo']; ?></td>
                      <td bgcolor="#CCCCCC"><?php echo $row_vivewrep['phoneNoland']; ?></td>
                      <td bgcolor="#CCCCCC"><?php echo $row_vivewrep['role']; ?></td>
                      <td bgcolor="#CCCCCC"><?php echo $row_vivewrep['type']; ?></td>
                      <td><a href="deleterep.php?id=<?php echo $row_vivewrep['id']; ?>"><img src="img/delete.png" width="153" height="36"></a></td>
                    </tr>
                    <?php } while ($row_vivewrep = mysql_fetch_assoc($vivewrep)); ?>
                </table>
              </div>
                <!-- /.row -->
      
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
<?php
mysql_free_result($viewrep);

mysql_free_result($insertrep);

mysql_free_result($vivewrep);
?>
