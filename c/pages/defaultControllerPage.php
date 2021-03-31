<?php

/**
 * Controller defaul.
 * Usado para [v]views sem arquivo de controle.
 */
class DefaultControllerPage extends ControllerPage
{
  public function index()
  {
    echo '<br>Não existe controller' . $this->controllerName;
    // echo '<br>Attr: ';
    // print_r($this->attr);
    // echo '<br>Path: ' . Core::getUrlFinal()['path'];
  }
}