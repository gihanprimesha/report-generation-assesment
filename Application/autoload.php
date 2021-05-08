<?php

function autoloader($className){
    $classNameParts = explode('\\', $className);
    $className = end($classNameParts);
    include 'Reports/' . $className . '.php';
}

spl_autoload_register('autoloader');