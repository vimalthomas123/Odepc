<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit66f1427c8d1db057bf2d1cfcd4776981
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'FacebookPixelPlugin\\Integration\\' => 32,
            'FacebookPixelPlugin\\Core\\' => 25,
            'FacebookPixelPlugin\\' => 20,
            'FacebookAds\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'FacebookPixelPlugin\\Integration\\' => 
        array (
            0 => __DIR__ . '/../..' . '/integration',
        ),
        'FacebookPixelPlugin\\Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core',
        ),
        'FacebookPixelPlugin\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
        'FacebookAds\\' => 
        array (
            0 => __DIR__ . '/..' . '/facebook/php-business-sdk/src/FacebookAds',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'WP_Async_Task' => __DIR__ . '/..' . '/techcrunch/wp-async-task/wp-async-task.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit66f1427c8d1db057bf2d1cfcd4776981::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit66f1427c8d1db057bf2d1cfcd4776981::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit66f1427c8d1db057bf2d1cfcd4776981::$classMap;

        }, null, ClassLoader::class);
    }
}
