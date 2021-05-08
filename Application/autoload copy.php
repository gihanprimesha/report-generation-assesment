<?php

function autoloaderReports($className)
{
    $classNameParts = explode('\\', $className);
    $className = end($classNameParts);
    include 'Reports/' . $className . '.php';
}

spl_autoload_register('autoloaderReports');
