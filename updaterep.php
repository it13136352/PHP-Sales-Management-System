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
  $updateSQL = sprintf("UPDATE users SET username=%s, password=%s, fullName=%s, phoneNo=%s, phoneNoland=%s, `role`=%s, type=%s WHERE id=%s",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['fullName'], "text"),
                       GetSQLValueString($_POST['phoneNo'], "text"),
                       GetSQLValueString($_POST['phoneNoland'], "int"),
                       GetSQLValueString($_POST['role'], "text"),
                       GetSQLValueString($_POST['type'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_link, $link);
  $Result1 = mysql_query($updateSQL, $link) or die(mysql_error());

  $updateGoTo = "addnewrep.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_updaterep = "-1";
if (isset($_GET['id'])) {
  $colname_updaterep = $_GET['id'];
}
mysql_select_db($database_link, $link);
$query_updaterep = sprintf("SELECT id, username, password, fullName, phoneNo, phoneNoland, `role`, type FROM users WHERE id = %s", GetSQLValueString($colname_updaterep, "int"));
$updaterep = mysql_query($query_updaterep, $link) or die(mysql_error());
$row_updaterep = mysql_fetch_assoc($updaterep);
$totalRows_updaterep = mysql_num_rows($updaterep);
?>
<!DOCTYPE html>

<html lang="en">



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

                <a class="navbar-brand" href="dash.html">SB Admin</a>

            </div>

            <!-- Top Menu Items -->

            <ul class="nav navbar-right top-nav">

                <li class="dropdown">

              <!--      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>-->

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

                 <!--   <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>-->

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

                            <small>Management</small>

                        </h1>

                        <!--<ol class="breadcrumb">

                            <li>

                                <i class="fa fa-dashboard"></i>  <a href="dash.html">Dashboard</a>

                            </li>

                            <li class="active">

                                <i class="fa fa-file"></i> Blank Page

                            </li>                          

                        </ol>-->

                        

                       

                        

                        

                  </div>

                 

              </div>

                <!-- /.row -->
                <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                  <table align="center">
                    <tr valign="baseline">
                      <td nowrap align="right">Id:</td>
                      <td><?php echo $row_updaterep['id']; ?></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">Username:</td>
                      <td><input type="text" name="username" value="<?php echo htmlentities($row_updaterep['username'], ENT_COMPAT, 'utf-8'); ?>" class="form-control" size="60"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">Password:</td>
                      <td><input type="text" name="password" value="<?php echo htmlentities($row_updaterep['password'], ENT_COMPAT, 'utf-8'); ?>" class="form-control" size="60"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">FullName:</td>
                      <td><input type="text" name="fullName" value="<?php echo htmlentities($row_updaterep['fullName'], ENT_COMPAT, 'utf-8'); ?>" class="form-control" size="60"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">PhoneNo:</td>
                      <td><input type="text" name="phoneNo" value="<?php echo htmlentities($row_updaterep['phoneNo'], ENT_COMPAT, 'utf-8'); ?>" class="form-control" size="60"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">PhoneNoland:</td>
                      <td><input type="text" name="phoneNoland" value="<?php echo htmlentities($row_updaterep['phoneNoland'], ENT_COMPAT, 'utf-8'); ?>" class="form-control" size="60"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">Role:</td>
                      <td><input type="text" name="role" value="<?php echo htmlentities($row_updaterep['role'], ENT_COMPAT, 'utf-8'); ?>" class="form-control" size="60"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">Type:</td>
                      <td><select name="type">
                        <option value="Active" <?php if (!(strcmp("Active", htmlentities($row_updaterep['type'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Active</option>
                        <option value="Inactive" <?php if (!(strcmp("Inactive", htmlentities($row_updaterep['type'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Inactive</option>
                      </select></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">&nbsp;</td>
                      <td><input type="submit" value="Update record" class="btn btn-primary btn-lg btn-block active"></td>
                    </tr>
                  </table>
                  <input type="hidden" name="MM_update" value="form1">
                  <input type="hidden" name="id" value="<?php echo $row_updaterep['id']; ?>">
                </form>
                <p>&nbsp;</p>
<p>&nbsp;</p>

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
mysql_free_result($updaterep);
?>
