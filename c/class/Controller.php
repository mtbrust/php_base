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
  protected $controller_name;


  /**
   * Parametros passados pela URL.
   *
   * @var array
   */
  protected $attr;


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
   * Inicia a verificação de controle e chama função correspondente.
   *
   * @return void
   */
  public function start()
  {

    // Verifica se tem dados $_post para enviar para _post.
    if ($_POST) {
      $this->_post();
    }

    // Verifica os atributos para ver em qual GET vai cair.
    //$attr = Self::$urlFinal['attr'];
    if ($this->attr) {
      switch ($this->attr[0]) {
        case 'post':
            $this->post();
          break;
        case 'put':
          $this->put();
          break;
        case 'get':
          $this->get();
          break;
        case 'delete':
          $this->delete();
          break;
        default:
        $this->index();
          break;
      }
    } else {
      $this->index();
    }
  }


  /**
   * Quando é enviado dados via post.
   *
   * @return bool
   */
  public function _post()
  {
    echo 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controller_name . __CLASS__ . '</b>.<br>';
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
    echo 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controller_name . __CLASS__ . '</b>.<br>';
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
    echo 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controller_name . __CLASS__ . '</b>.<br>';
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
    echo 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controller_name . __CLASS__ . '</b>.<br>';
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
    echo 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controller_name . __CLASS__ . '</b>.<br>';

    return false;
  }


  /**
   * Exibe a página inicial.
   *
   * @return bool
   */
  public function index()
  {
    echo 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controller_name . __CLASS__ . '</b>.<br>';
    print_r($this->attr);

    return false;
  }
}

// $c = new controller_name;
// $c->index();