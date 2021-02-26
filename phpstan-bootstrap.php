<?php
declare(strict_types=1);

use PHPStanMagento1\Autoload\Magento\ModuleControllerAutoloader;

(new ModuleControllerAutoloader('local'))->register();
(new ModuleControllerAutoloader('core'))->register();
(new ModuleControllerAutoloader('community'))->register();

/**
 * We replace the original Varien_Autoload autoloader with a custom one.
 */
spl_autoload_register(static function($className) {
    spl_autoload_unregister([Varien_Autoload::instance(), 'autoload']);

    $classFile = str_replace(' ', DIRECTORY_SEPARATOR, ucwords(str_replace('_', ' ', $className)));
    $classFile .= '.php';

    foreach (explode(':', get_include_path()) as $path) {
        if (\file_exists($path . DIRECTORY_SEPARATOR . $classFile)) {
            return include $classFile;
        }
    }
}, true, true);

Mage::app();