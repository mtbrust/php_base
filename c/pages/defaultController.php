<?php

/**
 * Controller defaul.
 * Usado para [v]views sem arquivo de controle.
 */
class DefaultController extends Controller
{
  public function index()
  {
    echo '<br>Não existe controller' . $this->controller_name;
    // echo '<br>Attr: ';
    // print_r($this->attr);
    // echo '<br>Path: ' . Core::getUrlFinal()['path'];
  }
}