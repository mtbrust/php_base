<?php

/**
 * Classe responsável por juntar os blocos de template colocar os parâmetros e renderizar.
 */
class ControllerRender
{
  /**
   * Renderiza a parte gráfica (html) do site.
   * Recebe os arquivos modelos HTML e o seu conteúdo.
   * Recebe parâmetros de variáveis para serem usados dentros dos modelos.
   *
   * @param array $paramsSecurity
   * @param array $paramsController
   * @param array $paramsTemplate
   * @param array $paramsTemplateObjs
   * @param array $paramsView
   * @param array $paramsPage
   * @return void
   */
  public static function render($paramsSecurity, $paramsController, $paramsTemplate, $paramsTemplateObjs, $paramsView, $paramsPage)
  {

    // Arquivos físicos.
    $vurlf = new \Twig\Loader\ArrayLoader(
      $paramsTemplate
    );

    // Arquivos virtuais
    $vurlv = new \Twig\Loader\ArrayLoader([
      'html' => '<div id="html"><div id="head"><title>Banco de dados</title>{% block head %}{% endblock %}</div><div id="body">{% block body %}{% endblock %}</div></div>',
      'head' => '{% block head %}<div value="teste">array head</div>{% endblock %}',
    ]);
    
    // Monta quais são as partes pastas que se usa modelo no template.
    $base = '';
    foreach (array_keys($paramsTemplate) as $key => $value) {
      if (!$key == 0)
      $base .= '{% use "'. $value .'" %}';
    }

    // Base html. Aqui controla quais arquivos o TWIG irá renderizar.
    $html_base = new \Twig\Loader\ArrayLoader([
      'base' => '{% extends "html" %}' . $base
    ]);

    // Sequência de prioridade. Arquivos físicos depois Virtuais.
    $loader = new \Twig\Loader\ChainLoader([$vurlf, $vurlv, $html_base]);
    $twig   = new \Twig\Environment($loader);

    // Após carregar os templates HTML, e passar os parmâmetros, desenha página na tela.
    echo $twig->render('base', array_merge($paramsView, $paramsPage));
  }
}
