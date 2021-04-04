<?php

class ControllerRender
{


  public function renderView($paramsTemplate, $paramsView)
  {
    $view = '';
    return $view;
  }

  public function renderTemplate($template, $dados)
  {

    return $template;
  }

  private function render($view, $params)
  {
    // Prepara o twig
    $loader = new \Twig\Loader\FilesystemLoader('v/');
    $twig = new \Twig\Environment($loader);
    $template = $twig->load('templates/' . $this->controllerView->getParamsTemplate('template') . '.html');

    $params = array();
    $params['nome'] = "Mateus";

    $conteudo = $template->render($params);
    echo $conteudo;
    echo $this->controllerView->getParamsTemplate('template');





    // IMPLEMENTAR ESSE
    // Arquivos físicos.

    // Templates Objs
    $templateObjs = new \Twig\Loader\ArrayLoader([
      'base.html' => 'Virtual {% block content %}{% endblock %}',
    ]);

    // Templates do diretório.
    $templateDir = new \Twig\Loader\ArrayLoader([
      'base.html' => 'Físico  {% block content %}{% endblock %}',
    ]);

    // Templates do banco de dados
    $templateBd = new \Twig\Loader\ArrayLoader([
      'base.html' => 'Virtual {% block content %}{% endblock %}',
    ]);

    // Base html
    $templateHtml = new \Twig\Loader\ArrayLoader([
      'index.html' => '{% extends "base.html" %}{% block content %}oi: {{ name }}{% endblock %}',
      'base.html'  => 'Default',
    ]);

    // Sequência de prioridade. Arquivos físicos depois Virtuais.
    $loader = new \Twig\Loader\ChainLoader([$templateDir, $templateBd, $templateHtml]);
    $twig = new \Twig\Environment($loader);
    echo $twig->render('index.html', ['name' => 'Fabien']);
  }
}
