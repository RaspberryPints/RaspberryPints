<?php
class HtmlHelper{

	function ToSelectList($selectName, $items, $nameProperty, $valueProperty, $selectedValue, $defaultName = null){
		
		$str = "<select id='$selectName' name='$selectName'>";
		
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
}