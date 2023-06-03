<?php

namespace classes;

define('LOCATION_WS_BOLSA', 'https://apps.coopama.com.br:443/oci/ws/bolsa/ws-bolsa.php');
define('URI_WS_BOLSA', 'https://apps.coopama.com.br:443/oci/ws/bolsa');
define('TOKEN', '5z8/nd9Vv}yk[3n"`]]=;36R-]"%STNw0H<1D5+w:BQ65~CA,jF[a:j#}yw->})s');

class Bolsa
{


        public static function carregaValoresBolsa()
        {
            //if ($_SERVER['HTTP_REFERER'] == 'https://coopama.com.br/cotacao/')


            $optionsBolsa = array(
                'location' => LOCATION_WS_BOLSA,
                'uri' => URI_WS_BOLSA,
                'trace' => 0,
                //'exceptions' => 0,
                #'encoding' => 'UTF-8',
                #'soap_ version' => 'SOAP_1_2',
                #'connection_timeout' => 2000,
                'stream_context' => stream_context_create(array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        //'ciphers'=>'AES256-SHA'
                    )
                ))
            );

              $client = new SoapClient(null, $optionsBolsa);

            $result = $client->gerarJsonSaidaBolsa(TOKEN);

            $arrayRetorno = array();
            foreach ($result['result'] as $key => $conteudo){
//                $conteudo = str_replace('""', '', $conteudo);
                $arrayRetorno[$key] = explode(';', $conteudo);
//                print_r($arrayRetorno[$key]);

            }

//            print_r($arrayRetorno);
//            exit();
            return $arrayRetorno;

//            if ($result['erro'] == 'NO') {
//
//                $arquivoCotacao =   'c/pages/cotacao/cotacao.csv';
//
//                if (file_exists($arquivoCotacao)) {
//                    unlink($arquivoCotacao);
//                }
//
//                foreach ($result['result'] as $linha) {
//                    file_put_contents(utf8_encode($arquivoCotacao), $linha, FILE_APPEND);
//                }
//
//
//                $arquivo = file($arquivoCotacao);
//
//                $linha = '';
//                $html = '';
//                $arrayRetorno = array();
//                $arrayPermitido = array(
//                    0,
//                    1,
//                    2,
//                    3,
//                    4,
//                    6,
//                    7,
//                    8,
//                    9,
//                    10,
//                    11, 12, 13,
//                    14, 15, 16
//                );
//
//                foreach ($arquivo as $key => $row) {
//                    if ($key <= 15) {
//                        $row = ($row);
//                        //$row = str_replace(',,,,,,,,,,,,,,,,','', $row);
//                        $linha = explode(';', $row);
//
//                        foreach ($linha as $key2 => $col) {
//
//                            $arrayRetorno[$key . 'x' . ($key2 + 1)] = $col;
//                            //}
//                        }
//                    }
//                }
//
//                $arquivoCotacao = $_SERVER['DOCUMENT_ROOT'] . '/cotacao/cotacao.csv';
//
//                $data = date("d/m/Y H:i:s", filemtime($arquivoCotacao));
//                $data = str_replace(' ', '<br>', $data);
//
//            }
            echo json_encode(array(
                'bolsa' => $arrayRetorno,
                'data' => $data . ' hs',
            ));
        }
}





