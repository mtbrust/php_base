<?php

namespace api;

/**
 * ORIENTAÇÕES DO MODELO PADRÃO
 * Modelo padrão de controller para o endpoint (páginas ou APIs).
 * Modelo contém todas as informações que são possíveis usar dentro de uma controller.
 * É possível tirar, acrescentar ou mudar parâmetros para obter resultados mais eficientes e personalizados.
 * 
 * ORIENTAÇÕES DA CONTROLLER
 * Os arquivos e classes são carregados após a função loadParams().
 * O método padrão para visualização é a get().
 * Na função get, é realizada toda a programação das informações do endpoint.
 * É possível chamar outras funções (Sub-Menus) usando parâmetros (Url e LoadParams).
 * Outras funções (Sub-Menus) são chamados de acordo com a estrutura personalizada no parâmetros "menus".
 * 
 * O nome da controller é o mesmo que o endpoint da url sem os "-".
 * Porém é possível passar pela url o endpoint "/quem-somos", pois o sistema irá tirar os "-".
 * O nome da controller vai ficar como "quemsomos".
 * 
 */
class ping extends \controllers\EndPoint
{

  /**
   * * *******************************************************************************************
   * PERSONALIZAÇÃO DO ENDPOINT
   * * *******************************************************************************************
   */


  /**
   * loadParams
   * Carrega os parâmetros de personalização do endpoint.
   * Valores Default vem da config.
   * 
   * * Opções com * podem ser modificadas no processamento.
   *
   * @return void
   */
  public function loadParams()
  {
    // Opções de renderização.
    self::$params['render'] = [
      'content_type' => 'application/json',   // Tipo do retorno padrão do cabeçalho http.
    ];

    // Monta estrutura de parâmetros passados na url ou metodo.
    self::$params['menus']       = [
      // Função:
      'get' => [
          'title'      => 'Listar',      // Nome exibido no menu. Somente pages.
          'permission' => [
            "session" => 0,   // Necessário usuário com sessao nesta página.
            "get"     => 1,   // Permissão para acessar a função get desta página.
            "getFull" => 0,   // Permissão para acessar a função getFull desta página.
            "post"    => 0,   // Permissão para acessar a função post ou requisição post desta página.
            "put"     => 0,   // Permissão para acessar a função put ou requisição put desta página.
            "patch"   => 0,   // Permissão para acessar a função patch ou requisição patch desta página.
            "del"  => 0,   // Permissão para acessar a função delete ou requisição delete desta página.
            "api"     => 0,   // Permissão para acessar a função API desta página.
            "especific" => [
              'botao_excluir' => 1, // Permissão personalizada da página. Exemplo: só aparece o botão excluir para quem tem essa permissão específica da página.
              'botao_editar' => 1,
            ],
          ],
          'groups'     => [],            // Quais grupos tem acesso a esse menu.
          'ids'        => [],            // Quais ids tem acesso a esse menu.
      ],
    ];
  }


  /**
   * get
   * 
   * Função principal.
   * Recebe todos os parâmetros do endpoint em $params.
   * Retorna todas as informações em return.
   *
   * @param  mixed $params
   */
  public function get($params)
  {
    // Finaliza a execução da função.
    self::$params['response'] = 'pong';
    self::$params['msg'] = 'Requisição recebida com sucesso.';
    self::$params['status']   = 200;
  }
  
}