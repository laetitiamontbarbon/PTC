<?php
spl_autoload_register(function ($classname) {
    $filename = '../'.ltrim(str_replace('\\', '/', $classname)
    ) .'.php';
    if (file_exists($filename)) require_once $filename;
    });
$loader = new \Twig\Loader\FilesystemLoader('../html');
$twig = new \Twig\Environment($loader);
$titre = 'Acupure';
$slogan = 'Piquez la curiosité de votre bien-être';
$menuItems = [
    ['href' => '../php/search.php', 'text' => 'Accueil'],
    ['href' => 'pathologies.php', 'text' => 'Pathologies'],
    ['href' => 'symptomes.html', 'text' => 'Symptômes']
];
echo $twig->render('index.twig', [
    'titre' => $titre,
    'slogan' => $slogan,
    'menuItems' => $menuItems
]);

?>