<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit956bba023d3d151b63f7319fce239f6f
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit956bba023d3d151b63f7319fce239f6f', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit956bba023d3d151b63f7319fce239f6f', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit956bba023d3d151b63f7319fce239f6f::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
