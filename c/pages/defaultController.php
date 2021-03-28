<?php

/**
 * Controller defaul.
 * Usado para páginas sem arquivo de controle.
 */
class DefaultController extends Controller
{
  public function index()
  {
    echo '<br>Não existe controller' . $this->controller_name;

    
  }
}