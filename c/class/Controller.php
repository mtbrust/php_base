<?php

/**
 * Classe pai para os controller_names.
 * Necessário implementar todos os possíveis métodos que poderão ser usados.
 * Serve como modelo para criação de controller_names.
 */
class Controller
{

  /**
   * Nome do controller_name atual.
   *
   * @var string
   */
  private $controller_name;


  /**
   * Parametros passados pela URL.
   *
   * @var array
   */
  private $attr;


  /**
   * Construtor.
   */
  function __construct()
  {
    // Trata o nome do controller.
    $this->controller_name = ucfirst(Core::getUrlFinal()['file']);

    
    // Pega os atributos (parametros passados pela url).
    $this->attr = Core::getUrlFinal()['attr'];
  }

  /**
   * Quando é enviado dados via post.
   *
   * @return bool
   */
  public function _post()
  {
    echo 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controller_name . __CLASS__ . '</b>.';
    var_dump($_POST);

    return false;
  }


  /**
   * Cria um registro
   *
   * @return bool
   */
  public function post()
  {
    echo 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controller_name . __CLASS__ . '</b>.';
    print_r($this->attr);

    return false;
  }


  /**
   * Atualiza registros
   *
   * @return bool
   */
  public function put()
  {
    echo 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controller_name . __CLASS__ . '</b>.';
    print_r($this->attr);

    return false;
  }


  /**
   * Exibe registros.
   *
   * @return void
   */
  public function get()
  {
    echo 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controller_name . __CLASS__ . '</b>.';
    print_r($this->attr);

    return false;
  }


  /**
   * Deleta um registro.
   *
   * @return bool
   */
  public function delete()
  {
    echo 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controller_name . __CLASS__ . '</b>.';

    return false;
  }


  /**
   * Exibe a página inicial.
   *
   * @return bool
   */
  public function index()
  {
    echo 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controller_name . __CLASS__ . '</b>.';
    print_r($this->attr);

    return false;
  }
}

// $c = new controller_name;
// $c->index();