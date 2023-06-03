<?php

// require_once 'vendor/intervention/image/src/Intervention/Image/Exception/NotSupportedException.php';
// require_once 'vendor/intervention/image/src/Intervention/Image/ImageManager.php';
// require_once 'vendor/intervention/image/src/Intervention/Image/ImageManagerStatic.php';
// use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic as Image;
// use Intervention\Image\Image;

namespace classes;

class Midia
{
    /**
     * Função realiza a armazenagem do arquivo.
     *
     * @param $_FILES $file
     * @param string $nomeArquivo
     * @param string $dir
     * @param string $desc
     * @param boolean $md5
     * @return void
     */
    public static function armazenar($file, $nomeArquivo = null, $dir = 'uploads/', $desc = null, $isImage = true, $md5 = false)
    {
        $id = false;

        // Verifica se post tem arquivo.
        if (!empty($file)) {

            // Obtém extensão do arquivo.
            $extensao = '.' . strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));


            // Obtém nome do arquivo original.
            $nome = Slugifi::convert(pathinfo($file['name'], PATHINFO_FILENAME));

            // Troca o nome para o passado no parâmetro.
            if ($nomeArquivo)
                $nome = Slugifi::convert($nomeArquivo);
            else
                $nomeArquivo = $nome;

            // Criptografa nome da imagem.
            if ($md5) {
                $nome = md5($nome);
            }


            // Ajusta o caminho dir.
            if (!$dir)
                $dir = 'uploads/';

            // Obtém o caminho para onde a midia deve ser gravada.
            $path =  PATH_MODEL_MIDIA . $dir;
            $url = URL_RAIZ . PATH_MODEL_MIDIA . $dir;

            // Verifica se diretório existe e já cria.
            if (!file_exists(DIR_RAIZ . PATH_MODEL_MIDIA))
                mkdir($path, 0755, true);

            // if (!file_exists(DIR_RAIZ . $path))
            //     mkdir($path . $dir, 0755, true);

            // Verifica se o arquivo ja existe.
            $mimeType = '';
            $obs = '';
            if (file_exists(DIR_RAIZ . $path . $nome . $extensao)) {

                // Obtém mimeType do arquivo.
                $mimeType = mime_content_type(DIR_RAIZ . $path . $nome . $extensao);
                // Verifica o mimeType do arquivo é imagem e se é permitido só imagem.
                if ($isImage && explode('/', $mimeType)[0] != 'image')
                    return false;

                // Verifica se tem imagem repitida e cria um novo nome.
                $i = 1;
                $obs = 'Imagem repetida. ';
                while (true) {
                    if (file_exists(DIR_RAIZ . $path . $nome . $i . $extensao)) {
                        $i++;
                    } else {
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
            if (move_uploaded_file($file['tmp_name'], DIR_RAIZ . $path . $nome)) {


                $fileSize = $file['size'];

                // // open and resize an image file
                // $img = Image::make(DIR_RAIZ . $path . $nome);
                // $fileSize = $img->filesize();
                // // save file as jpg with medium quality
                // $img->save(DIR_RAIZ . $path . $nome, 60);

                // if ($img->width() > 1920) {
                //     // resize the image to a width of 300 and constrain aspect ratio (auto height)
                //     $img->resize(1920, null, function ($constraint) {
                //         $constraint->aspectRatio();
                //     });
                // }

                $fields = [
                    'nome' => $nomeArquivo,
                    'nomeArquivo' => $nome,
                    'description' => $obs . $desc,
                    'dir' => $dir,
                    // 'mimeType' => $mimeType,
                    'mimeType' => mime_content_type(DIR_RAIZ . $path . $nome),
                    'urlMidia' => $url . $nome,
                    'dirMidia' => $path . $nome,
                    'extension' => $extensao,
                    'size' => $fileSize,
                    'dtCreate'    => date("Y-m-d H:i:s"),
                ];
                $id = \controle\BdMidias::Adicionar($fields);
                if (!$id) {
                    return false;
                }
            } else {
                return false;
            }
        }

        return $id;
    }




    /**
     * Versão 2
     * Função realiza a armazenagem do arquivo. Versão 2
     * Passa os parametros como array.
     *
     * @param $_FILES $file
     * @param array $options
     * @return int
     */
    public static function armazenar2($file, $options)
    {
        if (empty($file['tmp_name'])) {
            return false;
        }

        if (is_array($file['tmp_name'])){
            $tmp = $file;
            $file['tmp_name'] = $tmp['tmp_name'][$options['position']];
            $file['name'] = $tmp['name'][$options['position']];
            $file['type'] = $tmp['type'][$options['position']];
            $file['error'] = $tmp['error'][$options['position']];
            $file['size'] = $tmp['size'][$options['position']];
        }

        // Exemplo de uso:
        // Prepara as configurações de armazenagem de mídia.
        // $options = [
        //     'nomeArquivo'   => $_POST['f-nome'],                            // Nome do arquivo / Título
        //     'dir'           => 'uploads/',                                  // Pasta que vai ficar dentro de m/midia/.
        //     'desc'          => $_POST['f-description'],                     // Descrição da mídia.
        //     'isImage'       => 0,                                           // Somente imagem.
        //     'md5'           => (isset($_POST['f-criptografar'])) ? 1 : 0,   // criptografar nome.
        //     'qualidade'     => 98,                                          // Qualidade final da imagem.
        //     'larguraMaxima' => 1920,                                        // Largura máxima.
        //   ];

        // Seta as opções default caso não seja definido algum desses itens.
        if (empty($options['nomeArquivo']))
            $options['nomeArquivo'] = null;
        if (empty($options['dir']))
            $options['dir'] = 'uploads/';
        if (empty($options['desc']))
            $options['desc'] = null;
        if (!isset($options['isImage']))
            $options['isImage'] = 1;
        if (!isset($options['md5']))
            $options['md5'] = 0;
        if (!isset($options['private']))
            $options['private'] = 0;
        if (empty($options['qualidade']))
            $options['qualidade'] = 98;
        if (empty($options['larguraMaxima']))
            $options['larguraMaxima'] = 1920;
        if (empty($options['idStatus']))
            $options['idStatus'] = 38;
        if (empty($options['idGrupos']))
            $options['idGrupos'] = null;


        // Retorno
        $id = false;


        // Verifica se post tem arquivo.
        if (!empty($file)) {

            // Obtém extensão do arquivo.
            $extensao = '.' . strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
//            print_r($extensao);
//            exit();

            // Obtém nome do arquivo original.
            $nome = Slugifi::convert(pathinfo($file['name'], PATHINFO_FILENAME));

            // Troca o nome para o passado no parâmetro.
            if ($options['nomeArquivo'])
                $nome = Slugifi::convert($options['nomeArquivo']);
            else
                $options['nomeArquivo'] = $nome;

            // Criptografa nome da imagem.
            if ($options['md5']) {
                $nome = md5($nome);
            }
            

            // Obtém o caminho para onde a midia deve ser gravada.
            $path =  PATH_MODEL_MIDIA . $options['dir'];
            $url = URL_RAIZ . PATH_MODEL_MIDIA . $options['dir'];

            // Obtém array de pastas.
            $pastas = explode('/', $options['dir']);
            
            // Guarda início do diretório.
            $temp_pasta = DIR_RAIZ . PATH_MODEL_MIDIA;
            
            // Percorre cada pasta para criar a pasta solicitada se não existir.
            foreach($pastas as $pasta)
            {
                // Caso tenha valor
                if ($pasta) {
                    $temp_pasta .= $pasta . '/';
                    // Verifica se diretório existe e já cria.
                    if (!file_exists($temp_pasta))
                    {
                        mkdir($temp_pasta, 0755, true);
                    }
                }
            }

            
            // Verifica se o arquivo ja existe.
            $mimeType = mime_content_type($file['tmp_name']);
            $obs = '';
            if (file_exists(DIR_RAIZ . $path . $nome . $extensao)) {

                // Verifica o mimeType do arquivo é imagem e se é permitido só imagem.
                if ($options['isImage'] && explode('/', $mimeType)[0] != 'image')
                    return false;

                // Verifica se tem imagem repitida e cria um novo nome.
                $i = 1;
                $obs = 'Imagem repetida.';
                while (true) {
                    if (file_exists(DIR_RAIZ . $path . $nome . '_' . $i . $extensao)) {
                        $i++;
                    } else {
                        $nome = $nome . '_' . $i;
                        break;
                    }
                }
            }



            // print_r($options['isImage']);
            // print_r(array_search(($extensao), ['.jpeg', '.png', '.jpg']));
            // echo '<hr>';
            // exit;

            // Define quais serão os formatos aceitos
            if ($options['isImage'] && !array_search(($extensao), ['.jpeg', '.png', '.jpg']))
                return false;

            // Segurança reforçada de arquivo
            if (array_search(($extensao), ['.php', '.js', '.sql', '.py', '.exe']))
                return false;


            // Acrescenta a extensão ao nome do arquivo.
            $nome .= $extensao;       
            

            // Grava arquivo no path indicado.
            if (move_uploaded_file($file['tmp_name'], DIR_RAIZ . $path . $nome)) {
                
                $fileSize = $file['size'];

                // Caso seja imagem inicia a otimização.
                if (explode('/', $mimeType)[0] == 'image') {

                    // Path do arquivo
                    $pathCompleto = DIR_RAIZ . $path . $nome;

                    // Cria instância da imagem.
                    $img = Image::make($pathCompleto);
                    
                    // Redimenciona a altura proporcionamente a largura máxima definida.
                    if ($img->width() > $options['larguraMaxima']) {
                        $img->resize($options['larguraMaxima'], null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }


                    // Salva imagem.
                    $img->save($pathCompleto, $options['qualidade']);
                    // Limpa chache.
                    clearstatcache();
                    // Instancia nova imagem salva.
                    $img = Image::make($pathCompleto);
                    // Tamanho do arquivo de imagem.
                    $fileSize = $img->filesize();
                    
                    
                    // Quantas vezes irá comprimir.
                    $maxTres = 3;
                    while ($fileSize > 548576) {
                        // Salva arquivo otimizado.
                        $img->save($pathCompleto, $options['qualidade']);
                        
                        // Diminui a qualidade para a próxima compressão.
                        $options['qualidade'] -= 10;
                        
                        // Verifica quantidade de vezes que comprimiu para finalizar.
                        if ($maxTres-- == 0) {
                            $fileSize = 1;
                        }else{
                            // Limpa chache.
                            clearstatcache();
                            // Instancia nova imagem salva.
                            $img = Image::make($pathCompleto);
                            // Grava novo peso do arquivo.
                            $fileSize = $img->filesize();
                        }
                    }
                    
                } // Termina ajuste de imagem

                $fields = [
                    'nome'        => $options['nomeArquivo'],
                    'nomeArquivo' => $nome,
                    'description' => $obs . $options['desc'],
                    'dir'         => $options['dir'],
                    'extension'   => $extensao,
                    'remote'      => 0,
                    'private'     => $options['private'],
                    'mimeType'    => mime_content_type(DIR_RAIZ . $path . $nome),
                    'size'        => $fileSize,
                    'urlMidia'    => $url . $nome,
                    'dirMidia'    => $path . $nome,
                    'idStatus'    => $options['idStatus'],
                    'idGrupos'    => $options['idGrupos'],

                    // Controle
                    'idLoginCreate' => ControllerSecurity::getSession('id'),
                    'dtCreate'    => date("Y-m-d H:i:s"),
                    'idLoginUpdate' => ControllerSecurity::getSession('id'),
                    'dtUpdate'      => date("Y-m-d H:i:s"),
                ];

//                 print_r($fields);
//                 exit;

                $id = \controle\BdMidias::Adicionar($fields);
            } else {
                return false;
            }
        }

        // Final da ocorrência, retorna id da mídia no banco de dados ou false.
        return $id;
    }


    /**
     * Versão 3
     * Função realiza a armazenagem doe varios arquivos vindo de um array. Versão 2
     * Passa os parametros como array.
     *
     * @param $_FILES $file
     * @param array $options
     * @return int
     */
    public static function armazenar3($file, $options, $posicaoArray = [])
    {
        if (empty($file['tmp_name'])) {
            return false;
        }
        // Exemplo de uso:
        // Prepara as configurações de armazenagem de mídia.
        // $options = [
        //     'nomeArquivo'   => $_POST['f-nome'],                            // Nome do arquivo / Título
        //     'dir'           => 'uploads/',                                  // Pasta que vai ficar dentro de m/midia/.
        //     'desc'          => $_POST['f-description'],                     // Descrição da mídia.
        //     'isImage'       => 0,                                           // Somente imagem.
        //     'md5'           => (isset($_POST['f-criptografar'])) ? 1 : 0,   // criptografar nome.
        //     'qualidade'     => 98,                                          // Qualidade final da imagem.
        //     'larguraMaxima' => 1920,                                        // Largura máxima.
        //   ];

        // Seta as opções default caso não seja definido algum desses itens.
        if (empty($options['nomeArquivo']))
            $options['nomeArquivo'] = null;
        if (empty($options['dir']))
            $options['dir'] = 'uploads/';
        if (empty($options['desc']))
            $options['desc'] = null;
        if (!isset($options['isImage']))
            $options['isImage'] = 1;
        if (!isset($options['md5']))
            $options['md5'] = 0;
        if (!isset($options['private']))
            $options['private'] = 0;
        if (empty($options['qualidade']))
            $options['qualidade'] = 98;
        if (empty($options['larguraMaxima']))
            $options['larguraMaxima'] = 1920;
        if (empty($options['idStatus']))
            $options['idStatus'] = 38;
        if (empty($options['idGrupos']))
            $options['idGrupos'] = null;


        // Retorno
        $id = false;


        // Verifica se post tem arquivo.
        if (!empty($file)) {

            // Obtém extensão do arquivo.
            $extensao = '.' . strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            // Obtém nome do arquivo original.
            $nome = Slugifi::convert(pathinfo($file['name'], PATHINFO_FILENAME));

            // Troca o nome para o passado no parâmetro.
            if ($options['nomeArquivo'])
                $nome = Slugifi::convert($options['nomeArquivo']);
            else
                $options['nomeArquivo'] = $nome;

            // Criptografa nome da imagem.
            if ($options['md5']) {
                $nome = md5($nome);
            }


            // Obtém o caminho para onde a midia deve ser gravada.
            $path =  PATH_MODEL_MIDIA . $options['dir'];
            $url = URL_RAIZ . PATH_MODEL_MIDIA . $options['dir'];

            // Obtém array de pastas.
            $pastas = explode('/', $options['dir']);

            // Guarda início do diretório.
            $temp_pasta = DIR_RAIZ . PATH_MODEL_MIDIA;

            // Percorre cada pasta para criar a pasta solicitada se não existir.
            foreach($pastas as $pasta)
            {
                // Caso tenha valor
                if ($pasta) {
                    $temp_pasta .= $pasta . '/';
                    // Verifica se diretório existe e já cria.
                    if (!file_exists($temp_pasta))
                    {
                        mkdir($temp_pasta, 0755, true);
                    }
                }
            }


            // Verifica se o arquivo ja existe.
            $mimeType = mime_content_type($file['tmp_name']);
            $obs = '';
            if (file_exists(DIR_RAIZ . $path . $nome . $extensao)) {

                // Verifica o mimeType do arquivo é imagem e se é permitido só imagem.
                if ($options['isImage'] && explode('/', $mimeType)[0] != 'image')
                    return false;

                // Verifica se tem imagem repitida e cria um novo nome.
                $i = 1;
                $obs = 'Imagem repetida.';
                while (true) {
                    if (file_exists(DIR_RAIZ . $path . $nome . '_' . $i . $extensao)) {
                        $i++;
                    } else {
                        $nome = $nome . '_' . $i;
                        break;
                    }
                }
            }



            // print_r($options['isImage']);
            // print_r(array_search(($extensao), ['.jpeg', '.png', '.jpg']));
            // echo '<hr>';
            // exit;

            // Define quais serão os formatos aceitos
            if ($options['isImage'] && !array_search(($extensao), ['.jpeg', '.png', '.jpg']))
                return false;

            // Segurança reforçada de arquivo
            if (array_search(($extensao), ['.php', '.js', '.sql', '.py', '.exe']))
                return false;


            // Acrescenta a extensão ao nome do arquivo.
            $nome .= $extensao;


            // Grava arquivo no path indicado.
            if (move_uploaded_file($file['tmp_name'], DIR_RAIZ . $path . $nome)) {

                $fileSize = $file['size'];

                // Caso seja imagem inicia a otimização.
                if (explode('/', $mimeType)[0] == 'image') {

                    // Path do arquivo
                    $pathCompleto = DIR_RAIZ . $path . $nome;

                    // Cria instância da imagem.
                    $img = Image::make($pathCompleto);

                    // Redimenciona a altura proporcionamente a largura máxima definida.
                    if ($img->width() > $options['larguraMaxima']) {
                        $img->resize($options['larguraMaxima'], null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }


                    // Salva imagem.
                    $img->save($pathCompleto, $options['qualidade']);
                    // Limpa chache.
                    clearstatcache();
                    // Instancia nova imagem salva.
                    $img = Image::make($pathCompleto);
                    // Tamanho do arquivo de imagem.
                    $fileSize = $img->filesize();


                    // Quantas vezes irá comprimir.
                    $maxTres = 3;
                    while ($fileSize > 548576) {
                        // Salva arquivo otimizado.
                        $img->save($pathCompleto, $options['qualidade']);

                        // Diminui a qualidade para a próxima compressão.
                        $options['qualidade'] -= 10;

                        // Verifica quantidade de vezes que comprimiu para finalizar.
                        if ($maxTres-- == 0) {
                            $fileSize = 1;
                        }else{
                            // Limpa chache.
                            clearstatcache();
                            // Instancia nova imagem salva.
                            $img = Image::make($pathCompleto);
                            // Grava novo peso do arquivo.
                            $fileSize = $img->filesize();
                        }
                    }

                } // Termina ajuste de imagem

                $fields = [
                    'nome'        => $options['nomeArquivo'],
                    'nomeArquivo' => $nome,
                    'description' => $obs . $options['desc'],
                    'dir'         => $options['dir'],
                    'extension'   => $extensao,
                    'remote'      => 0,
                    'private'     => $options['private'],
                    'mimeType'    => mime_content_type(DIR_RAIZ . $path . $nome),
                    'size'        => $fileSize,
                    'urlMidia'    => $url . $nome,
                    'dirMidia'    => $path . $nome,
                    'idStatus'    => $options['idStatus'],
                    'idGrupos'    => $options['idGrupos'],

                    // Controle
                    'idLoginCreate' => ControllerSecurity::getSession('id'),
                    'dtCreate'    => date("Y-m-d H:i:s"),
                    'idLoginUpdate' => ControllerSecurity::getSession('id'),
                    'dtUpdate'      => date("Y-m-d H:i:s"),
                ];

                // print_r($fields);
                // exit;

                $id = \controle\BdMidias::Adicionar($fields);
            } else {
                return false;
            }
        }

        // Final da ocorrência, retorna id da mídia no banco de dados ou false.
        return $id;
    }


    /**
     * Deleta mídia.
     * Deleta registro no banco de dados.
     * Deleta arquivo na pasta.
     *
     * @param  int $id
     * @return bool
     */
    public static function deletar($id)
    {
        // Se não tiver ID sai.
        if (empty($id)) {
            return true;
        }

        // Obtém mídia.
        $r = \controle\BdMidias::selecionaPorId($id);
        if ($r) {
            // Obtém o caminho do diretório.
            $dirMidia = $r['dirMidia'];
            // Apaga mídia no diretório se não for mídia remoto.
            if (!$r['remote'] && file_exists(DIR_RAIZ . $dirMidia)) {
                unlink(DIR_RAIZ . $dirMidia);
            }
            // Apara a mídia na tabela.
            \controle\BdMidias::deleta($id);

            // Caso tenha executado todos os passos com sucesso.
            return true;
        }

        return false;
    }


    /**
     * Deleta mídia.
     * Deleta registro no banco de dados.
     * Deleta arquivo na pasta.
     *
     * @param  $nome
     * @return bool
     */
    public static function deletaPorNome($nome)
    {
        // Se não tiver ID sai.
        if (empty($nome)) {
            return true;
        }

        // Obtém mídia.
        $r = \controle\BdMidias::selecionaPorNome($nome);
        if ($r) {
            foreach ($r as $item) {

                // Obtém o caminho do diretório.
                $dirMidia = $item['dirMidia'];

                // Apaga mídia no diretório se não for mídia remoto.
                if (!$item['remote'] && file_exists(DIR_RAIZ . $dirMidia)) {
                    unlink(DIR_RAIZ . $dirMidia);
                }
                // Apaga a mídia na tabela.
                \controle\BdMidias::deletaPorNome($nome);

                // Caso tenha executado todos os passos com sucesso.
                return true;
            }
        }

        return false;
    }


    /**
     * Função realiza a armazenagem do arquivo.
     *
     * @param $_FILES $file
     * @param string $nomeArquivo
     * @param string $dir
     * @param string $desc
     * @param boolean $md5
     * @return void
     */
    public static function armazenarNovo($file, $nomeArquivo = null, $dir = 'uploads/', $desc = null, $isImage = true, $md5 = false)
    {
        $id = false;

        // Verifica se post tem arquivo.
        if (!empty($file)) {

            // Obtém extensão do arquivo.
            $extensao = '.' . strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));


            // Obtém nome do arquivo original.
            $nome = Slugifi::convert(pathinfo($file['name'], PATHINFO_FILENAME));

            // Troca o nome para o passado no parâmetro.
            if ($nomeArquivo)
                $nome = Slugifi::convert($nomeArquivo);
            else
                $nomeArquivo = $nome;

            // Criptografa nome da imagem.
            if ($md5) {
                $nome = md5($nome);
            }


            // Ajusta o caminho dir.
            if (!$dir)
                $dir = 'uploads/';

            // Obtém o caminho para onde a midia deve ser gravada.
            $path =  PATH_MODEL_MIDIA . $dir;
            $url = URL_RAIZ . PATH_MODEL_MIDIA . $dir;

            // Verifica se diretório existe e já cria.
            if (!file_exists(DIR_RAIZ . PATH_MODEL_MIDIA))
                mkdir($path, 0755, true);

            // if (!file_exists(DIR_RAIZ . $path))
            //     mkdir($path . $dir, 0755, true);

            // Verifica se o arquivo ja existe.
            $mimeType = '';
            $obs = '';
            if (file_exists(DIR_RAIZ . $path . $nome . $extensao)) {

                // Obtém mimeType do arquivo.
                $mimeType = mime_content_type(DIR_RAIZ . $path . $nome . $extensao);
                // Verifica o mimeType do arquivo é imagem e se é permitido só imagem.
                if ($isImage && explode('/', $mimeType)[0] != 'image')
                    return false;

                // Verifica se tem imagem repitida e cria um novo nome.
//                $i = 1;
//                $obs = 'Imagem repetida. ';
//                while (true) {
//                    if (file_exists(DIR_RAIZ . $path . $nome . $i . $extensao)) {
//                        $i++;
//                    } else {
//                        $nome = $nome . $i;
//                        break;
//                    }
//                }
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
            if (move_uploaded_file($file['tmp_name'], DIR_RAIZ . $path . $nome)) {


                $fileSize = $file['size'];

                // // open and resize an image file
                // $img = Image::make(DIR_RAIZ . $path . $nome);
                // $fileSize = $img->filesize();
                // // save file as jpg with medium quality
                // $img->save(DIR_RAIZ . $path . $nome, 60);

                // if ($img->width() > 1920) {
                //     // resize the image to a width of 300 and constrain aspect ratio (auto height)
                //     $img->resize(1920, null, function ($constraint) {
                //         $constraint->aspectRatio();
                //     });
                // }

                $fields = [
                    'nome' => $nomeArquivo,
                    'nomeArquivo' => $nome,
                    'description' => $obs . $desc,
                    'dir' => $dir,
                    // 'mimeType' => $mimeType,
                    'mimeType' => mime_content_type(DIR_RAIZ . $path . $nome),
                    'urlMidia' => $url . $nome,
                    'dirMidia' => $path . $nome,
                    'extension' => $extensao,
                    'size' => $fileSize,
                    'dtCreate'    => date("Y-m-d H:i:s"),
                ];
                $id = \controle\BdMidias::Adicionar($fields);
                if (!$id) {
                    return false;
                }
            } else {
                return false;
            }
        }

        return $id;
    }
}
