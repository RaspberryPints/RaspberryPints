<?php
$imgs = glob (  __DIR__.'/../img/tap/tap'.$_GET['tapId'].'*' );
foreach( $imgs as $img ){
    unlink($img);
}
?>
<script>window.close();</script>