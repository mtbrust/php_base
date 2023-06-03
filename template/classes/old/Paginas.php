<?php

namespace classes;

class Paginas
{

    /**
   * Busca as páginas e ordena dentro do diretório pages.
   * Retorna um array com [bd,dir,page,url] de cada página.
   *
   * @return void
   */
    public static function pagesDir($path = DIR_RAIZ . PATH_VIEW_PAGES)
    {
      //header('Content-Type: application/json');
      $list = Self::recursivePagesDir(0, array(), $path);
  
      // Compara se $a é maior que $b
      function cmpUrl($a, $b)
      {
        return $a['url'] > $b['url'];
      }
  
      // Compara se $a é maior que $b
      function cmpDir($a, $b)
      {
        return $a['dir'] > $b['dir'];
      }
  
      // Ordena
      usort($list, 'cmpDir');
      usort($list, 'cmpUrl');
  
      return $list;
    }



    /**
     * Páginas do diretório recursivo.
     * Retorna um array com [bd,dir,page,url] de cada página.
     *
     * @param integer $i
     * @param array $list
     * @param [type] $path
     * @param string $dir
     * @return array
     */
    private static function recursivePagesDir($i = 0, $list = array(), $path = DIR_RAIZ . PATH_VIEW_PAGES, $dir = '')
    {
      // Carrega objeto de diretório.
      $diretorio = dir($path . $dir);
  
      // Anda pelos itens dentro de $diretório.
      while ($arquivo = $diretorio->read()) {
  
        // Caso não seja '.' (Pasta atual) nem '..' (Pasta anterior), segue o código.
        if ($arquivo != '.' && $arquivo != '..') {
          // Verifica se é um diretório.
          if (is_dir($path . $dir . $arquivo)) {
            // Entra novamente na função com a pasta atual e retorna o array (lista de arquivos).
            $list = Self::recursivePagesDir($i, $list, $path, $dir . $arquivo . '/');
            // Continua da posição que parou após o recursivo.
            $i = count($list);
          } else {
            $file = explode('.', $arquivo);
            if ($file[1] == "html") {
              // Cadastra o arquivo na próxima posição do array.
              $list[$i]['bd'] = false;
              $list[$i]['dir'] = $dir;
              $list[$i]['page'] = $arquivo;
              $list[$i]['url'] = $dir . $file[0] . '/';
            }
          }
          // Anda mais uma posição do array.
          $i++;
        }
      }
      // Fecha diretório.
      $diretorio->close();
  
      // Retorna array.
      return $list;
    }
    
}
