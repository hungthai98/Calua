<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit251289fac33e7f76f7bddc11271dd50f
{
    public static $files = array (
        '7b11c4dc42b3b3023073cb14e519683c' => __DIR__ . '/..' . '/ralouphie/getallheaders/src/getallheaders.php',
        'a0edc8309cc5e1d60e3047b5df6b7052' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/functions_include.php',
        'c964ee0ededf28c96ebd9db5099ef910' => __DIR__ . '/..' . '/guzzlehttp/promises/src/functions_include.php',
        '37a3dc5111fe8f707ab4c132ef1dbc62' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/functions_include.php',
    );

    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
            'Psr\\Http\\Client\\' => 16,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
            'GuzzleHttp\\Promise\\' => 19,
            'GuzzleHttp\\' => 11,
        ),
        'F' => 
        array (
            'FacebookPixelPlugin\\Integration\\' => 32,
            'FacebookPixelPlugin\\Core\\' => 25,
            'FacebookPixelPlugin\\' => 20,
            'FacebookAds\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Psr\\Http\\Client\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-client/src',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'GuzzleHttp\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/promises/src',
        ),
        'GuzzleHttp\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/guzzle/src',
        ),
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
        'WP_Async_Task' => __DIR__ . '/..' . '/techcrunch/wp-async-task/wp-async-task.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit251289fac33e7f76f7bddc11271dd50f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit251289fac33e7f76f7bddc11271dd50f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit251289fac33e7f76f7bddc11271dd50f::$classMap;

        }, null, ClassLoader::class);
    }
}
