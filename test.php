<?php 
$directoryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directoryURI, PHP_URL_PATH);
$components = explode('/', $path);
$first_part = $components[1];

echo $first_part;
if ($first_part==""){
        echo "active";  
    }
     else  
     {
        echo "noactive";
    }
if ($first_part=="tutorials"){
        echo "active";  
    }
     else  
     {
        echo "noactive";
    }
?>