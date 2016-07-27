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
				$str .= $name;
				$str .= "</option>";
			}
		
		$str .= "</select>";
		
		return $str;
	}

	function ToCombinedSelectList($selectName, $items, $name1Property, $name2Property, $valueProperty, $selectedValue, $defaultName = null, $cssClasses = ""){
		
		$str = "<select id='$selectName' name='$selectName' class='$cssClasses'>";
		
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
		$str = "";
				
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
