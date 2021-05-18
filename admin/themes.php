<?php
// Set and check for session
session_start();
if(!isset( $_SESSION['myusername'] )){
header("location:index.php");
}

//Needed files for function
require_once 'includes/html_helper.php';
require_once 'includes/functions.php';
require_once __DIR__.'/includes/managers/config_manager.php';

?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>RaspberryPints</title>
<link href="styles/layout.css" rel="stylesheet" type="text/css" />
<link href="styles/wysiwyg.css" rel="stylesheet" type="text/css" />

<!-- Style Sheet -->
<link href="<?php echo /** @var mixed $stylesheet **/$stylesheet?>" rel="stylesheet" type="text/css" />

<link href='http://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'/>
</head>
<body>
<!-- Start Header -->
<?php
include 'top_menu.php';
?>
<!-- End Header -->
	
<!-- Top Breadcrumb Start -->
<div id="breadcrumb">
	<ul>	
		<li><img src="img/icons/icon_breadcrumb.png" alt="Location" /></li>
		<li><strong>Location:</strong></li>
		<li class="current">Theme Options</li>
	</ul>
</div>

<!-- Top Breadcrumb End -->

<!-- Right Side/Main Content Start -->
<div id="rightside">
	<div class="contentcontainer lg left">
		<div class="headings alt">
			<h2>Theme Options</h2>
		</div>
<?php
if (isset($_POST['color'])) {
	require_once 'includes/functions.php';

	// Get values from form 
	$color=encode($_POST['color']);
	$result = saveConfigValue(ConfigNames::AdminThemeColor, $color);

	//Redirect back to same page to force MySQL Update
	if ($result)
	{
?>
<script>window.location=("themes.php");</script>
<?php
	}
}
?>
		<div class="contentbox">
		<a name="columns"></a>

<!-- Form to set admin theme color-->
<form method="post" name="color" action="">
	<h2>Select Admin Theme Color:</h2>
	<select name="color">
	<?php /** @var mixed $stylesheet **/?>
		<option value="styles.css"<?php if ($stylesheet == "styles.css") echo "selected";?>>Blue</option>
		<option value="styles_green.css"<?php if ($stylesheet == "styles_green.css") echo "selected";?>>Green</option>
		<option value="styles_red.css"<?php if ($stylesheet == "styles_red.css") echo "selected";?>>Red</option>
	</select>
	<input type="submit" class="btn" value="Save" />
</form>
<br />

<!--Form to set taplist font family COMMENTED OUT
<form method="post" name="Font" action="">
	<h2>Select TapList Font:</h2>
	<select name="Font">
<option value="Georgia">Georgia</option>
  <option value="Arial">Arial</option>
  <option value="Impact">Impact</option>
  <option value="Lucida Console">Lucida Console</option>
  <option value="Tahoma">Tahoma</option>
  <option value="Verdana">Verdana</option>
  <option value="Comic Sans MS">Comic Sans MS</option>
  <option value="Times New Roman">Times New Roman</option>
  <option value="Courier">Courier</option>
</select>
<input type="submit" class="btn" value="Save" />
</form>
-->
	</div>
</div>

<!-- Start Footer -->

<?php 
include 'footer.php';
?>
<!-- End Footer -->
</div>
	<!-- Right Side/Main Content End -->
	<!-- Start Left Bar Menu -->   
<?php 
include 'left_bar.php';
?>
	<!-- End Left Bar Menu -->  
	<!-- Start Js  -->
<?php
include 'scripts.php';
?>
</body>
</html>
