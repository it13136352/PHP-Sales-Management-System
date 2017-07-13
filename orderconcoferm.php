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
$query_orderView = "SELECT * FROM `order` WHERE statues = 'Delivered' ORDER BY order_id DESC";
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
?>


<!DOCTYPE html>
<html lang="en">

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
                <a class="navbar-brand" href="repwindow.php">Deliver Ordern</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                
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
                        <h1 class="page-header">
                            Deliver Order
                            <small>(Conferm)</small>
                        </h1>
                      <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="repwindow.php">Sales Rep</a>
                            </li>
                                     
                        </ol>
                     
                       <br/>
                       <br/>
                       
                       <table class="table table-condensed" border="2" width="100"  height="80">
  <tr bgcolor="#FFFF99">
    <td width="126">  order_id  </td>
    <td width="119">  statues  </td>

    <td width="46">  View  </td>
  </tr>
  <?php do { ?>
    <tr bgcolor="#CCCCCC">
      <td><?php echo $row_orderView['order_id']; ?></td>
      <td><?php echo $row_orderView['statues']; ?></td>

      <td ><a href="orderview2rep.php?order_id=<?php echo $row_orderView['order_id'];?>">  View  </a></td>
    </tr>
    <?php } while ($row_orderView = mysql_fetch_assoc($orderView)); ?>
</table>
                       
                       
                  </div>

                    </div>
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

</html>
<?php
mysql_free_result($orderView);
?>
