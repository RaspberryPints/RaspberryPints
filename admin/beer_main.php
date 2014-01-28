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
            <li class="current">Beer List</li>
        </ul>
    </div>
    <!-- Top Breadcrumb End --> 
     
    <!-- Right Side/Main Content Start -->
    <div id="rightside">

	
		<div class="contentcontainer med left">
            <div class="headings alt">
                <h2>Add A Beer</h2>
            </div>
            <div class="contentbox">
			<form action="includes/insert.php" method="post">
<label for="textfield"><strong>Beer Name:</strong></label> <input class="inputbox" type="text" name="name"> <br />
<label for="textfield"><strong>Style:</strong></label> <input class="inputbox" type="text" name="style"> <br />
<label for="textfield"><strong>Notes:</strong></label> <textarea class="inputbox" name="notes"></textarea> <br />
<label for="textfield"><strong>OG:</strong></label> <input class="inputbox" type="text" name="ogEst"> <br />
<label for="textfield"><strong>FG:</strong></label> <input class="inputbox" type="text" name="fgEst"> <br />
<label for="textfield"><strong>SRM:</strong></label> <input class="inputbox" type="text" name="srmEst"> <br />
<label for="textfield"><strong>IBU's:</strong></label> <input class="inputbox" type="text" name="ibuEst"> <br />
<input class="btn" type="submit" value="Add Beer">
</form>

     </div>
<br />  
 
	 <div class="headings alt">
                <h2>Remove A Beer</h2>
            </div>
			 <div class="contentbox">
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
