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
  }
}
