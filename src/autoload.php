<?php
 
// framework/autoload.php
 
//require_once __DIR__.'/vendor/symfony/class-loader/Symfony/Component/ClassLoader/UniversalClassLoader.php';
require_once __DIR__.'/../vendor/autoload.php';
 
use Symfony\Component\ClassLoader\UniversalClassLoader;
 
$loader = new UniversalClassLoader();
$loader->register();