<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5502b5fb1dc2e44dfef59c78b163300b
{
    public static $prefixLengthsPsr4 = array (
        'd' => 
        array (
            'devcompru\\http\\' => 15,
        ),
        'D' => 
        array (
            'Devcompru\\' => 10,
        ),
        'C' => 
        array (
            'Core\\' => 5,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'devcompru\\http\\' => 
        array (
            0 => __DIR__ . '/..' . '/devcompru/http/src',
        ),
        'Devcompru\\' => 
        array (
            0 => __DIR__ . '/..' . '/devcompru/router/src',
        ),
        'Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Core',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static $classMap = array (
        'App\\Modules\\main\\controllers\\MainController' => __DIR__ . '/../..' . '/App/Modules/main/controllers/MainController.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5502b5fb1dc2e44dfef59c78b163300b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5502b5fb1dc2e44dfef59c78b163300b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit5502b5fb1dc2e44dfef59c78b163300b::$classMap;

        }, null, ClassLoader::class);
    }
}
