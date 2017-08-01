<?php
use core\Kernel;
use core\Routing;
$GLOBALS['kernel'] = new Kernel;
function view($view,$args=[]){
    print_r($kernel);
    return $kernel->templater->view($view,$args);
}
function route($route=false){
    return Routing::route($route);
}
?>
