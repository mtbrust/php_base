<?php

/**
 * Classe que trata os dados e os templates html para criar os blocos html ou executar funções de BD.
 */
class Noticias {

    /**
     * Teste Quadrado.
     *
     * @return void
     */
    public static function getQuadrado()
    {
        $result = [
            'nome' => 'teste'
        ];
        return ControllerRender::renderObj('div_quadrado', $result);
    }


    /**
     * Retorna uma lista de notícias.
     *
     * @return void
     */
    public static function lista()
    {
        $params = BdNoticias::selecionaTudo();
        return ControllerRender::renderObj('lista', $params);
    }


    /**
     * Todo: Trabalhar essa função ainda.
     *
     * @return void
     */
    public function listaNoticias2()
    {
        $result = BdNoticias::selecionaTudo();
        $query = $this->executeQuery("SELECT *, DATE_FORMAT(dataPostagem, '%d/%m/%Y %H:%i') dtHrPostagem FROM noticias ORDER BY dataPostagem DESC");
        $return = [];
        while ($sql = $query->fetch_array()) {
            $return[] = [
                'codNoticia' => utf8_encode($sql['codNoticia']),
                'titulo' => utf8_encode($sql['titulo']),
                'texto' => utf8_encode($sql['texto']),
                'previa' => utf8_encode($sql['previa']),
                'imagemDestaque' => utf8_encode($sql['imagemDestaque']),
                'dataPostagem' => utf8_encode($sql['dtHrPostagem']),
                'status' => utf8_encode($sql['status']),
                'fixaTopo' => utf8_encode($sql['fixaTopo'])
            ];
        }
        return $return;
    }
}
