<?php

namespace Imj\test;

error_reporting(E_ALL | E_STRICT);

// register autoloader
spl_autoload_register(function($class)
{
    $map = [
        'Imj\Registry' => __DIR__ . "/../src/Registry.php",
        'Imj\ServiceProviderInterface' => __DIR__ . "/../src/ServiceProviderInterface.php",
        'Imj\test\LibraryProvider' => __DIR__ . "/LibraryProvider.php",
    ];
    if(isset($map[$class])) {
        require_once $map[$class];
        return true;
    }
    return false;
});
