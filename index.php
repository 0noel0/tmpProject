<?php

require 'util/prototype.php';

$location = null;
if(session("check")){
    $location = './app/home';
}else{
    $location = './app/login';
}

header('Location: '.$location);

?>        