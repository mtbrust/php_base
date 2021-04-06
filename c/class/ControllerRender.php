<?php

class ControllerRender
{

  // Não precisa mais.
  public function renderView($paramsTemplate, $paramsView)
  {
    // Puxa um template só para recarregar a página automaticamente.
    // $loader = new \Twig\Loader\FilesystemLoader('v/');
    // $twig = new \Twig\Environment($loader);
    // $template = $twig->load('templates/default.html');

    // $parametros = array();
    // $parametros['nome'] = "Mateussssss";

    // $conteudo = $template->render($parametros);
    // echo $conteudo;
    // //echo $this->controllerPage->getParamsTemplate('template');
    // echo '<hr>';
  }

  public static function render($paramsSecurity, $paramsController, $paramsTemplate, $paramsTemplateObjs, $paramsView, $paramsPage)
  {
    




    // // Arquivos físicos.
    // $vurlf = new \Twig\Loader\ArrayLoader([
    //   'html' => '<div id="html"><div id="head"><title>Diretótio</title>{% block head %}{% endblock %}</div><div id="body">{% block body %}{% endblock %}</div></div>',
    //   'head' => '{% block head %}<div value="teste">Head Diretório.</div>{% endblock %}',
    //   'top' => '',
    //   'header' => '',
    //   'body_pre' => '',
    //   'body_pos' => '',
    //   'footer' => '',
    //   'bottom' => '',
    // ]);

    // Arquivos físicos.
    $vurlf = new \Twig\Loader\ArrayLoader(
      $paramsTemplate
    );

    // Arquivos virtuais
    $vurlv = new \Twig\Loader\ArrayLoader([
      'html' => '<div id="html"><div id="head"><title>Banco de dados</title>{% block head %}{% endblock %}</div><div id="body">{% block body %}{% endblock %}</div></div>',
      'head' => '{% block head %}<div value="teste">array head</div>{% endblock %}',
    ]);
    
    $base = '';
    foreach (array_keys($paramsTemplate) as $key => $value) {
      if (!$key == 0)
      $base .= '{% use "'. $value .'" %}';
    }
    // print_r(array_keys($paramsTemplate));
    // echo '<br>';
    // print_r(($paramsTemplate));
    // echo "<h1>$base</h1>";
    // exit;
    // Base html
    $html_base = new \Twig\Loader\ArrayLoader([
      'base' => '{% extends "html" %}' . $base
    ]);

    // Sequência de prioridade. Arquivos físicos depois Virtuais.
    $loader = new \Twig\Loader\ChainLoader([$vurlf, $vurlv, $html_base]);
    $twig   = new \Twig\Environment($loader);
    echo $twig->render('base', array_merge($paramsView, $paramsPage));
  }
}
