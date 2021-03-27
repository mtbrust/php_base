<?php


$loader = new \Twig\Loader\FilesystemLoader('v/');
$twig = new \Twig\Environment($loader);
$template = $twig->load('templates/default.html');


$parametros = array();
$parametros['nome'] = "Mateus";

$conteudo = $template->render($parametros);
echo $conteudo;