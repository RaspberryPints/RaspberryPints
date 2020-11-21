<?php header("Content-type: image/svg+xml"); ?>
<?xml version="1.0" encoding="UTF-8" standalone="no"?>

<?php

/* this just feels wrong */
$rgb = explode(',',$_GET['rgb']);
$r = $rgb[0];
$g = $rgb[1];
$b = $rgb[2];
if ($r<60) { $foamRgb = "159,129,112"; }
elseif ($r<190) { $foamRgb = "255,250,205"; }
else { $foamRgb = "255,255,255"; }

$fn = preg_replace('/\W+/','',$_GET['container']);
$view="20 50 130 256";
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
    <stop offset="<?php echo isset($_GET['fill'])?strval(100-intval($_GET['fill'])):"0"; ?>%" stop-color="rgb(<?php echo $_GET['rgb'] ?>)" />
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
  #liquid_lighten { fill: rgb(255,255,255);
            opacity: <?php echo isset($_GET['empty'])?"0.0":"0.35" ?>;
            
  }
  #glass_right { fill: url(#transToBlack) rgb(0,0,0);
          opacity: <?php echo isset($_GET['empty']) ? "0.0" : ".30";  ?>;
  }
  #glass_left { fill: url(#blackToTrans) rgb(0,0,0);
          opacity: <?php echo isset($_GET['empty']) ? "0.0" : ".30";  ?>;
  }
  #glass_bottom { fill: rgb(0,0,0);
          opacity: <?php echo isset($_GET['empty']) ? "0.0" : ".25";  ?>;
  }
  #glass_glare { fill: rgb(255,255,255);
          opacity: <?php echo isset($_GET['empty']) ? "0.0" : ".40";  ?>;
  }
]]></style>
<?php if( !empty($fn) && file_exists("svg_paths/$fn.paths"))readfile("svg_paths/$fn.paths"); ?>
</svg>
