<?php

class Model{
    
function toJson(){return json_encode(get_object_vars($this));}

}
?>