<?php 
require_once __DIR__.'/includes/managers/config_manager.php';
require_once __DIR__.'/../includes/Pintlabs/Service/Untappd.php';
require_once __DIR__ . '/includes/managers/user_manager.php';
if( isset($_GET['state']) && !empty($_GET['state']))
{
    session_id(base64_decode($_GET['state']));
    session_start();
}
try{
    if( isset($_SESSION['untappdUser']) && !empty($_SESSION['untappdUser']))
    {
        $config = getAllConfigs();
        // create the basic constructor with
        $ut = new Pintlabs_Service_Untappd($config);
        // send POST back to server to get access token
        $a = $ut->getAccessToken($_GET['code'], $_GET['state']);
        $userManager = new UserManager();
        $id = $_SESSION['untappdUser'];
        $user = $userManager->GetById($id);
        if($user)
        {
            $user->set_unTapAccessToken($a);
            $redirect = $userManager->Save($user);
        }
        $_SESSION['untappdUser'] = null;
        redirect('user_form.php?id='.$id);
    }    
}catch(Exception $e){
    $_SESSION['errorMessage'] = "Unable to retreive Access Token - ".$e->getMessage();
    redirect('user_list.php');
}
?>