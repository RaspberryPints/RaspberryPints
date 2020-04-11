<?php
if( !isset($_GET['type']) || !isset($_GET['id']))exit;
if( $_GET['type'] != "tap" && $_GET['type'] != "beer")exit;
$imgs = glob (  __DIR__.'/../img/'.$_GET['type'].'/'.$_GET['type'].$_GET['id'].'.*' );
foreach( $imgs as $img ){
    unlink($img);
}
?>
<script>window.close();</script>