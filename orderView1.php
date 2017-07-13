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

$maxRows_orderView = 10;
$pageNum_orderView = 0;
if (isset($_GET['pageNum_orderView'])) {
  $pageNum_orderView = $_GET['pageNum_orderView'];
}
$startRow_orderView = $pageNum_orderView * $maxRows_orderView;

mysql_select_db($database_link, $link);
$query_orderView = "SELECT * FROM `order` WHERE statues != 'Pending' ORDER BY order_id DESC";
$query_limit_orderView = sprintf("%s LIMIT %d, %d", $query_orderView, $startRow_orderView, $maxRows_orderView);
$orderView = mysql_query($query_limit_orderView, $link) or die(mysql_error());
$row_orderView = mysql_fetch_assoc($orderView);

if (isset($_GET['totalRows_orderView'])) {
  $totalRows_orderView = $_GET['totalRows_orderView'];
} else {
  $all_orderView = mysql_query($query_orderView);
  $totalRows_orderView = mysql_num_rows($all_orderView);
}
$totalPages_orderView = ceil($totalRows_orderView/$maxRows_orderView)-1;

mysql_select_db($database_link, $link);
$query_viewconorder = "SELECT * FROM sales_conferm";
$viewconorder = mysql_query($query_viewconorder, $link) or die(mysql_error());
$row_viewconorder = mysql_fetch_assoc($viewconorder);
$totalRows_viewconorder = mysql_num_rows($viewconorder);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<!------------------------------------------------------->


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
                <a class="navbar-brand" href="dash.html">User Management</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
               <?php /*?>     <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a><?php */?>
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
              <?php /*?>      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a><?php */?>
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
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> User<b class="caret"></b></a>
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
                    <!--------------------------------------------------------->                   
                    <h1 class="page-header">
                            Stock Out
                            <?php /*?><small>Subheading</small><?php */?>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index1.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                    
  <!--------------------------------------------------------->                   </div>
  
  				 
                    <div class="col-lg-6">
   
                   
                  </div>
                  
                  
                  
              </div>
                <!-- /.row -->
                 <font size="+3" color="#0000CC" ><b> View orders</b></font>
                 <br />
                 
                
			  <div class="col-lg-6">
                   <!------------view---------------->
                   <table border="1">
  <tr bgcolor="#FFFF99">
    <td>order_id</td>
    <td>customer_id</td>
    <td>totel_price</td>
    <td>statues</td>
    <td>order_date</td>
    <td>delivery_date</td>
    <td>View</td>
  </tr>
  <?php do { ?>
    <tr>
      <td bgcolor="#CCCCCC"><?php echo $row_orderView['order_id']; ?></td>
      <td bgcolor="#CCCCCC"><?php echo $row_orderView['customer_id']; ?></td>
      <td bgcolor="#CCCCCC"><?php echo $row_orderView['totel_price']; ?></td>
      <td bgcolor="#CCCCCC"><?php echo $row_orderView['statues']; ?></td>
      <td bgcolor="#CCCCCC"><?php echo $row_orderView['order_date']; ?></td>
      <td bgcolor="#CCCCCC"><?php echo $row_orderView['delivery_date']; ?></td>
      <td bgcolor="#CCCCCC"><a href="orderview2.php?order_id=<?php echo $row_orderView['order_id'];?>"><img src="img/red-rectangle-view-button-hi.png" height="50" width="50" /></a></td>
    </tr>
    <?php } while ($row_orderView = mysql_fetch_assoc($orderView)); ?>
</table>
<br />
<br />
                  </div>
                  
            </div>
            <!-- /.container-fluid -->
			 <font size="+3" color="#0000CC" ><b> View Sales Confermation </b></font>
             <table border="1">
               <tr bgcolor="#FFFF99">
                 <td>id</td>
                 <td>shop_id</td>
                 <td>qr</td>
                 <td>status</td>
               </tr>
               <?php do { ?>
                 <tr>
                   <td bgcolor="#CCCCCC"><?php echo $row_viewconorder['id']; ?></td>
                   <td bgcolor="#CCCCCC"><?php echo $row_viewconorder['shop_id']; ?></td>
                   <td bgcolor="#CCCCCC"><?php echo $row_viewconorder['qr']; ?></td>
                   <td bgcolor="#CCCCCC"><?php echo $row_viewconorder['status']; ?></td>
                 </tr>
                 <?php } while ($row_viewconorder = mysql_fetch_assoc($viewconorder)); ?>
             </table>
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


<!------------------------------------------>

<?php
mysql_free_result($orderView);

mysql_free_result($viewconorder);
?>
