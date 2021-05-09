<?php
include('autoload.php');

$actionFactory = new Application\ActionFactory();
try {
    $actionFactory->actionCreator();
} catch (\Exception $e) {
    echo $e->getMessage();
}
