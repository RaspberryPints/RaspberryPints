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
            <li class="current">Feedback</li>
        </ul>
    </div>
    <!-- Top Breadcrumb End --> 
     
    <!-- Right Side/Main Content Start -->
    <div id="rightside">
<div class="contentcontainer med left">
            <div class="headings alt">
                <h2>Let Us Know</h2>
            </div>
            <div class="contentbox">
            	<form action="formmailer.php" method="post">
                <input type="hidden" name="subject" value="Submission" />
				<p><b>Do you have an idea or a suggestion? Then let us know, we love making Raspberry Pints better. </b></p>
            		<p>
                        <label for="textfield"><strong>Name:</strong></label>
                        <input type="text" id="textfield" name="name" class="inputbox" /> <br />
                    </p>
                    <p> 
                        <label for="textfield"><strong>Email:</strong></label>
                        <input type="text" id="textfield" name="email" class="inputbox" /> <br />
                    </p>            
 <p>
                        <label for="textfield"><strong>Details:</strong></label></p>				
				<textarea class="text-input textarea" id="wysiwyg" name="details" rows="10" cols="75"></textarea>

		      <br />
                <input type="submit" value="Submit" class="btn" />
				</form>  
            </div>
        </div>
    <!-- Start Footer -->   
<? 
include 'footer.php';
?>

	<!-- End Footer --> 
          
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
