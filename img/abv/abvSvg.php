<?php header("Content-type: image/svg+xml"); ?>

<?php
$foamRgb="";
$rgbBackground="";
/* this just feels wrong */
if(isset($_GET['rgb']))
{
    $rgbBackground = $_GET['rgb'];
    $rgb = explode(',',$_GET['rgb']);
    $r = $rgb[0];
    //$g = $rgb[1];
    //$b = $rgb[2];
    if ($r<60) { $foamRgb = "159,129,112"; }
    elseif ($r<190) { $foamRgb = "255,250,205"; }
    else { $foamRgb = "255,255,255"; }
}
$numCups= isset($_GET['fill'])?intval($_GET['fill'])/100:1;

$fn = preg_replace('/\W+/','',$_GET['container']);
//Really shouldnt do this to center a single glass but this was quick
$view=($numCups<=1?"-85":"0")." 0 400 300"; 
if($fn == "chalice")$view=($numCups<1?"-85":"10")." 0 400 300";
if($fn == "snifter")$view=($numCups<1?"-85":"0")." 0 420 300";
if($fn == "stein")$view=($numCups<1?"-85":"0")." 0 420 300";
if($fn == "bottle")$view=($numCups<1?"-100":"-50")." 0 400 300";

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
    <stop offset="<?php echo $numCups>=1?0:100-(($numCups-floor($numCups))*100); ?>%" stop-color="rgba(<?php echo "0,0,0,0" ?>)" />
    <stop offset="<?php echo $numCups>=1?0:100-(($numCups-floor($numCups))*100); ?>%" stop-color="rgb(<?php echo $rgbBackground ?>)" />
  </linearGradient>
  <linearGradient id="rgbToTransVerticle2" x2="0" y2="1">
    <stop offset="0%" stop-color="rgba(<?php echo "0,0,0,0" ?>)" />
    <stop offset="<?php echo $numCups>=2?0:100-(($numCups-floor($numCups))*100); ?>%" stop-color="rgba(<?php echo "0,0,0,0" ?>)" />
    <stop offset="<?php echo $numCups>=2?0:100-(($numCups-floor($numCups))*100); ?>%" stop-color="rgb(<?php echo $rgbBackground ?>)" />
  </linearGradient>
  <linearGradient id="rgbToTransHorizontal3" x2="1" y2="0">
    <stop offset="0%" stop-color="rgba(<?php echo "0,0,0,0" ?>)" />
    <stop offset="80%" stop-color="rgba(<?php echo "0,0,0,0" ?>)" />
    <stop offset="80%" stop-color="rgb(<?php echo $rgbBackground ?>)" />
  </linearGradient>
<style type="text/css"><![CDATA[
<?php if($numCups >= 0){ ?>
  #outline {
           stroke: #ffffff;
           stroke-opacity: 0.8;
           stroke-width: 3;
           fill-opacity: 0; /* dont have fill so that it looks empty where there is no liquid*/
  }
  #liquid { fill: url(#rgbToTransVerticle);
            <?php if(isset($_GET['empty'])) { echo "opacity: 0.0;"; }?>
            stroke: #ffffff;
            stroke-opacity: 1;
            stroke-width: 2;            
  }
  #liquid_lighten { fill: rgb(255,255,255);
            opacity: <?php echo isset($_GET['empty'])?"0.0":"0.15" ?>;
            
  }
  #foam { fill: rgb(<?php echo $foamRgb; ?>);
          opacity: <?php echo $numCups>=1?".75":"0"; ?>;
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
          opacity: <?php echo isset($_GET['empty']) ? "0.0" :  $numCups>1?".40":".40";  ?>;
  }
<?php }
if($numCups > 1){ ?>
  #outline-2 {
           stroke: #ffffff;
           stroke-opacity: 0.8;
           stroke-width: 3;
           fill-opacity: 0;
  }
  #liquid-2 { fill: url(#rgbToTransVerticle2);
            <?php if(isset($_GET['empty'])) { echo "opacity: 0.0;"; }?>
            stroke: #ffffff;
            stroke-opacity: 1;
            stroke-width: 2;            
  }
  #liquid_lighten-2 { fill: rgb(255,255,255);
            opacity: <?php echo isset($_GET['empty'])?"0.0":"0.15" ?>;
            
  }
  #foam-2 { fill: rgb(<?php echo $foamRgb; ?>);
          opacity: <?php echo $numCups>=2?".75":"0"; ?>;
  }
  #glass_right-2 { fill: url(#transToBlack) rgba(0,0,0,0);
          opacity: <?php echo isset($_GET['empty']) ? "0.0" : ".30";  ?>;
  }
  #glass_left-2 { fill: url(#blackToTrans) rgba(0,0,0,0);
          opacity: <?php echo isset($_GET['empty']) ? "0.0" : ".30";  ?>;
  }
  #glass_bottom-2 { fill: rgb(0,0,0);
          opacity: <?php echo isset($_GET['empty']) ? "0.0" : ".25";  ?>;
  }
  #glass_glare-2 { fill: rgb(255,255,255);
          opacity: <?php echo isset($_GET['empty']) ? "0.0" : ".40";  ?>;
  }
  <?php }else{ ?>
  #outline-2 { opacity: 0; }
  #liquid-2 { opacity: 0; }
  #liquid_lighten-2 { opacity: 0; }
  #foam-2 { opacity: 0; }
  #glass_right-2 { opacity: 0; }
  #glass_left-2  { opacity: 0; }
  #glass_bottom-2{ opacity: 0; }
  #glass_glare-2 { opacity: 0; }    
<?php }
if($numCups > 2){ ?>
  #outline-3 {
           stroke: #ffffff;
           stroke-opacity: 0.8;
           stroke-width: 3;
           fill-opacity: 0;
  }
  #liquid-3 { fill: url(#rgbToTransHorizontal3);
            <?php if(isset($_GET['empty'])) { echo "opacity: 0.0;"; }?>
            stroke: #ffffff;
            stroke-opacity: 1;
            stroke-width: 2;            
  }
  #liquid_lighten-3 { fill: rgb(255,255,255);
            opacity: <?php echo isset($_GET['empty'])?"0.0":"0.15" ?>;
            
  }
  #foam-3 { opacity: 0; }
  #glass_right-3 { fill: url(#transToBlack) rgb(0,0,0);
          opacity: <?php echo isset($_GET['empty']) ? "0.0" : ".30";  ?>;
  }
  #glass_left-3 { fill: url(#blackToTrans) rgb(0,0,0);
          opacity: <?php echo isset($_GET['empty']) ? "0.0" : ".30";  ?>;
  }
  #glass_bottom-3 { fill: rgb(0,0,0);
          opacity: <?php echo isset($_GET['empty']) ? "0.0" : ".25";  ?>;
  }
  #glass_glare-3 { fill: rgb(255,255,255);
          opacity: <?php echo isset($_GET['empty']) ? "0.0" : ".40";  ?>;
  }
<?php }else{ ?>
  #outline-3     { opacity: 0; }
  #liquid-3      { opacity: 0; }
  #liquid_lighten-3 { opacity: 0; }
  #foam-3 { opacity: 0; }
  #glass_right-3 { opacity: 0; }
  #glass_left-3  { opacity: 0; }
  #glass_bottom-3{ opacity: 0; }
  #glass_glare-3 { opacity: 0; }   
<?php 
}
?>
}
]]></style>
<?php if( !empty($fn) && file_exists("svg_paths/$fn.paths"))readfile("svg_paths/$fn.paths"); ?>
</svg>
