<?php

/**
 * Controller defaul.
 * Usado para [v]views sem arquivo de controle.
 */
class DefaultControllerPage extends ControllerPage
{
  public function pre()
  {
    //echo '<br>Não existe controller da ' . $this->controllerName;
    // echo '<br>Attr: ';
    // print_r($this->attr);
    // echo '<br>Path: ' . Core::getUrlFinal()['path'];

    echo '<br>Estou na controller Default.<br>';

    // Valores para serem inseridos no corpo da página.
    $this->paramsPage = array(
      'nome'          => 'Mateus',               // Exemplo
    );

  }
}