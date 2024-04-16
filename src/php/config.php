<?php
spl_autoload_register(function ($classname) {
    $filename = '../'.ltrim(str_replace('\\', '/', $classname)
    ) .'.php';
    if (file_exists($filename)) require_once $filename;
    });
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../html');
$twig = new \Twig\Environment($loader);
?>