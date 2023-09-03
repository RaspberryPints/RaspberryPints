<?php
if( !isset($_GET['type']) || !isset($_GET['id']))exit;
if( $_GET['type'] != "tap" && $_GET['type'] != "beer" && $_GET['type'] != "accolade")exit;
$imgs = glob (  __DIR__.'/../img/'.$_GET['type'].'/'.$_GET['type'].$_GET['id'].'.*' );
foreach( $imgs as $img ){
    unlink($img);
}
if(isset($_POST['redirect']) && $_POST['redirect'] != ''){
    require_once __DIR__.'/includes/functions.php';
    redirect($_POST['redirect']);
}
?>
<script>window.close();</script>