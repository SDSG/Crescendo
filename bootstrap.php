<?php
namespace Crescendo;

use \SDS\ClassSupport\Klass;

/**
 * Define all required constants under Crescendo namespace.
 */

const VERSION = "1.0-alpha"; // Crescendo version
const ROOT_PATH = __DIR__; // Crescendo root path

/**
 * Only define APPLICATION_ROOT_PATH if it's not already defined ( to support custom composer structures ).
 */

if (!defined("\\Crescendo\\APPLICATION_ROOT_PATH")) {
    define("Crescendo\\APPLICATION_ROOT_PATH", realpath(ROOT_PATH . "/../../.."));
}

/**
 * Only define COMPOSER_ROOT_PATH if it's not already defined ( to support custom composer structures ).
 */

if (!defined("\\Crescendo\\COMPOSER_ROOT_PATH")) {
    define("Crescendo\\COMPOSER_ROOT_PATH", APPLICATION_ROOT_PATH . "/vendor");
}

/**
 * Rely on Composer for all autoloading goodness.
 */

require COMPOSER_ROOT_PATH . "/autoload.php";

/**
 * Load application bootstrap file if it exists to allow tapping into booting process very early on.
 */

$applicationBootstrapPath = APPLICATION_ROOT_PATH . "/bootstrap.php";
if (file_exists($applicationBootstrapPath)) {
    require $applicationBootstrapPath;
}

/**
 * Initialize Application if not already initialized by application bootstrap file.
 */

if (!isset($application)) {
    $application = Application::init();
}

/**
 * Make Application available from global namespace if not already there.
 * If Application is already in global namespace then check if it's extending \Crescendo\Application.
 */

$applicationKlass = new Klass($application);

if (!$applicationKlass->aliasToIfFree("Application")) {
    $rootApplicationClass = new Klass("Application");
    
    if (!$rootApplicationClass->isA("Crescendo\\Application")) {
        throw new Exceptions\RootApplicationClassTakenException(
            "Class `Application` exists and isn't extending `\\Crescendo\\Application` class."
        );
    }
}

/**
 * Include various helper function to make code writing easier and shorter. If you don't
 * want these functions to be available from global namespace set $globalizeHelperFunctions
 * to false in application bootstrap file. Helper functions will still be available from individual
 * component namespaces.
 */

if (!isset($globalizeHelperFunctions)) {
    $globalizeHelperFunctions = true;
}

require ROOT_PATH . "/src/IoC/helpers.php"; // IoC Container helper functions

/**
 * Initialize environment.
 */

$application->initEnvironment();

/**
 * Initialize configuration system.
 */

$application->initConfig();

/**
 * Initialize applets.
 */

$application->initApplets();