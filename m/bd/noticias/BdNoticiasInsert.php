<?php


class BdNoticiasInsert extends Bd
{
    /**
     * Atribui a variavel tableName o valor do nome da tabela.
     * É usado em todas as funções para identificar qual a tabela das querys.
     *
     * @var string
     */
    private static $tableName = 'noticias';



    public static function start()
    {
        $fields = [
            'codNoticia' => 2,
            'titulo' => 'Notícia 02',
            'previa' => 'Prévia da notícia 02.',
            'texto' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry<hr>s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'idFoto' => 2,
        ];

        return Self::Adicionar($fields);
    }


    /**
     * Cria a função add passando as variaveis $fields e $coon como parametros
     *
     * @param array $fields
     * @param PDO $conn
     * @return bool
     */
    public static function Adicionar($fields, $conn = null)
    {
        // Retorno da função insert préviamente definida. (true, false)
        return Self::insert(Self::$tableName, $fields, $conn);
    }

}
