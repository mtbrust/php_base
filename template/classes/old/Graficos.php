<?php

namespace classes;


/**
 * Classe para controle de gráficos e indicadores.
 */
class Graficos
{
    static $id = 1;

    /**
     * Função que retorna um html com as dependências.
     *
     * @return string
     */
    public static function dependences()
    {
        $options = [
            'URL_RAIZ' => URL_RAIZ
        ];
        $html = ControllerRender::renderObj('classes/graficos/dependences', $options);

        return $html;
    }

    /**
     * Função que cria um box indicativo.
     * Em options é definido o estido e versao do indicativo.
     * Retorna um html
     *
     * @param array $options
     * @return string
     */
    public static function indicador($options = array())
    {
        // Valores default
        $default = [
            'v'             => 1,

            // Dados
            'titulo'        => 'Título Indicador',
            'subTitulo'     => 'Indicador com valores default.',
            'tipo'          => 'secondary',
            'icon'          => '<i class="fas fa-dot-circle"></i>',
            'prefixo'       => '',
            'valor'         => '9.999',
            'sufixo'        => '',

            // Box
            'col'           => 'col-md-3 col-sm-6 col-12',
            
            // Modal
            'informacao'    => '',
            'detalhes'      => '',

            // Controle
            'id'            => Self::$id++,
        ];

        // Sobrescreve valores default.
        $options = array_merge($default, $options);

        // Gera o Html do indicador.
        $html = ControllerRender::renderObj('classes/graficos/indicador_' . $options['v'], $options);

        // Retorna o html.
        return $html;
    }


	public static function test(){
		echo "Classe funciona.";
		return true;
	}
}
