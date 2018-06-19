<?php
require_once __DIR__.'/header.php';
require_once __DIR__.'/includes/managers/user_manager.php';
$htmlHelper = new HtmlHelper();
$userManager = new UserManager();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$redirect = false;
	if(isset($_POST['deleteRFID']))
	{
		$redirect = $userManager->deleteRFID($_POST['userId'], $_POST['rfid']);
	}
	if(isset($_POST['addRFID']))
	{
		$redirect = $userManager->addRFID($_POST['userId'], $_POST['rfid'], $_POST['description']);
	}
	if($redirect)
	{
		$_SESSION['successMessage'] = "Successfully ".(isset($_POST['deleteRFID'])?"deleted":"added")." RFID [".$_POST['rfid']."]";
		redirect($_SERVER['HTTP_REFERER']);
	}
}
?>
<body>
<?php $htmlHelper->ShowMessage();
		redirect($_SERVER['HTTP_REFERER']); ?>
</body>
</html>
