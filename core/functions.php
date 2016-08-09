<?php 

function printArray($array){
    
    if(is_object($array))
        $array = (array) $obj;
        
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}
    
function isAjaxRequest(){
    
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'){
        
        return TRUE;
    }
    return FALSE;
}
