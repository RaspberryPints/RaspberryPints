<?php
require_once 'includes/functions.php';

class HtmlHelper{

	function ToSelectList($selectName, $items, $nameProperty, $valueProperty, $selectedValue, $defaultName = null, $cssClasses = ""){
		
		$str = "<select id='$selectName' name='$selectName' class='$cssClasses'>";
		
			if( $defaultName ){
				$str .= "<option value=''>" . $defaultName . "</option>";
			}
		
			foreach($items as $item){
				$value = $item->{"get_$valueProperty"}();
				$name = $item->{"get_$nameProperty"}();
				
				$str .= "<option value='$value' ";
				
				if( $selectedValue == $value ){
					$str .= "selected ";
				}
				
				$str .= ">";
				$str .= encode($name);
				$str .= "</option>";
			}
		
		$str .= "</select>";
		
		return $str;
	}
	
	function ShowMessage(){
		$str = "";
				
		if( isset($_SESSION['errorMessage']) ){
			$str .= "<div class='error'><span>".$_SESSION['errorMessage']."</span></div>";
			unset($_SESSION['errorMessage']);
		}
		
		if( isset($_SESSION['infoMessage']) ){
			$str .= "<div class='info'><span>".$_SESSION['infoMessage']."</span></div>";
			unset($_SESSION['infoMessage']);
		}
		
		if( isset($_SESSION['successMessage']) ){
			$str .= "<div class='success'><span>".$_SESSION['successMessage']."</span></div>";
			unset($_SESSION['successMessage']);
		}
		
		if( isset($_SESSION['warningMessage']) ){
			$str .= "<div class='warning'><span>".$_SESSION['warningMessage']."</span></div>";
			unset($_SESSION['warningMessage']);
		}
		
		
		if( isset($_SESSION['statusMessage']) ){
			$str .= "<div class='status'><span>".$_SESSION['statusMessage']."</span></div>";
			unset($_SESSION['statusMessage']);
		}
		
		return $str;
	}
	
	
}