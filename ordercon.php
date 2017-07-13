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
  $insertSQL = sprintf("INSERT INTO poi_example (id, lat, lon) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['lat'], "text"),
                       GetSQLValueString($_POST['lon'], "text"));

  mysql_select_db($database_link, $link);
  $Result1 = mysql_query($insertSQL, $link) or die(mysql_error());

  $insertGoTo = "www.link/ordercon.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_link, $link);
$query_Recordset1 = "SELECT id, lat, lon FROM poi_example";
$Recordset1 = mysql_query($query_Recordset1, $link) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php /*?><link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" /><?php */?>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>






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
                <a class="navbar-brand" href="repwindow.php">Conferm Order</a>
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
                        <a href="repwindow"><i class="fa fa-fw fa-dashboard"></i> Sales Rep</a>
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
                            Conferm Order
                            <small>Location Tracker</small>
                        </h1>
                      <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="repwindow.php">Sales Rep</a>
                            </li>
                                                      
                        </ol>
                       <a href="zxing://scan/?ret=http://linkfivesoft.com/saleqr.php?shopid={CODE}&userId=1&SCAN_FORMATS=UPC_A,EAN_13,QR_CODE"><img src="img/conferm.png" height="50" width="200"></a>
                       <br/>
                       <br/>
                        
                     <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <table align="center" width="350" border="0"  height="180">
        <tr valign="baseline">
          <td nowrap align="right"><b>Latitude:</b></td>
          <td><input type="text" class="form-control" id=lat name="lat" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right"><b>Logtitude:</b></td>
          <td><input type="text" class="form-control" id=lng name="lon" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">&nbsp;</td>
          <td><input type="submit" class="btn btn-primary btn-lg btn-block active" value="Insert record"></td>
        </tr>
      </table>
      <input type="hidden" name="id" value="">
      <input type="hidden" name="MM_insert" value="form1">
    </form>



  <div data-role=content>
    
    <p>
      <?php /*?><a data-role=button id=btn>Display map</a><?php */?>
    
    <script>

navigator.geolocation.getCurrentPosition (function (pos)
{
  var lat = pos.coords.latitude;
  var lng = pos.coords.longitude;
  $("#lat").val (lat);
  $("#lng").val (lng);
});

$("#btn").bind ("click", function (event)
{
  var lat = $("#lat").val ();
  var lng = $("#lng").val ();
  var latlng = new google.maps.LatLng (lat, lng);
  var options = { 
    zoom : 15, 
    center : latlng, 
    mapTypeId : google.maps.MapTypeId.ROADMAP 
  };
  var $content = $("#win2 div:jqmData(role=content)");
  $content.height (screen.height - 20);
  var map = new google.maps.Map ($content[0], options);
  $.mobile.changePage ($("#win2"));
  
  new google.maps.Marker ( 
  { 
    map : map, 
    animation : google.maps.Animation.DROP,
    position : latlng  
  });  
});

    </script>
    </p>
  </div>
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
mysql_free_result($Recordset1);
?>
