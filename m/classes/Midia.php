<?php


class Midia
{
    /**
     * Função realiza a armazenagem do arquivo.
     *
     * @param $_FILES $post
     * @param string $nomeArquivo
     * @param string $dir
     * @param string $desc
     * @param boolean $md5
     * @return void
     */
    public static function armazenar($post, $nomeArquivo = null, $dir = 'upload/', $desc = null, $isImage = true, $md5 = false)
    {
        $id = false;

        // Verifica se post tem arquivo.
        if (!empty($post)) {

            // Obtém extensão do arquivo.
            $extensao = '.' .strtolower(pathinfo($post['name'], PATHINFO_EXTENSION));


            // Obtém nome do arquivo original.
            $nome = pathinfo($post['name'], PATHINFO_FILENAME);

            // Troca o nome para o passado no parâmetro.
            if ($nomeArquivo)
                $nome = $nomeArquivo;

            // Criptografa nome da imagem.
            if ($md5) {
                $nome = md5($nome) ;
            }


            // Ajusta o caminho dir.
            if (!$dir)
                $dir = 'upload/';

            // Obtém o caminho para onde a midia deve ser gravada.
            $path =  PATH_MODEL_MIDIA . $dir;
            $url = URL_RAIZ . PATH_MODEL_MIDIA . $dir;
            
            // Verifica se diretório existe e já cria.
            if (!file_exists(DIR_RAIZ . PATH_MODEL_MIDIA))
                mkdir($path, 0750, true);

            if (!file_exists(DIR_RAIZ . $path))
                mkdir($path . $dir, 0750, true);

            // Verifica se o arquivo ja existe.
            $obs = '';
            if (file_exists( DIR_RAIZ . $path. $nome . $extensao)){
                mime_content_type(DIR_RAIZ . $path. $nome . $extensao);
                $i = 1;
                $obs = 'Imagem repetida.';
                while (true) {
                    if (file_exists(DIR_RAIZ . $path  . $nome . $i . $extensao)) {
                        $i++;
                    }else{
                        $nome = $nome . $i;
                        break;
                    }
                }
            }

            // Define quais serão os formatos aceitos
            if ($isImage && !array_search(($extensao), ['.jpeg', '.png', '.jpg']))
                return false;


            // Segurança reforçada de arquivo
            if (array_search(($extensao), ['.php', '.js', '.sql', '.py', '.exe']))
                return false;


            // Acrescenta a extensão ao nome do arquivo.
            $nome .= $extensao;

            // Grava arquivo no path indicado.
            if (move_uploaded_file($post['tmp_name'], DIR_RAIZ . $path . $nome)) {
                $fields = [
                    'nome' => $nome,
                    'obs' => $obs . $desc,
                    'dir' => $dir,
                    'urlMidia' => $url . $nome,
                    'dirMidia' => $path . $nome,
                    'extension' => $extensao,
                ];
                $id = BdMidia::Adicionar($fields);
            } else {
                return false;
            }
        }

        return $id;
    }


    public static function deletar($id)
    {
        $r = BdMidia::selecionaPorId($id);
        if ($r) {
            $dirMidia = $r['dirMidia'];
            if (file_exists(DIR_RAIZ . $dirMidia)) {
                unlink(DIR_RAIZ . $dirMidia);
            }
            BdMidia::deleta($id);



        }
        header('LOCATION: ' . URL_RAIZ . 'admin/noticias/test/');

    }
}
