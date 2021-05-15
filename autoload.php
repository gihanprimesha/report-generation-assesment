<?php

function autoloader($className)
{
    $folderPath = '';
    $classNameParts = explode('\\', $className);

    foreach ($classNameParts as $key => $value) {
        if ($key === 0) {
            $folderPath = $value;
        } else {
            $folderPath = $folderPath . '/' . $value;
        }
    }

    include $folderPath . '.php';
}

spl_autoload_register('autoloader');
