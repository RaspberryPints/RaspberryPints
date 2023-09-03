<?php

class HtmlHelper{

	function ToSelectList($selectName, $selectId, $items, $nameProperty, $valueProperty, $selectedValue, $defaultName = null, $cssClasses = ""){
		return $this->ToColorSelectList($selectName, $selectId, $items, $nameProperty, $valueProperty, $selectedValue, $defaultName, $cssClasses);
	}
	
	function ToColorSelectList($selectName, $selectId, $items, $nameProperty, $valueProperty, $selectedValue, $defaultName = null, $cssClasses = "", $colorProperty = null){
				
		$selectStyle = "";
		$options = "";
		if( $defaultName ){
			$options .= "<option value=''>" . $defaultName . "</option>";
		}
	
		foreach($items as $item){
			$value = $item->{"get_$valueProperty"}();
			$name = $item->{"get_$nameProperty"}();
			$color = ( $colorProperty?$item->{"get_$colorProperty"}():null);
			$option = "";
			$option .= "<option value='$value' ";
			
			$style = ($color?'style="background-color:'.$this->CreateRGB($color).'"':'');
			$option .= $style;
			if( $selectedValue == $value ){
				$option .= " selected ";
				$selectStyle = $style;
			}
			
			
			$option .= ">";
			$option .= $name;
			$option .= "</option>";
			$options .= $option;
		}
		$str = "";
		$str .= "<select id='$selectId' name='$selectName' class='$cssClasses' ".$selectStyle.($colorProperty?' onchange="this.style.backgroundColor=this.children[this.selectedIndex].style.backgroundColor;" ':"").">";
		$str .= $options;
		$str .= "</select>";
		
		return $str;
	}
	
	function CreateRGB($color){
		if(!$color) return 'rgb(0,0,0);';
		return 'rgb'.(count(explode(",", $color)) > 3?'a':'').'('.$color.');';
	}
	
	function ColorHextoRGB($color){
	    if(!$color) return 'rgb(0,0,0);';
	    $ii = 0;
	    if(substr($color, 0, 1) == '#') $ii++;
	    $red = hexdec(substr($color, $ii, 2)); $ii += 2;
	    $blu = hexdec(substr($color, $ii, 2)); $ii += 2;
	    $grn = hexdec(substr($color, $ii, 2)); $ii += 2;
	    return $red.','.$blu.','.$grn;
	}
	
	function ToCombinedSelectList($selectName, $items, $name1Property, $name2Property, $valueProperty, $selectedValue, $defaultName = null, $cssClasses = "", $onchangeFunction = ""){
		
		$str = "<select id='$selectName' name='$selectName' class='$cssClasses' onchange=\"$onchangeFunction\">";
		
			if( $defaultName ){
				$str .= "<option value=''>" . $defaultName . "</option>";
			}
		
			foreach($items as $item){
				$value = $item->{"get_$valueProperty"}();
				$name1 = $item->{"get_$name1Property"}();
				$name2 = $item->{"get_$name2Property"}();
				
				$str .= "<option value='$value' ";
				
				if( $selectedValue == $value ){
					$str .= "selected ";
				}
				
				$str .= ">(";
				$str .= $name1;
				$str .= ") ";
				$str .= $name2;
				$str .= "</option>";
			}
		
		$str .= "</select>";
		
		return $str;
	}
	
	function ShowMessage(){
				
		if( isset($_SESSION['errorMessage']) ){
			echo $this->CreateMessage('error', $_SESSION['errorMessage']);
			unset($_SESSION['errorMessage']);
		}
		
		if( isset($_SESSION['infoMessage']) ){
			echo $this->CreateMessage('info', $_SESSION['infoMessage']);
			unset($_SESSION['infoMessage']);
		}
		
		if( isset($_SESSION['successMessage']) ){
			echo $this->CreateMessage('success', $_SESSION['successMessage']);
			unset($_SESSION['successMessage']);
		}
		
		if( isset($_SESSION['warningMessage']) ){
			echo $this->CreateMessage('warning', $_SESSION['warningMessage']);
			unset($_SESSION['warningMessage']);
		}
		
		
		if( isset($_SESSION['statusMessage']) ){
			echo $this->CreateMessage('status', $_SESSION['statusMessage']);
			unset($_SESSION['statusMessage']);
		}
	}
	
	function CreateMessage($class, $message){
		return "<div class='$class status'><span>$message</span></div>";
	}
	
}
