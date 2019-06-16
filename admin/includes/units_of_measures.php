<?php
abstract class UnitsOfMeasure{
    const Imperial = 'Imperial';
    const Metric = 'Metric';
    const VolumeOunce = 'oz';
    const VolumeGallon = 'gal';
    const VolumeMilliLiter = 'ml';
    const VolumeLiter = 'l';
    const PressurePSI = 'psi';
    const PressurePascal = 'Pa';
    const DistanceFeet = 'ft';
    const DistanceMeter = 'm';
    const GravityBrix = 'bx';
    const GravityPlato = 'p';
    const GravitySG = 'sg';
    const TemperatureCelsius = 'C';
    const TemperatureFahrenheight = 'F';
    const WeightPounds = 'lb';
    const WeightGrams = 'g';
    const WeightKiloGrams = 'kg';
}

function convert_volume($value, $unitsFrom, $unitsTo, $useLargeUnits = FALSE){
    //Covert from the smaller units to the large units
    if( $useLargeUnits ){
        if($unitsFrom == UnitsOfMeasure::Imperial)         $unitsFrom = UnitsOfMeasure::VolumeGallon;
        if($unitsFrom == UnitsOfMeasure::Metric)           $unitsFrom = UnitsOfMeasure::VolumeLiter;
        if($unitsFrom == UnitsOfMeasure::VolumeOunce)      $unitsFrom = UnitsOfMeasure::VolumeGallon;
        if($unitsFrom == UnitsOfMeasure::VolumeMilliLiter) $unitsFrom = UnitsOfMeasure::VolumeLiter;
        if($unitsTo == UnitsOfMeasure::Imperial)           $unitsTo = UnitsOfMeasure::VolumeGallon;
        if($unitsTo == UnitsOfMeasure::Metric)             $unitsTo = UnitsOfMeasure::VolumeLiter;
        if($unitsTo == UnitsOfMeasure::VolumeOunce)        $unitsTo = UnitsOfMeasure::VolumeGallon;
        if($unitsTo == UnitsOfMeasure::VolumeMilliLiter)   $unitsTo = UnitsOfMeasure::VolumeLiter;
    } else {
        if($unitsFrom == UnitsOfMeasure::Imperial)         $unitsFrom = UnitsOfMeasure::VolumeOunce;
        if($unitsFrom == UnitsOfMeasure::Metric)           $unitsFrom = UnitsOfMeasure::VolumeMilliLiter;
        if($unitsTo == UnitsOfMeasure::Imperial)           $unitsTo = UnitsOfMeasure::VolumeOunce;
        if($unitsTo == UnitsOfMeasure::Metric)             $unitsTo = UnitsOfMeasure::VolumeMilliLiter;
    }
    if($unitsFrom == $unitsTo) return $value;
    if($unitsFrom == UnitsOfMeasure::VolumeOunce && $unitsTo == UnitsOfMeasure::VolumeMilliLiter){
        $value = $value * 29.5735;
    }
    else if($unitsFrom == UnitsOfMeasure::VolumeOunce && $unitsTo == UnitsOfMeasure::VolumeLiter){
        $value = $value * 0.0295735;
    }
    else if($unitsFrom == UnitsOfMeasure::VolumeOunce && $unitsTo == UnitsOfMeasure::VolumeGallon){
        $value = $value / 128;
    }
    else if($unitsFrom == UnitsOfMeasure::VolumeMilliLiter && $unitsTo == UnitsOfMeasure::VolumeOunce){
        $value = $value * 0.033814016000000065;
    }
    else if($unitsFrom == UnitsOfMeasure::VolumeMilliLiter && $unitsTo == UnitsOfMeasure::VolumeLiter){
        $value = $value / 1000;
    }
    else if($unitsFrom == UnitsOfMeasure::VolumeMilliLiter && $unitsTo == UnitsOfMeasure::VolumeGallon){
        $value = $value * 0.000264172;
    }
    else if($unitsFrom == UnitsOfMeasure::VolumeLiter && $unitsTo == UnitsOfMeasure::VolumeOunce){
        $value = $value * 33.81400000012258;
    }
    else if($unitsFrom == UnitsOfMeasure::VolumeLiter && $unitsTo == UnitsOfMeasure::VolumeMilliLiter){
        $value = $value * 1000;
    }
    else if($unitsFrom == UnitsOfMeasure::VolumeLiter && $unitsTo == UnitsOfMeasure::VolumeGallon){
        $value = $value * 0.2641720000000005;
    }
    else if($unitsFrom == UnitsOfMeasure::VolumeGallon && $unitsTo == UnitsOfMeasure::VolumeOunce){
        $value = $value * 128;
    }
    else if($unitsFrom == UnitsOfMeasure::VolumeGallon && $unitsTo == UnitsOfMeasure::VolumeMilliLiter){
        $value = $value * 3785.412;
    }
    else if($unitsFrom == UnitsOfMeasure::VolumeGallon && $unitsTo == UnitsOfMeasure::VolumeLiter){
        $value = $value * 3.785412;
    }
    return $value;
}
function convert_pressure($value, $unitsFrom, $unitsTo){
    
    if($unitsFrom == $unitsTo) return $value;
    
    //Incase the units are not exact
    if($unitsFrom == UnitsOfMeasure::Imperial)         $unitsFrom = UnitsOfMeasure::PressurePSI;
    if($unitsFrom == UnitsOfMeasure::Metric)           $unitsFrom = UnitsOfMeasure::PressurePascal;
    if($unitsTo == UnitsOfMeasure::Imperial)           $unitsTo = UnitsOfMeasure::PressurePSI;
    if($unitsTo == UnitsOfMeasure::Metric)             $unitsTo = UnitsOfMeasure::PressurePascal;
    
    if($unitsFrom == UnitsOfMeasure::PressurePSI && $unitsTo == UnitsOfMeasure::PressurePascal){
        $value = $value * 6894.757;
    }
    else if($unitsFrom == UnitsOfMeasure::PressurePascal && $unitsTo == UnitsOfMeasure::PressurePSI){
        $value = $value / 6894.757;
    }
    return $value;
}
function convert_distance($value, $unitsFrom, $unitsTo){
    
    if($unitsFrom == $unitsTo) return $value;
    
    //Incase the units are not exact
    if($unitsFrom == UnitsOfMeasure::Imperial)         $unitsFrom = UnitsOfMeasure::DistanceFeet;
    if($unitsFrom == UnitsOfMeasure::Metric)           $unitsFrom = UnitsOfMeasure::DistanceMeter;
    if($unitsTo == UnitsOfMeasure::Imperial)           $unitsTo = UnitsOfMeasure::DistanceFeet;
    if($unitsTo == UnitsOfMeasure::Metric)             $unitsTo = UnitsOfMeasure::DistanceMeter;
    
    if($unitsFrom == UnitsOfMeasure::DistanceFeet && $unitsTo == UnitsOfMeasure::DistanceMeter){
        $value = $value * 0.3048;
    }
    else if($unitsFrom == UnitsOfMeasure::DistanceMeter && $unitsTo == UnitsOfMeasure::DistanceFeet){
        $value = $value * 3.28084;
    }
    return $value;
}
function convert_gravity($value, $unitsFrom, $unitsTo){

    if($unitsFrom == $unitsTo) return $value;  
        
    if($unitsFrom == UnitsOfMeasure::GravityBrix && $unitsTo == UnitsOfMeasure::GravitySG){
        $value = round(($value / (258.6-(($value / 258.2)*227.1))) + 1, 3);
    }
    else if($unitsFrom == UnitsOfMeasure::GravityBrix && $unitsTo == UnitsOfMeasure::GravityPlato){
        $value = $value / 1.04; 
    }
    else if($unitsFrom == UnitsOfMeasure::GravityPlato && $unitsTo == UnitsOfMeasure::GravitySG){
        $value = sprintf('%0.3d', 1+($value*4));
    }
    else if($unitsFrom == UnitsOfMeasure::GravityPlato && $unitsTo == UnitsOfMeasure::GravityBrix){
        $value = $value * 1.04;
    }
    else if($unitsFrom == UnitsOfMeasure::GravitySG && $unitsTo == UnitsOfMeasure::GravityPlato){
        $value = ($value-1)/4;
    }
    else if($unitsFrom == UnitsOfMeasure::GravitySG && $unitsTo == UnitsOfMeasure::GravityBrix){
        $value = ($value-1)/.004;
    }
    
    return $value;
}
function convert_temperature($value, $unitsFrom, $unitsTo){
    
    if($unitsFrom == $unitsTo) return $value;
    
    //Incase the units are not exact
    if($unitsFrom == UnitsOfMeasure::Imperial)         $unitsFrom = UnitsOfMeasure::TemperatureFahrenheight;
    if($unitsFrom == UnitsOfMeasure::Metric)           $unitsFrom = UnitsOfMeasure::TemperatureCelsius;
    if($unitsTo == UnitsOfMeasure::Imperial)           $unitsTo = UnitsOfMeasure::TemperatureFahrenheight;
    if($unitsTo == UnitsOfMeasure::Metric)             $unitsTo = UnitsOfMeasure::TemperatureCelsius;
    
    if($unitsFrom == UnitsOfMeasure::TemperatureCelsius){
        $value = (($value * (9/5))+32);
    }
    else if($unitsFrom == UnitsOfMeasure::TemperatureFahrenheight){
        $value = (($value - 32) * (5/9));
    }
    return $value;
}
function convert_weight($value, $unitsFrom, $unitsTo){

    if($unitsFrom == $unitsTo) return $value;   
    
    //Incase the units are not exact
    if($unitsFrom == UnitsOfMeasure::Imperial)         $unitsFrom = UnitsOfMeasure::WeightPounds;
    if($unitsFrom == UnitsOfMeasure::Metric)           $unitsFrom = UnitsOfMeasure::WeightGrams;
    if($unitsTo == UnitsOfMeasure::Imperial)           $unitsTo = UnitsOfMeasure::WeightPounds;
    if($unitsTo == UnitsOfMeasure::Metric)             $unitsTo = UnitsOfMeasure::WeightGrams;
    
    if($unitsFrom == UnitsOfMeasure::WeightPounds && $unitsTo == UnitsOfMeasure::WeightGrams){
        $value = $value * 453.592;
    }
    else if($unitsFrom == UnitsOfMeasure::WeightGrams && $unitsTo == UnitsOfMeasure::WeightPounds){
        $value = $value * 0.00220462;
    } 
    else if($unitsFrom == UnitsOfMeasure::WeightPounds && $unitsTo == UnitsOfMeasure::WeightKiloGrams){
        $value = $value * .453592;
    }
    else if($unitsFrom == UnitsOfMeasure::WeightKiloGrams && $unitsTo == UnitsOfMeasure::WeightPounds){
        $value = $value * 2.20462;
    }
    return $value;
}
function convert_count($value, $unitsFrom, $unitsTo){
    //Count is always in Gal or in L but display config is either in oz or ml
    //echo $value.'-'.$unitsFrom.'-'.$unitsTo;
    if($unitsFrom == $unitsTo) return $value;
    
    //Incase the units are not exact
    if($unitsFrom == UnitsOfMeasure::Imperial)         $unitsFrom = UnitsOfMeasure::VolumeOunce;
    if($unitsFrom == UnitsOfMeasure::Metric)           $unitsFrom = UnitsOfMeasure::VolumeMilliLiter;
    if($unitsTo == UnitsOfMeasure::Imperial)           $unitsTo = UnitsOfMeasure::VolumeOunce;
    if($unitsTo == UnitsOfMeasure::Metric)             $unitsTo = UnitsOfMeasure::VolumeMilliLiter;
    
    if($unitsFrom == UnitsOfMeasure::VolumeOunce && $unitsTo == UnitsOfMeasure::VolumeMilliLiter){
        $value = $value / 3.785412;    
    }
    else if($unitsFrom == UnitsOfMeasure::VolumeMilliLiter && $unitsTo == UnitsOfMeasure::VolumeOunce){
        $value = $value * 3.785412;        
    }
    return $value;
}

function is_unit_imperial($unit){
    return (  $unit == UnitsOfMeasure::Imperial ||
              $unit == UnitsOfMeasure::VolumeOunce ||
              $unit == UnitsOfMeasure::VolumeGallon ||
        $unit == UnitsOfMeasure::PressurePSI ||
        $unit == UnitsOfMeasure::DistanceFeet ||
        $unit == UnitsOfMeasure::TemperatureFahrenheight ||
        $unit == UnitsOfMeasure::WeightPounds );
        
}
function is_unit_metric($unit){
    return (  $unit == UnitsOfMeasure::Metric ||
        $unit == UnitsOfMeasure::VolumeLiter ||
        $unit == UnitsOfMeasure::VolumeMilliLiter ||
        $unit == UnitsOfMeasure::PressurePascal ||
        $unit == UnitsOfMeasure::DistanceMeter ||
        $unit == UnitsOfMeasure::TemperatureCelsius ||
        $unit == UnitsOfMeasure::WeightGrams ||
        $unit == UnitsOfMeasure::WeightKiloGrams );
    
}
?>