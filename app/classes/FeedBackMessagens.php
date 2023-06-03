<?php

namespace classes;


/**
 * Classe para controle de mensagens de feedback.
 */
class FeedBackMessagens
{
    /**
     * Guarda as mensagens criadas na página.
     * 
     *
     * @var array
     */
    private static $messages = array();


    public static function get()
    {

        // Retorno padrão.
        $html = '<!-- Sem Mensagens de feedback. -->';
        // $html = serialize(Self::$messages);

        // Caso tenha mensagens, cria html.
        if (isset(Self::$messages[0])) {
            $html = \controllers\Render::obj('feedbackmessagens.html', ['msgs' => Self::$messages]);
        }

        // Retorna o html com as mensagens.
        return $html;
    }

    /**
     * Função que acrescenta uma mensagem de FeedBack para usuário.
     * Type: [primary], [secondary], [success], [danger], [warning], [info], [light], [dark].
     *
     * @param string $type
     * @param string $title
     * @param string $message
     * @return bool
     */
    public static function add($type, $title, $message)
    {
        // Cria item com o tipo e a mensagem.
        $item = [
            'type'  => $type,
            'title' => $title,
            'msg'   => $message,
        ];

        // Acrescenta item no array de mensagens.
        array_push(Self::$messages, $item);

        return true;
    }

    /**
     * Adiciona feedBack de informação (Azul)
     *
     * @param string $title
     * @param string $message
     * @return void
     */
    public static function addInfo($title, $message)
    {
        self::add('info', $title, $message);
    }

    /**
     * Adiciona feedBack de Sucesso (Verde)
     *
     * @param string $title
     * @param string $message
     * @return void
     */
    public static function addSuccess($title, $message)
    {
        self::add('success', $title, $message);
    }

    /**
     * Adiciona feedBack de Erro (Vermelho)
     *
     * @param string $title
     * @param string $message
     * @return void
     */
    public static function addDanger($title, $message)
    {
        self::add('danger', $title, $message);
    }

    /**
     * Adiciona feedBack de Atenção (Amarelo)
     *
     * @param string $title
     * @param string $message
     * @return void
     */
    public static function addWarning($title, $message)
    {
        self::add('warning', $title, $message);
    }
}
