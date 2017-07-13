<?php require_once('Connections/link.php'); ?>



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

                <a class="navbar-brand" href="dash.html">Rep Location</a>

            </div>

            <!-- Top Menu Items -->

            <ul class="nav navbar-right top-nav">

                <li class="dropdown">

                    <!--<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>-->

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

                <!--    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>-->

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

                            <a href="#"><i class="fa fa-fw fa-power-off"></i> Log Out</a>

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

                            Track Location

                            <small>Google Map</small>

                        </h1>

                        <ol class="breadcrumb">

                            <li>

                                <i class="fa fa-dashboard"></i>  <a href="dash.html">Dashboard</a>

                            </li>

                                                     

                        </ol>

                        

                       

                        

                        

                  </div>

                </div>

                <!-- /.row -->

                

                 <body onLoad="initMap()" style="margin:0px; border:0px; padding:0px;">

 <div id="map"></div>

               
			   

<?php /*?><?
 $dbname            ='linkfive_link'; //Name of the database

$dbuser            ='linkfive_link'; //Username for the db

$dbpass            ='932621029'; //Password for the db

$dbserver        ='localhost'; //Name of the mysql server



$dbcnx = mysql_connect ("$dbserver", "$dbuser", "$dbpass");

mysql_select_db("$dbname") or die(mysql_error());

?><?php */?>



 <meta http-equiv="content-type" content="text/html; charset=utf-8"/>

 <title>Tracking REP Location</title>

 <style type="text/css">

 body { font: normal 10pt Helvetica, Arial; }

 #map { width: 1000px; height: 500px; border: 0px; padding: 0px; }

 </style>

 <script src="http://maps.google.com/maps/api/js?v=3&sensor=false" type="text/javascript"></script>

 <script type="text/javascript">

 //Sample code written by August Li

 var icon = new google.maps.MarkerImage("http://maps.google.com/mapfiles/ms/micons/pink-dot.png",

 new google.maps.Size(32, 32), new google.maps.Point(0, 0),

 new google.maps.Point(16, 32));

 var center = null;

 var map = null;

 var currentPopup;

 var bounds = new google.maps.LatLngBounds();

 function addMarker(lat, lng, info) {

 var pt = new google.maps.LatLng(lat, lng);

 bounds.extend(pt);

 var marker = new google.maps.Marker({

 position: pt,

 icon: icon,

 map: map

 });

 var popup = new google.maps.InfoWindow({

 content: info,

 maxWidth: 300

 });

 google.maps.event.addListener(marker, "click", function() {

 if (currentPopup != null) {

 currentPopup.close();

 currentPopup = null;

 }

 popup.open(map, marker);

 currentPopup = popup;

 });

 google.maps.event.addListener(popup, "closeclick", function() {

 map.panTo(center);

 currentPopup = null;

 });

 }

 function initMap() {

 map = new google.maps.Map(document.getElementById("map"), {

 center: new google.maps.LatLng(0, 0),

 zoom: 14,

 mapTypeId: google.maps.MapTypeId.ROADMAP,

 mapTypeControl: false,

 mapTypeControlOptions: {

 style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR

 },

 navigationControl: true,

 navigationControlOptions: {

 style: google.maps.NavigationControlStyle.SMALL

 }

 });

 <?
mysql_select_db($database_link, $link);
 $query = mysql_query("SELECT * FROM poi_example");

 while ($row = mysql_fetch_array($query)){

 $name=$row['name'];

 $lat=$row['lat'];

 $lon=$row['lon'];

 $desc=$row['desc'];

 echo ("addMarker($lat, $lon,'<b>$name</b><br/>$desc');\n");

 }

 ?>

 center = bounds.getCenter();

 map.fitBounds(bounds);



 }

 </script>

 



 

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

