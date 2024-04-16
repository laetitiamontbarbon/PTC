<?php
spl_autoload_register(function ($classname) {
    $baseDir = __DIR__ . '/php/';
    $filename = $baseDir . str_replace('\\', '/', $classname) . '.php';
    if (file_exists($filename)) {
        require_once $filename;
    }
});


$baseDirTwig = __DIR__ . '/html/';
$loader = new \Twig\Loader\FilesystemLoader($baseDirTwig);

$twig = new \Twig\Environment($loader);
$titre = 'Connected Locker';
$menuItems = [
    ['href' => '../php/search.php', 'text' => 'Créer compte'],
    ['href' => 'gereracces.php', 'text' => 'Gerer acces'],
    ['href' => 'symptomes.html', 'text' => 'Voir acces']
];
echo $twig->render('html/creationcompte.twig', [
    'titre' => $titre,
    'menuItems' => $menuItems
]);


?>