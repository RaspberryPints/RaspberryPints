<?php header("Content-type: image/svg+xml"); ?>

<?php

/* this just feels wrong */
$rgb = explode(',',$_GET['rgb']);
$r = $rgb[0];
//$g = $rgb[1];
//$b = $rgb[2];
if ($r<60) { $foamRgb = "159,129,112"; }
elseif ($r<190) { $foamRgb = "255,250,205"; }
else { $foamRgb = "255,255,255"; }

$fn = preg_replace('/\W+/','',$_GET['container']);
$view="30 0 156 512";
if($fn == "chalice")$view="0 -50 200 312";
if($fn == "snifter")$view="5 0 196 512";
if($fn == "stein")$view="0 0 200 512";
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
    <linearGradient id="stemware" x2="1" y2="1">
    <stop offset="0%" stop-color="rgb(<?php echo "0,0,0" ?>)" />
    <stop offset="25%" stop-color="rgba(<?php echo "255,255,255,1" ?>)" />
    <stop offset="85%" stop-color="rgba(<?php echo "255,255,255,1" ?>)" />
    <stop offset="100%" stop-color="rgb(<?php echo "0,0,0" ?>)" />
  </linearGradient>
  <linearGradient id="reversestemware" x2="1" y2="1">
    <stop offset="0%" stop-color="rgba(<?php echo "255,255,255,1" ?>)" />
    <stop offset="30%" stop-color="rgba(<?php echo "255,255,255,1" ?>)" />
    <stop offset="50%" stop-color="rgb(<?php echo "0,0,0" ?>)" />
    <stop offset="70%" stop-color="rgba(<?php echo "255,255,255,1" ?>)" />
  </linearGradient>
<style type="text/css"><![CDATA[
  #container { fill: #ffffff;
           opacity: 0.3;
  }
  #outline { fill: url(#reversestemware);
           stroke: #ffffff;
           stroke-opacity: 0.8;
           stroke-width: 3;
  }
  #liquid { fill: rgb(<?php echo isset($_GET['empty'])?"":$_GET['rgb'] ?>);
            <?php if(isset($_GET['empty'])) { echo "opacity: 0.0;"; }?>
            stroke: #ffffff;
            stroke-opacity: 1;
            stroke-width: 2;
            
  }
  #liquid_lighten { fill: rgb(255,255,255);
            opacity: <?php echo isset($_GET['empty'])?"0.0":"0.15" ?>;
            
  }
  #foam { fill: rgb(<?php echo $foamRgb; ?>);
          opacity: <?php echo isset($_GET['empty']) ? "0.75" : "1";  ?>;
  }
  #glass_right { fill: url(#transToBlack) rgb(0,0,0);
          opacity: .30;
  }
  #glass_left { fill: url(#blackToTrans) rgb(0,0,0);
          opacity: .30;
  }
  #glass_bottom { fill: rgb(0,0,0);
          opacity: .25;
  }
  #glass_glare { fill: rgb(255,255,255);
          opacity: .40;
  }
]]></style>
<?php if(!empty($fn) && file_exists("svg_paths/$fn.paths")) readfile("svg_paths/$fn.paths"); ?>
</svg>
