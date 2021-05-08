<?php

function autoloader($className)
{
    $classNameParts = explode('\\', $className);

    $className = end($classNameParts);
    $folder = $classNameParts[0];
    include $folder . '/' . $className . '.php';
}

spl_autoload_register('autoloader');
