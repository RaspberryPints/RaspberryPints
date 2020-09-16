<?php header("Content-type: image/svg+xml"); ?>
<?xml version="1.0" encoding="UTF-8" standalone="no"?>

<?php

$fn = preg_replace('/\W+/','',$_GET['container']);
$view="10 00 200 300";
?>

<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0px" y="0px" viewBox="<?php echo $view; ?>" style="enable-background:new <?php echo $view; ?>;" xml:space="preserve">
  <linearGradient id="transToBlack" x2="1" y2="0">
    <stop offset="85%" stop-color="rgba(<?php echo "0,0,0,0" ?>)" />
    <stop offset="100%" stop-color="rgb(<?php echo "0,0,0" ?>)" />
  </linearGradient>
  <linearGradient id="blackToTrans" x2="1" y2="0">
    <stop offset="0%" stop-color="rgb(<?php echo "0,0,0" ?>)" />
    <stop offset="30%" stop-color="rgba(<?php echo "0,0,0,0" ?>)" />
  </linearGradient>
  <linearGradient id="rgbToTransVerticle" x2="0" y2="1">
    <stop offset="0%" stop-color="rgba(<?php echo "0,0,0,0" ?>)" />
    <stop offset="<?php echo isset($_GET['fill'])?strval(100-intval($_GET['fill'])):"0"; ?>%" stop-color="rgba(<?php echo "0,0,0,0" ?>)" />
    <stop offset="<?php echo isset($_GET['fill'])?strval(100-intval($_GET['fill'])):"0"; ?>%" stop-color="rgb(<?php echo isset($_GET['rgb'])?$_GET['rgb']:"0,0,0" ?>)" />
  </linearGradient>
<style type="text/css"><![CDATA[
  #outline {
           stroke: #ffffff;
           stroke-opacity: 0.8;
           stroke-width: 3;
  }
  #liquid { fill: url(#rgbToTransVerticle);
            <?php if(isset($_GET['empty'])) { echo "opacity: 0.0;"; }?>
            stroke: #ffffff;
            stroke-opacity: 1;
            stroke-width: 2;            
  }

  #keg_right { fill: url(#transToBlack) rgb(0,0,0);
          opacity: <?php echo isset($_GET['empty']) ? "0.0" : ".30";  ?>;
  }
  #keg_left { fill: url(#blackToTrans) rgb(0,0,0);
          opacity: <?php echo isset($_GET['empty']) ? "0.0" : ".30";  ?>;
  }
  #keg_bottom { fill: rgb(0,0,0);
          opacity: <?php echo isset($_GET['empty']) ? "0.0" : ".25";  ?>;
  }
  #keg_glare { fill: rgb(255,255,255);
          opacity: <?php echo isset($_GET['empty']) ? "0.0" : ".40";  ?>;
  }
]]></style>
<?php readfile("svg_paths/$fn.paths"); ?>
</svg>
