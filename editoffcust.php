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



if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {

  $updateSQL = sprintf("UPDATE reg_cust SET User_Name=%s, Shop_Name=%s, Address=%s, TP_shop=%s, TP_mobile=%s, Email=%s WHERE Cust_Id=%s",

                       GetSQLValueString($_POST['User_Name'], "text"),

                       GetSQLValueString($_POST['Shop_Name'], "text"),

                       GetSQLValueString($_POST['Address'], "text"),

                       GetSQLValueString($_POST['TP_shop'], "int"),

                       GetSQLValueString($_POST['TP_mobile'], "text"),

                       GetSQLValueString($_POST['Email'], "text"),

                       GetSQLValueString($_POST['Cust_Id'], "int"));



  mysql_select_db($database_link, $link);

  $Result1 = mysql_query($updateSQL, $link) or die(mysql_error());



  $updateGoTo = "Addofflinereg.php";

  if (isset($_SERVER['QUERY_STRING'])) {

    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";

    $updateGoTo .= $_SERVER['QUERY_STRING'];

  }



}



$colname_editoffcust = "-1";

if (isset($_GET['Cust_Id'])) {

  $colname_editoffcust = $_GET['Cust_Id'];

}

mysql_select_db($database_link, $link);

$query_editoffcust = sprintf("SELECT * FROM reg_cust WHERE Cust_Id = %s", GetSQLValueString($colname_editoffcust, "int"));

$editoffcust = mysql_query($query_editoffcust, $link) or die(mysql_error());

$row_editoffcust = mysql_fetch_assoc($editoffcust);

$totalRows_editoffcust = mysql_num_rows($editoffcust);

?>

<?php require_once('Connections/link.php'); ?>

<!DOCTYPE html>

<html lang="en">



<!---------------validation--------------------------->

<script type='text/javascript'>



function formValidator2(){

	// Make quick references to our fields

	var username1 = document.getElementById('username1');

	var sname1 = document.getElementById('sname1');

	var addr1 = document.getElementById('addr1');

	var tp1 = document.getElementById('tp1');

	var tps1 = document.getElementById('tps1');

	var email1 = document.getElementById('email1');

	

	// Check each input in the order that it appears in the form!

		

	if(notEmpty(username1, "Please enter username") && isAlphabet(username1, "Please enter only letters for your name")){

		

			if(notEmpty(sname1, "Please enter shop name") && isAlphanumeric(sname1, "Numbers and Letters Only for shop name")){

		

		if(notEmpty(addr1, "Please enter address") && isAlphanumeric(addr1, "Numbers and Letters Only for Address")){

			

			if( notEmpty(tp1, "Please enter shop phone number") && isNumeric(tp1,"Please enter a valid shop phone number") && length(tp1, "Please enter 10 numbers") ){

				

				if(notEmpty(tps1, "Please enter mobile phone number") && isNumeric(tps1, "Please enter a valid mobile phone number") && length(tps1, "Please enter 10 numbers")){

				

						if(notEmpty(email1, "Please enter email address") && emailValidator(email1, "Please enter a valid email address")){

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

                <a class="navbar-brand" href="repwindow.php">Edit Customer</a>

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

                        <h1 class="page-header">Edit Offline Customer</h1>

                        <ol class="breadcrumb">

                            <li>

                                <i class="fa fa-dashboard"></i>  <a href="repwindow.php">Sales Rep</a>

                            </li>

                

                          <?php /*?><form method="post" name="form1" action="<?php echo $editFormAction; ?>"></form><?php */?>

                          <form method="post" name="form2" action="<?php echo $editFormAction; ?>" onsubmit='return formValidator2()'>

                            <table align="center" width="480" border="0" height="350>

                              <tr valign="centerline">

                                <td nowrap align="right"><strong>Cust Id:</strong></td>

                                <td><?php echo $row_editoffcust['Cust_Id']; ?></td>

                              </tr>

                              <tr valign="centerline">

                                <td nowrap align="right"><strong>User Name:</strong></td>

                                <td><input type="text" name="User_Name"  class="form-control"  value="<?php echo htmlentities($row_editoffcust['User_Name'], ENT_COMPAT, 'utf-8'); ?>" id="username1" size="50"></td>

                              </tr>

                              <tr valign="centerline">

                                <td nowrap align="right"><strong>Shop Name:</strong></td>

                                <td><input type="text" name="Shop_Name"  class="form-control"  value="<?php echo htmlentities($row_editoffcust['Shop_Name'], ENT_COMPAT, 'utf-8'); ?>" id="sname1" size="50"></td>

                              </tr>

                              <tr valign="centerline">

                                <td nowrap align="right"><strong>Address:</strong></td>

                                <td><input type="text" name="Address"  class="form-control"  value="<?php echo htmlentities($row_editoffcust['Address'], ENT_COMPAT, 'utf-8'); ?>" id="addr1" size="50"></td>

                              </tr>

                              <tr valign="centerline">

                                <td nowrap align="right"><strong>TP shop:</strong></td>

                                <td><input type="text" name="TP_shop"  class="form-control"  value="<?php echo htmlentities($row_editoffcust['TP_shop'], ENT_COMPAT, 'utf-8'); ?>" id="tp1" size="50"></td>

                              </tr>

                              <tr valign="centerline">

                                <td nowrap align="right"><strong>TP Mobile:</strong></td>

                                <td><input type="text" name="TP_mobile"  class="form-control"  value="<?php echo htmlentities($row_editoffcust['TP_mobile'], ENT_COMPAT, 'utf-8'); ?>" id="tps1" size="50"></td>

                              </tr>

                              <tr valign="centerline">

                                <td nowrap align="right"><strong>Email:</strong></td>

                                <td><input type="text" name="Email"  class="form-control"  value="<?php echo htmlentities($row_editoffcust['Email'], ENT_COMPAT, 'utf-8'); ?>" id="email1" size="50"></td>

                              </tr>

                              <tr valign="baseline">

                                <td nowrap align="right">&nbsp;</td>

                                <td><input type="submit" value="Update record" class="btn btn-primary btn-lg btn-block active"></td>

                              </tr>

                            </table>

                            <input type="hidden" name="MM_update" value="form2">

                            <input type="hidden" name="Cust_Id" value="<?php echo $row_editoffcust['Cust_Id']; ?>">

                          </form>

                          <p>&nbsp;</p>

<p>&nbsp;</p>

                        </ol>

                    </div>

                </div>

            <!-- /.row --></div>

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

mysql_free_result($editoffcust);





?>

