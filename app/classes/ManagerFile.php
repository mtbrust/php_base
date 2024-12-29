<?php

namespace classes;

/**
 * Classe Modelo.
 * Usado para executar funções específicas de um determinado assunto.
 */
class ManagerFile
{
    /**
     * Escreve na última linha do arquivo.
     *
     * @param string $pathName
     * @param string $content
     * 
     * @return void
     * 
     */
    public static function write($pathName, $content)
    {
        // Verifica se path existe.
        self::createIfNotExistDirPath($pathName);
        // Abre o arquivo para gravar conteúdo.
        $arquivo = fopen($pathName, 'a');
        // Grava conteúdo na última linha.
        fwrite($arquivo, "\r\n" . $content);
        // Fecha arquivo.
        fclose($arquivo);
    }


    /**
     * Carrega um arquivo.
     *
     * @param string $pathName
     * 
     * @return string
     * 
     */
    public static function read($pathName)
    {
        return file_get_contents($pathName);
    }

    /**
     * Verifica se o tempo de vida do arquivo é maior que o tempo passado.
     *
     * @param string $pathName
     * @param int $time
     * 
     * @return bool
     * 
     */
    public static function timeExpired($pathName, $time)
    {
        // Se o arquivo existe e cache não venceu finaliza.
        if (is_file($pathName) && time() - filemtime($pathName) < $time) {
            return false;
        }
        return true;
    }

    /**
     * Cria arquivo e os diretórios.
     *
     * @param string $pathName
     * @param string $content
     * 
     * @return void
     * 
     */
    public static function create($pathName, $content)
    {
        // Verifica se path existe.
        self::createIfNotExistDirPath($pathName);
        // Grava o arquivo.
        file_put_contents($pathName, $content);
    }

    /**
     * Verifica todo o path passado e cria as pastas caso não exista.
     *
     * @param string $pathName
     * 
     * @return void
     * 
     */
    public static function createIfNotExistDirPath($pathName)
    {
        // Divide o path em pastas.
        $pastas = explode('/', $pathName);
        $anterior = '';
        // Percorre cada pasta.
        foreach ($pastas as $key => $pasta) {
            if (strpos($pasta, '.') === false) {
                self::createDir($anterior . $pasta);
            }
            $anterior .= $pasta . '/';
        }
    }

    /**
     * Cria a pasta caso não exista.
     *
     * @param string $path
     * 
     * @return void
     * 
     */
    private static function createDir($path)
    {
        // Se não for uma pasta.
        if (!is_dir(BASE_DIR . $path)) {
            // Cria a pasta com permissões para leitura.
            mkdir(BASE_DIR . $path, 0755, true);
        }
    }
}
