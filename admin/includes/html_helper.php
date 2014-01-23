<?php
class HtmlHelper{

	function ToSelectList($selectName, $items, $name, $value, $selectedValue, $defaultName = null){
		
		$str = "<select id='$selectName' name='$selectName'>";
		
			if( $defaultName ){
				$str .= "<option>" . $defaultName . "</option>";
			}
		
			foreach($items as $item){
				$str .= "<option value='".$item[$value]."' ";
				
				if( $selectedValue == $item[$value] ){
					$str .= "selected ";
				}
				
				$str .= ">";
				$str .= $item[$name];
				$str .= "</option>";
			}
		
		$str .= "</select>";
		
		return $str;
	}
}