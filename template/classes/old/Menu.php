<?php

namespace classes;

class Menu
{

    /**
     * Cria o menu no modelo do LTE
     *
     * @param array $array
     * @param string $URL_RAIZ
     * @return string
     */
    public static function criaHtml($array, $URL_RAIZ)
    {
        if (empty($array))
            return '';
        // Chama função recursiva para montar menu.
        $html = Self::recursiveMenu($array, 0, $URL_RAIZ);
        return $html;
    }


    /**
     * Recursivo para montagem do menu.
     * Percorre o array de menu e monta dropdown e hierarquia.
     *
     * @param array $array
     * @param int $i
     * @param string $URL_RAIZ
     * @param string $html
     * @param integer $tamanho
     * @return string
     */
    private static function recursiveMenu($array, $i, $URL_RAIZ, $html = '', $tamanho = 0)
    {
        // Ponto de parada
        if ($i >= count($array)) {
            return '';
        }
        //Obtém linha atual do array.
        $value = $array[$i];
        $html = '';

        // Verifica se é submenu. se não fecha tag.
        $count = count(explode('.', $value['ordem'])) - 1;
        if ($count <= $tamanho) {
            $pos = $tamanho - $count;
            while ($pos >= 0) {
                $pos--;
                $html .= '</li>';
                $html .= '</ul>';
                $tamanho--;
            }
        }

        if ($value['url'] == 'divisor') {
            $html .= '<li><hr style="width: 100%;">';
        }
        else{

        // Desenha menu com icone.
        // $html .= '<li>' . 'T:[' . $tamanho . '] ' . $value['nome'] . ' [' . $value['ordem'] . '] [' . $count . '] [' . $value['url'] . ']';
            $html .= '<!-- '.$value['nome'].' -->';
            $html .= '<li class="nav-item">';
            $html .= '<a href="'. $URL_RAIZ . $value['url'] .'" class="nav-link">';
            $html .= '<i class="nav-icon '.$value['icone'].'"></i>';
            $html .= '<p>';
            $html .= ' ';
            $html .= $value['nome'];
            $html .= ($value['url'] == '0')?'<i class="fas fa-angle-left right"></i>':'';
            $html .= '</p></a>';
        }

        // Verifica se menu é pai e cria uma lista. Se não termina o li do menu atual.
        if ($value['url'] == '0') {
            //$html .= '<br>pai [' . $value['ordem'] . ']';
            $tamanho++;
            $html .= '<ul class="nav nav-treeview">';
            $html .= Self::recursiveMenu($array, $i + 1, $URL_RAIZ, $html, $tamanho);
        } else {
            $html .= '</li>';
            $html .= Self::recursiveMenu($array, $i + 1, $URL_RAIZ, $html, $tamanho);
        }

        return $html;
    }

    /**
     * Cria o menu no modelo do LTE
     *
     * @param array $array
     * @param string $URL_RAIZ
     * @return string
     */
    public static function criaHtmlSimples($array, $URL_RAIZ)
    {
        if (empty($array))
            return '';
        // Chama função recursiva para montar menu.
        $html = '<ul style="width: 100%;">';
        $html .= Self::recursiveMenuSimples($array, 0, $URL_RAIZ);
        $html .= '</ul>';
        return $html;
    }


    /**
     * Recursivo para montagem do menu.
     * Percorre o array de menu e monta dropdown e hierarquia.
     *
     * @param array $array
     * @param int $i
     * @param string $URL_RAIZ
     * @param string $html
     * @param integer $tamanho
     * @return string
     */
    private static function recursiveMenuSimples($array, $i, $URL_RAIZ, $html = '', $tamanho = 0)
    {
        // Ponto de parada
        if ($i >= count($array)) {
            return '';
        }
        //Obtém linha atual do array.
        $value = $array[$i];
        $html = '';

        // Verifica se é submenu. se não fecha tag.
        $count = count(explode('.', $value['ordem'])) - 1;
        if ($count <= $tamanho) {
            $pos = $tamanho - $count;
            while ($pos >= 0) {
                $pos--;
                $html .= '</li>';
                $html .= '</ul>';
                $tamanho--;
            }
        }

        if ($value['url'] == 'divisor') {
            $html .= '<li style="display: block;"><hr style="width: 100%;">';
        }
        else{

        // Desenha menu com ul.
            $html .= '<li>';
            $html .= $value['ordem'] . ' ';
            $html .= '<i class="nav-icon '.$value['icone'].'"></i> ';
            // $html .= '<p>';
            $html .= $value['nome'];
            // $html .= '</p>';
        }

        // Verifica se menu é pai e cria uma lista. Se não termina o li do menu atual.
        if ($value['url'] == '0') {
            //$html .= '<br>pai [' . $value['ordem'] . ']';
            $tamanho++;
            $html .= '<ul>';
            $html .= Self::recursiveMenuSimples($array, $i + 1, $URL_RAIZ, $html, $tamanho);
        } else {
            $html .= '</li>';
            $html .= Self::recursiveMenuSimples($array, $i + 1, $URL_RAIZ, $html, $tamanho);
        }
        return $html;
    }
}
