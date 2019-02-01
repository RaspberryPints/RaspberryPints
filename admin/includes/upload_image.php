<?php
require_once __DIR__.'/../header.php';
$uploadFile = $_FILES['uploaded']['name'];
if(null !== $uploadFile && $uploadFile != ''){
   $tmpUploadFile = $_FILES['uploaded']['tmp_name'];
}
$ok=1;


//This is our size condition 
if (filesize($uploadFile) > 1000000) 
{ 
    $_SESSION['errorMessage'] =  "Your file is too large.<br>"; 
    $ok=0; 
} 

$path_parts = pathinfo($uploadFile);
$uploaded_type = $path_parts['extension'];

//This is our limit file type condition 
if ($uploaded_type =="php") 
{ 
    $_SESSION['errorMessage'] =  "No PHP files<br>";
    $ok=0; 
} 

//Here we check that $ok was not set to 0 by an error 
if ($ok==0) 
{ 
    $_SESSION['errorMessage'] .= "Sorry your file was not uploaded"; 
} 
//If everything is ok we try to upload it 
else 
{ 
    $target = $_POST['target'];
    $path_parts = pathinfo($target);
    $target_type = $path_parts['extension'];
    if(null == $target_type || $target_type == '') $target .= '.'.$uploaded_type;    

    if(!move_uploaded_file($tmpUploadFile, $target)) 
    { 
        $ok=0;
        $_SESSION['errorMessage'] =  "Sorry, there was a problem uploading your file."; 
    } 
    else if(isset($_POST['deleteOthers'])){
        $imgs = glob ( $path_parts['dirname'].'/*' );
        foreach( $imgs as $img ){
            //dont delete what we just uploaded
            if( $img == $target ) continue;
            //if the string isnt like the target ignore
            if( strpos($img, $_POST['target']) === false ) continue;
            unlink($img);
        }
    }
} 
if(isset($_POST['redirect'])){
    if($_POST['redirect'] == '') echo '<script>window.close();</script>';
    redirect($_POST['redirect']);
}
$jumpto="";
if($ok == 1 && isset($_POST['jumpto']))$jumpto = (!strpos($_POST['jumpto'],"#")?"":"#").$_POST['jumpto'];
if($jumpto != ""){
    redirect('../personalize.php'.$jumpto);
}else{
    redirect($_SERVER['HTTP_REFERER']);
}
?> 
