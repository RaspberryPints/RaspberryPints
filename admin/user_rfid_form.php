<?php
require_once __DIR__.'/header.php';
require_once __DIR__.'/includes/managers/user_manager.php';
$htmlHelper = new HtmlHelper();
$userManager = new UserManager();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$redirect = false;
	$operation = "Unknown";
	if(isset($_POST['deleteRFID']))
	{
		$redirect = $userManager->deleteRFID($_POST['userId'], $_POST['rfid']);
		$operation = "deleted";
	}
	if(isset($_POST['saveRFID']))
	{
		$redirect = $userManager->saveRFID($_POST['userId'], $_POST['rfid'], $_POST['description']);
		$operation = "saved";
	}
	if(isset($_POST['addRFID']))
	{
		$redirect = $userManager->addRFID($_POST['userId'], $_POST['rfid'], $_POST['description']);
		$operation = "added";
	}
	if(isset($_POST['assignRFID']))
	{
		$redirect = $userManager->saveRFID($_POST['userId'], $_POST['rfid'], $_POST['description']);
		$operation = "assigned";
	}
	if($redirect)
	{
		$_SESSION['successMessage'] = "Successfully ".$operation." RFID [".$_POST['rfid']."]";
		redirect($_SERVER['HTTP_REFERER']);
	}
}
?>
<body>
<?php $htmlHelper->ShowMessage();
		redirect($_SERVER['HTTP_REFERER']); ?>
</body>
</html>
