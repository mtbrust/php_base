<?php

require 'vendor/autoload.php';

require_once 'c/app.php';

// Verifica se está na home
if ($_GET) {

  $url = explode('/', $_GET['url']);
  // Busca a página e retorna os attr (atributos)
  $url_final = opemFile(count($url), $url);
  //var_dump($url_final);

  if ($url_final['file'])
    require_once $url_final['file'];
  else{
    require_once 'v/pages/404.php';
  }
    
}
else
  require_once 'v/pages/default.php';



// Recursivo
// Realiza a verificação da url em busca de alguma página.
function opemFile($length, $url)
{
  // Grava url e atributos.
  $url_final['file'] = '';
  $url_final['url'] = '';
  $url_final['attr'] = array();

  // Finaliza na primeira posição da url.
  if ($length > 0) {
    $url_final = opemFile($length - 1, $url);
    $url_final['url'] .= $url[$length - 1];

    $proxima = true;

    // Verifica próximo parametro é uma página.
    if (count($url) != $length) {
      $dir2 = 'v/pages/' . $url_final['url'] . '/' . $url[$length];
      $file2 = $dir2 . '.php';
      $proxima = !file_exists($file2);
    }

    // Monta arquivo atual.
    $dir = 'v/pages/' . $url_final['url'];
    $file = $dir . '.php';

    // Verifica se página atual existe e se não existe outra no próximo parametro.
    if (file_exists($file) && $proxima) {
      $url_final['file'] = $file;     // Grava path da página.
      $url_final['url'] = '';         // Reinicia a gravação da url.
      $url_final['attr'] = array();
      return $url_final;
    }

    // Monta os parametros
    $url_final['attr'] = explode('/', $url_final['url']);
    $url_final['url'] .= '/';
    return  $url_final;
  }

  $url_final['url'] = '';
  return $url_final;
}
