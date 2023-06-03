<?php

namespace classes;

class ApiSap
{
    static private $url = BASE_AUTH['sap_url'];
    static private $company_db = BASE_AUTH['sap_db'];
    static private $username_sap = BASE_AUTH['sap_username'];
    static private $password_sap = BASE_AUTH['sap_password'];
    // static private $num_seq_fat = BASE_AUTH['sap_'];
    static public $isLogged = false;
    static public $sessionId = '';
    static public $cookies = [];
    
    /**
     * isLogged
     * 
     * Verifica se já está logado.
     *
     * @return boolean
     */
    public static function isLogged()
    {
        return self::$isLogged;
    }


    /**
     * authHeaders
     * 
     * é repassada a sessão do login para cada requisição http.
     *
     * @return array
     */
    static private function authHeaders()
    {
        return [
            'Content-Type: application/json',
            'Cookie: B1SESSION=' . self::$sessionId . '; ROUTEID=' . self::$cookies['ROUTEID'] . ';'
        ];
    }

    /** 
     * @access public
     * @author Paulo Wender e Mateus Brust
     * @internal Faz o login na API para pegar a SessionID
     */
    public static function login()
    {
        // Verifica se já está logado e possui o id da sessao
        if (self::$isLogged && self::$sessionId) {
            return true; //caso esteja retorna true
        }

        $data['CompanyDB'] = self::$company_db; // Não sabemos
        $data['UserName'] = self::$username_sap; // usuario
        $data['Password'] = self::$password_sap; // senha

        //Opções para envio da requisição.
        $options = [
            // Endpoint.
            'url'    => self::$url . 'Login',
            // Dados POST ou GET.
            'data'   => $data,
            // Método GET,POST,PUT,DELETE,etc.
            'method' => 'POST',
        ];

        // Envio a requisição de login para o SAP
        $r = \classes\HttpRequest::request($options);
        $r = json_decode($r, true);

        if (isset($r['SessionId'])) {

            self::$isLogged = true;
            self::$sessionId = $r['SessionId'];
            self::$cookies = \classes\HttpRequest::getCookies();
        }

        // Retorna o status do login
        return self::$isLogged;
    }


    /** 
     * @access public
     * @author Paulo Wender e Mateus Brust
     * @internal Consulta na API as baixas das parcelas do pedido
     * @param string $cardCode
     */
    public static function listBaixasParcelas($cardCode)
    {

        // Endpoint a ser chamado
        $endpoint = 'IncomingPayments?';
        
        // Monta o filtro com o código do cartão passado por parametro
        $filter = '$filter=' . "Cancelled eq 'tNO' and CardCode eq '" . $cardCode . "'";

        // Monta a url encodando os dados do filtro
        $url = self::$url . $endpoint . urlencode($filter);

        if (!self::login()) {
            return false;
        }

        // Opções para envio da requisição.
        $options = [
            // Endpoint.
            'url'     => $url,
            // Método GET,POST,PUT,DELETE,etc.
            'method'  => 'GET',
            // Obtem os header
            'headers' => self::authHeaders(),
        ];

        // Envio a requisição de login para o SAP
        $r = \classes\HttpRequest::request($options);
        
        $r = json_decode($r, true);

        return $r;
    }

    
    /**
     * postParcelaContasReceber
     * 
     * Cria uma contas a receber (dar baixa em uma parcela ou várias).
     *
     * @param  mixed $docEntry
     * @return array|boolean
     */
    public static function postParcelaContasReceber($fields)
    {
        // Endpoint a ser chamado
        $endpoint = 'IncomingPayments';

        // Monta a url.
        $url = self::$url . $endpoint;

        // Tenta realizar o login
        if (!self::login()) {
            return false;
        }

        // Valores default para criação de pedido.
		$fieldsDefault = [
			'campo'     => 'valor',
		];
		
		// Junta e sobreescreve Default
		$fields = array_replace_recursive($fieldsDefault, $fields);

        //Opções para envio da requisição.
        $options = [
            // Endpoint.
            'url'     => $url,
            // Conteúdo.
            'data'     => $fields,
            // Método GET,POST,PUT,DELETE,etc.
            'method'  => 'POST',
            // Obtem os header
            'headers' => self::authHeaders(),
        ];

        // Envio a requisição de login para o SAP
        $r = \classes\HttpRequest::request($options);
        
        $r = json_decode($r, true);

        return $r;
    }

    
    /**
     * getParcelaContasReceberCPF
     * 
     * Retorna as parcelas de contas a receber por CardCode (CPF + C).
     *
     * @param  mixed $docEntry
     * @return array|boolean
     */
    public static function getParcelaContasReceberCardCode($cardCode )
    {
        // Endpoint a ser chamado
        $endpoint = 'Invoices?';

        // Monta o filtro com o código do cliente passado por parametro
        $filter = '$filter=' . "Cancelled eq 'tNO' and CardCode eq '$cardCode'";

        // Monta a url encodando os dados do filtro
        $url = self::$url . $endpoint . urlencode($filter);

        // Tenta realizar o login
        if (!self::login()) {
            return false;
        }

        //Opções para envio da requisição.
        $options = [
            // Endpoint.
            'url'     => $url,
            // Método GET,POST,PUT,DELETE,etc.
            'method'  => 'GET',
            // Obtem os header
            'headers' => self::authHeaders(),
        ];

        // Envio a requisição de login para o SAP
        $r = \classes\HttpRequest::request($options);
        
        $r = json_decode($r, true);

        return $r;
    }

    
    /**
     * postNotaFutura
     * 
     * Cria uma nota futura.
     *
     * @param  mixed $docEntry
     * @return array|boolean
     */
    public static function postNotaFutura($fields)
    {
        // Endpoint a ser chamado
        $endpoint = 'Invoices';

        // Monta a url.
        $url = self::$url . $endpoint;

        // Tenta realizar o login
        if (!self::login()) {
            return false;
        }


        // Valores default para criação de pedido.
		$fieldsDefault = [
            "DocEntry"                => "",                              // Cria na hora do insert.
            "DocNum"                  => "",                              // Cria na hora do insert.
            "DocType"                 => "dDocument_Items",               // FIXO
            "DocDate"                 => "2023-04-25",                    // Data atual da criação da nota.
            "DocDueDate"              => "2024-02-01",                    // Vencimento do último pagametno.
            "CardCode"                => "43059665818C",                  // CPF + C
            "CardName"                => "THIAGO TESTE",
            "Comments"                => "Based On Sales Orders 26764",   // Comentário com o número do pedido no SAP. (não precisa)
            "PaymentMethod"           => "CARTÃO CREDITO",                // Analisar nova categoria de pagamento (Cartão recorrência, Boleto).
            "BPL_IDAssignedToInvoice" => 1,                               // Filial [1 jabaquara], [2 recife]
            "ReserveInvoice"          => "tYES",                          // fixo
            "SequenceCode"            => 89,                              // fixo
            "Cancelled"               => "tNO",                           // fixo
            "BPLId"                   => "1",                             // Filial [1 jabaquara], [2 recife]
            // "NumberOfInstallments"    => 10,                              // Verificar nome do campo de número de parcelas.
            "U_Matricula"             => "2225800006",   // RA do aluno (lyceum)
            "U_DATA_EXPIRACAO"        => "2999-12-31",   // fixo
            "U_RESP"                  => "6011232",      // Resp Lyceum (lyceum)
            "U_TIPO"                  => "LIV",          // Tipo do Curso
            "U_MODALIDADE"            => "FIX",          // Modalidade do Curso
            "U_CURRICULO"             => "GERAL",        // Fixo
            "U_PEDIDO_ORIGEM"         => null,           // fixo
            "U_PEDIDO_VENDA"          => 166478,         // Código do pedido loja.
            "DocumentLines"           => [               // Disciplinas do curso ou itens do pedido. (quanto mais itens, mais "num lines").
                [
                    "LineNum"   => 0,         // Identifica iten ou disciplina do pedido.
                    "BaseType"  => 17,        // Fixo - Pedido de venda
                    "BaseEntry" => "26765",   // Para vincular o pedido (docEntry) a essa nota fiscal. (Endpoint: Cadastrar pedido de venda)
                    "BaseLine"  => 0          // Identifica iten ou disciplina do pedido.
                ],
                [
                    "LineNum"   => 1,         // Identifica iten ou disciplina do pedido.
                    "BaseType"  => 17,        // Fixo - Pedido de venda
                    "BaseEntry" => "26765",   // Para vincular o pedido (docEntry) a essa nota fiscal. (Endpoint: Cadastrar pedido de venda)
                    "BaseLine"  => 1          // Identifica iten ou disciplina do pedido.
                ]
            ],
            "DocumentInstallments" => [
                [
                    "DueDate"       => "2023-05-01",   // Vencimento
                    // "Percentage"   : 10.0,             // Percentual do total do pedido opcional.
                    "Total"         => 1,              // Valor
                    "InstallmentId" => 3               // Identificação da parcela.
                ]
            ]
        ];
		
		// Junta e sobreescreve Default
		$fields = array_replace_recursive($fieldsDefault, $fields);


        //Opções para envio da requisição.
        $options = [
            // Endpoint.
            'url'     => $url,
            // Conteúdo.
            'data'     => $fields,
            // Método GET,POST,PUT,DELETE,etc.
            'method'  => 'POST',
            // Obtem os header
            'headers' => self::authHeaders(),
        ];

        // Envio a requisição de login para o SAP
        $r = \classes\HttpRequest::request($options);
        
        $r = json_decode($r, true);

        return $r;
    }

    
    /**
     * getNotaFutura
     * 
     * Retorna a nota futura por id da nota.
     *
     * @param  mixed $id
     * @return array|boolean
     */
    public static function getNotaFutura($id)
    {
        // Endpoint a ser chamado
        $endpoint = 'Invoices';
        
        // Monta o filtro com o código do cartão passado por parametro
        $filter = "($id)";

        // Monta a url com o filtro
        $url = self::$url . $endpoint . $filter;

        // Tenta realizar o login
        if (!self::login()) {
            return false;
        }

        //Opções para envio da requisição.
        $options = [
            // Endpoint.
            'url'     => $url,
            // Método GET,POST,PUT,DELETE,etc.
            'method'  => 'GET',
            // Obtem os header
            'headers' => self::authHeaders(),
        ];

        // Envio a requisição de login para o SAP
        $r = \classes\HttpRequest::request($options);
        
        $r = json_decode($r, true);

        return $r;
    }

    
    /**
     * getNotaFuturaPedido
     * 
     * Retorna a nota futura por número do pedido (docEntry).
     *
     * @param  mixed $docEntry
     * @return array|boolean
     */
    public static function getNotaFuturaPedido($docEntry)
    {
        // Endpoint a ser chamado
        $endpoint = 'Invoices?';

        // Monta o filtro com o código do cartão passado por parametro
        $filter = '$filter=' . "(U_PEDIDO_ORIGEM eq $docEntry and Cancelled eq 'tNO')";

        // Monta a url encodando os dados do filtro
        $url = self::$url . $endpoint . urlencode($filter);

        // Tenta realizar o login
        if (!self::login()) {
            return false;
        }

        //Opções para envio da requisição.
        $options = [
            // Endpoint.
            'url'     => $url,
            // Método GET,POST,PUT,DELETE,etc.
            'method'  => 'GET',
            // Obtem os header
            'headers' => self::authHeaders(),
        ];

        // Envio a requisição de login para o SAP
        $r = \classes\HttpRequest::request($options);
        
        $r = json_decode($r, true);

        return $r;
    }

    
    /**
     * postOrder
     * 
     * Cria um pedido.
     *
     * @param  mixed $docEntry
     * @return array|boolean
     */
    public static function postOrder($fields)
    {
        // Endpoint a ser chamado
        $endpoint = 'Orders';

        // Monta a url.
        $url = self::$url . $endpoint;

        // Tenta realizar o login
        if (!self::login()) {
            return false;
        }

        // Valores default para criação de pedido.
		$fieldsDefault = [
            "DocDate" => "20190724", 
            "DocDueDate" => "20220210", 
            "CardCode" => "06235971605C", 
            "DocTotal" => 0, 
            "Series" => 8, 
            "PaymentMethod" => "R", 
            "GroupNumber" => 69, 
            "Comments" => "", 
            "BPL_IDAssignedToInvoice" => 1, 
            "U_Matricula" => "1921400025", 
            "U_LycLancDebGroup" => null, 
            "U_LycBoeKey" => "CB-ITAU", 
            "U_BillingDate" => "", 
            "U_RESP" => "0059353", 
            "U_TIPO" => "POS", 
            "U_MODALIDADE" => "MON", 
            "U_CURRICULO" => "20192", 
            "U_DATA_EXPIRACAO" => null, 
            "DocumentLines" => [
                  [
                     "ItemCode" => "1000065816", 
                     "Quantity" => "10", 
                     "UnitPrice" => 2183.964, 
                     "DiscountPercent" => 79.89, 
                     "Usage" => "64", 
                     "U_INICIACAO" => "N", 
                     "U_LycLancDeb" => 186040, 
                     "U_NfLegado" => null, 
                     "U_NfValorLegado" => null, 
                     "U_NfDataLegado" => null 
                  ] 
               ] 
         ];
		
		// Junta e sobreescreve Default
		$fields = array_replace_recursive($fieldsDefault, $fields);


        //Opções para envio da requisição.
        $options = [
            // Endpoint.
            'url'     => $url,
            // Conteúdo.
            'data'     => $fields,
            // Método GET,POST,PUT,DELETE,etc.
            'method'  => 'POST',
            // Obtem os header
            'headers' => self::authHeaders(),
        ];

        // Envio a requisição de login para o SAP
        $r = \classes\HttpRequest::request($options);
        
        $r = json_decode($r, true);

        return $r;
    }

    
    /**
     * getOrder
     * 
     * Retorna o pedido buscado (docEntry).
     *
     * @param  mixed $docEntry
     * @return array|boolean
     */
    public static function getOrder($docEntry)
    {
        // Endpoint a ser chamado
        $endpoint = 'Orders';
        
        // Monta o filtro com o código do cartão passado por parametro
        $filter = "($docEntry)";

        // Monta a url com o filtro
        $url = self::$url . $endpoint . $filter;

        // Tenta realizar o login
        if (!self::login()) {
            return false;
        }

        //Opções para envio da requisição.
        $options = [
            // Endpoint.
            'url'     => $url,
            // Método GET,POST,PUT,DELETE,etc.
            'method'  => 'GET',
            // Obtem os header
            'headers' => self::authHeaders(),
        ];

        // Envio a requisição de login para o SAP
        $r = \classes\HttpRequest::request($options);
        
        $r = json_decode($r, true);

        return $r;
    }

    
    /**
     * getOrdersCardCode
     * 
     * Retorna o pedido buscado por cardcode (CPF).
     *
     * @param  mixed $docEntry
     * @return array|boolean
     */
    public static function getOrdersCardCode($cardCode)
    {
        // Endpoint a ser chamado
        $endpoint = 'Orders?';
        
        // Monta o filtro com o código do cliente passado por parametro
        $filter = '$select=DocEntry,DocNum,DocType,DocumentStatus&$filter=' . "CardCode eq '$cardCode'";

        // Monta a url com o filtro
        $url = self::$url . $endpoint . urlencode($filter);

        // Tenta realizar o login
        if (!self::login()) {
            return false;
        }

        //Opções para envio da requisição.
        $options = [
            // Endpoint.
            'url'     => $url,
            // Método GET,POST,PUT,DELETE,etc.
            'method'  => 'GET',
            // Obtem os header
            'headers' => self::authHeaders(),
        ];

        // Envio a requisição de login para o SAP
        $r = \classes\HttpRequest::request($options);
        
        $r = json_decode($r, true);

        return $r;
    }




    /*
    todo - VERIFICAR SE IRÁ USAR ESSAS FUNÇÕES ABAIXO. (Creio que não, pois tem que realizar muitos ajustes.)
    */
    /** 
     * @access public
     * @author Bruno Bessa Chaves
     * @internal Envia as baixa(s) da(s) parcela(s) do Contas a Receber no SAP
     * @param string $$PaymentMethod
     * @param array $PaymentInvoices
     * @param array $PaymentCreditCards
     * @param array $PaymentChecks
     * @param float $total_valor_pago
     * @param int $DocEntry_INV1_ODPI
     * @param array $dados_pedido
     */
    public static function enviar_baixas_parcelas_cr($PaymentMethod = null, $PaymentInvoices = null, $PaymentCreditCards = null, $PaymentChecks = null, $total_valor_pago = 0, $DocEntry_INV1_ODPI = null, $dados_pedido = null)
    {
        if ($PaymentInvoices != null || $PaymentCreditCards != null) {

            $link = 'IncomingPayments';
                
            if (!self::login()) {
                return false;
            }

            $data['DocDate'] = date('Y-m-d');
            $data['CardCode'] = $dados_pedido['CardCode'];
            $data['Series'] = 15;
            $data['BPLID'] = intval($dados_pedido['BPL_IDAssignedToInvoice']);

            switch ($PaymentMethod) {
                case 'CARTÃO CREDITO':

                    if ($total_valor_pago > 0) {

                        $data['TransferSum'] = $total_valor_pago;
                        $data['TransferAccount'] = '6.1.1.01.00007'; // saldo inicial de balanço
                    }

                    $data['ControlAccount'] = '6.1.1.01.00007';

                    break;

                case 'CHEQUE':

                    if ($total_valor_pago > 0) {

                        $data['TransferSum'] = $total_valor_pago;
                        $data['TransferAccount'] = '6.1.1.01.00007'; // saldo inicial de balanço
                    }

                    $data['CheckAccount'] = '6.1.1.01.00007';

                    break;

                default:

                    $data['TransferSum'] = $total_valor_pago;
                    $data['TransferAccount'] = '6.1.1.01.00007'; // saldo inicial de balanço

                    break;
            }

            if ($PaymentInvoices) {

                $data['PaymentInvoices'] = $PaymentInvoices;
            }

            if ($PaymentCreditCards) {

                $data['PaymentCreditCards'] = $PaymentCreditCards;
            }

            if ($PaymentChecks) {

                $data['PaymentChecks'] = $PaymentChecks;
            }
            \classes\DevHelper::printr($data);
            //echo json_encode($data);die;

            // $json = $this->sendRDHttp($link, $data, 'POST', null, self::$sessionId);

            //echo $json;die;

            // $retorno = json_decode($json, true);

            // return $retorno;
        } else {

            return false;
        }
    }

    /** 
     * @access public
     * @author Bruno Bessa Chaves
     * @internal Altera as baixa(s) da(s) parcela(s) do Contas a Receber no SAP
     * @param int $DocEntry_ODPI
     * @param string $PaymentMethod
     * @param array $PaymentInvoices
     * @param array $PaymentCreditCards
     * @param array $PaymentChecks
     * @param float $total_valor_pago
     * @param int $DocEntry_INV1_ODPI
     * @param array $dados_pedido
     */
    public static function alterar_baixas_parcelas_cr($DocEntry_ODPI = null, $PaymentMethod = null, $PaymentInvoices = null, $PaymentCreditCards = null, $PaymentChecks = null, $total_valor_pago = 0, $DocEntry_INV1_ODPI = null, $dados_pedido = null)
    {
        if ($PaymentInvoices != null || $PaymentCreditCards != null) {

            $link = "IncomingPayments(" . $DocEntry_ODPI . ")";

            if (!self::login()) {
                return false;
            }

            $data['DocNum'] = $DocEntry_ODPI;
            $data['DocEntry'] = $DocEntry_ODPI;
            //$data['DocDate']    = date('Y-m-d');
            //$data['CardCode']   = $dados_pedido['CardCode'];
            //$data['Series']     = 15;
            //$data['BPLID']      = intval($dados_pedido['BPL_IDAssignedToInvoice']);

            /*
            if ($total_valor_pago > 0) {
            $data['TransferSum']        = $total_valor_pago;
            $data['TransferAccount']    = '6.1.1.01.00007'; // saldo inicial de balanço
            }
            $data['ControlAccount'] = '6.1.1.01.00007';
            */

            if ($PaymentInvoices) {

                $data['PaymentInvoices'] = $PaymentInvoices;
            }

            if ($PaymentCreditCards) {

                $data['PaymentCreditCards'] = $PaymentCreditCards;
            }

            // it_Invoice é pagamento da NF Futura e it_DownPayment fatura de adiantamento
            echo json_encode($data);
            die;

            $json = $this->sendRDHttp($link, $data, 'PATCH', null, $loginAPI['SessionId']);

            echo $json;
            die;

            $retorno = json_decode($json, true);

            return $retorno;
        } else {

            return false;
        }
    }

}