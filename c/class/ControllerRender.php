<?php

/**
 * Classe responsável por juntar os blocos de template colocar os parâmetros e renderizar.
 */
class ControllerRender
{

  /**
   * Renderiza objetos da pasta v/templates/objs/.
   * Renderiza um objeto html passando parâmetros (pasta/nomeobj - sem mencionar a extenção .html).
   * Retorna uma string HTML.
   *
   * @param string $objName
   * @param array $params
   * @return string
   */
  public static function renderObj($objName, $params = null)
  {
    // Inicia a construção do objeto HTML
    $loader   = new \Twig\Loader\FilesystemLoader('v/templates/objs/');   // Verifica a pasta objs.
    $twig     = new \Twig\Environment($loader);                           // Instancia objeto twig.
    $template = $twig->load($objName . '.html');                          // Retorna template html.
    return $template->render($params);                                    // Junta parametros com template. (array associativo)
  }


  /**
   * Renderiza a parte gráfica (html) do site.
   * Recebe os arquivos modelos HTML e o seu conteúdo.
   * Recebe parâmetros de variáveis para serem usados dentros dos modelos.
   *
   * @param array $params
   * @return void
   */
  public static function render($params)
  {

    // Arquivos físicos.
    $vurlf = new \Twig\Loader\ArrayLoader(
      $params['template']
    );

    // Arquivos virtuais.
    // Todo: Não implementado. Apenas exemplo.
    $vurlv = new \Twig\Loader\ArrayLoader([
      'html' => '<div id="html"><div id="head"><title>Banco de dados</title>{% block head %}{% endblock %}</div><div id="body">{% block body %}{% endblock %}</div></div>',
      'head' => '{% block head %}<div value="teste">array head</div>{% endblock %}',
    ]);

    
    // Monta quais são as partes (pastas) que se usa no template da página atual.
    $base = '';
    foreach (array_keys($params['template']) as $key => $value) {
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

    // Limpa os parâmetros antes de mandar para renderização.
    unset($params['template']);
    unset($params['bd']);
    unset($params['classes']);

    // Após carregar os templates HTML, e passar os parmâmetros, desenha página na tela.
    return $twig->render('base', $params);
  }
}
