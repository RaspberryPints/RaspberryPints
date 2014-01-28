<?
session_start();
if(!isset( $_SESSION['myusername'] )){
header("location:index.php");
}

require 'includes/conn.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>RaspberryPints</title>
<link href="styles/layout.css" rel="stylesheet" type="text/css" />
<link href="styles/wysiwyg.css" rel="stylesheet" type="text/css" />
<!-- Theme Start -->
<link href="styles.css" rel="stylesheet" type="text/css" />
<!-- Theme End -->
<link href='http://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
</head>
	<!-- Start Header  -->
<?
include 'header.php';
?>
	<!-- End Header -->
        
    <!-- Top Breadcrumb Start -->
    <div id="breadcrumb">
    	<ul>	
        	<li><img src="img/icons/icon_breadcrumb.png" alt="Location" /></li>
        	<li><strong>Location:</strong></li>
            <li><a href="#" title="">Sub Section</a></li>
            <li>/</li>
            <li class="current">Contributors</li>
        </ul>
    </div>
    <!-- Top Breadcrumb End --> 
     
    <!-- Right Side/Main Content Start -->
    <div id="rightside">

	
		<div class="contentcontainer med left">
            <div class="headings alt">
                <h2>Contributors</h2>
            </div>
            <div class="contentbox">
<table>
<thead>
<tr>
<td>
<b>Name</b>
</td>
<td>
<b>Role</b>
</td>
<td>
<b>Connect on HBT</b>
</td>
<td>
<b>Connect on Untappd</b>
</td>
</tr>
</thead>
<tbody>
<tr>
<td>
Thadius Miller
</td>
<td>
Project Manager
</td>
<td>
<a href="http://www.homebrewtalk.com/members/thadius856" target="_blank">thadius856</a>
</td>
<td>
</td>
</tr>
<tr>
<td>
Jason S. Unterman
</td>
<td>
Application Developer
</td>
<td>
<a href="http://www.homebrewtalk.com/members/jayunt" target="_blank">JayUnt</a>
</td>
<td>
<a href="https://untappd.com/user/jayunt" target="_blank">Jayunt</a>

</td>
</tr>
<tr>
<td>
Shawn M. Kemp
</td>
<td>
Application Developer
</td>
<td>
<a href="http://www.homebrewtalk.com/members/skemp45" target="_blank">Skemp45</a>
</td>
<td>
<a href="https://untappd.com/user/Shawnkemp" target="_blank">Shawn Kemp</a>
</td>
</tr>
</tbody>
</table>
     </div>
    <!-- Start Footer -->   
<? 
include 'footer.php';
?>

	<!-- End Footer -->
           </div>
    </div>
    <!-- Right Side/Main Content End -->
    
	<!-- Start Left Bar Menu -->   
<? 
include 'left_bar.php';
?>
	<!-- End Left Bar Menu -->  
	<!-- Start Js  -->
<?
include 'scripts.php';
?>
	<!-- End Js -->
    <!--[if IE 6]>
    <script type='text/javascript' src='scripts/png_fix.js'></script>
    <script type='text/javascript'>
      DD_belatedPNG.fix('img, .notifycount, .selected');
    </script>
    <![endif]--> 
</body>
</html>
