<?php

class BdStatus2 extends \controllers\DataBase
{

    /**
     * Atribui a variavel tableName o valor do nome da tabela.
     * É usado em todas as funções para identificar qual a tabela das querys.
     *
     * @var string
     */
    protected $tableName = 'status';


    /**
     * Conexão padrão do banco de dados.
     * Verificar conexão na config.
     *
     * @var int
     */
    protected $conn = 0;


    /**
     * createTable
     * 
     * Cria tabela no banco de dados.
     * Função genérica para criação de tabelas conforme os parâmetros passados.
     * Preencha o nome da tabela.
     * Preencha o array $fields com "nome_campo" => "tipo_campo".
     * Cria se não existir.
     *
     * @param array $fields
     * @return bool
     */
    public function createTable($fields = null)
    {
        // Monta os campos da tabela.
        $fields = [
            // Identificador Padrão (obrigatório).
            "id" => "INT NOT NULL AUTO_INCREMENT primary key",

            // Informações do registro do tipo numérico.
            "nome"        => "VARCHAR(45) NULL",
            "statusGrupo" => "VARCHAR(90) NULL",   // Nome de um grupo de status para um determinado campo de outra tabela.
            "idStatusPai" => "INT NULL",



            // CRIADO AUTOMATICAMENTE
            // // Observações do registro (obrigatório)
            // "obs" => "VARCHAR(255) NULL",

            // // Controle padrão do registro (obrigató
            // "idStatus"      => "INT NULL",
            // "idLoginCreate" => "INT NULL",
            // "dtCreate"      => "DATETIME NULL",
            // "idLoginUpdate" => "INT NULL",
            // "dtUpdate"      => "DATETIME NULL",

        ];
        return parent::createTable($fields);
    }


    /**
     * dropTable
     * 
     * Deleta tabela no banco de dados.
     *
     * @return bool
     */
    public function dropTable()
    {
        // Deleta a tabela.
        return parent::dropTable();
    }


    /**
     * insert
     * 
     * Função genérica para inserts.
     * Preencha o nome da tabela.
     * Preencha o array $fields com "nome_campo" => "valor_campo".
     *
     * @param array $fields
     * @return int
     */
    public function insert($fields)
    {
        // Retorno da função insert préviamente definida. (true, false)
        return parent::insert($fields);
    }


    /**
     * update
     * 
     * Função genérica para update.
     * Preencha o nome da tabela.
     * Preencha o array com nome_campo => valor_campo somenta das colunas que vão ser alteradas.
     *
     * @param  mixed $id
     * @param  mixed $fields
     * @param  mixed $where
     * @return bool
     */
    public function update($id, $fields, $where = null)
    {
        // Retorno da função update préviamente definida. (true, false)
        return parent::update($id, $fields, $where);
    }


    /**
     * delete
     * 
     * Função que deleta registro por id ou where.
     * É necessário preencher um dos dois parâmetros.
     *
     * @param int $id
     * @param string $where
     * @return bool
     */
    public function delete($id = null, $where = null)
    {
        // Retorno da função delete préviamente definida. (true, false)
        return parent::delete($id, $where);
    }


    /**
     * deleteStatus
     * 
     * Função que deleta registro por status (0) id ou where.
     * É necessário preencher um dos dois parâmetros.
     *
     * @param int $id
     * @param string $where
     * @return bool
     */
    public function deleteStatus($id = null, $where = null)
    {
        // Retorno da função delete préviamente definida. (true, false)
        return parent::deleteStatus($id, $where);
    }


    /**
     * selecionarTudo
     * 
     * Função selecionar tudo, retorna todos os registros.
     * É possível passar a posição inicial que exibirá os registros.
     * É possível passar a quantidade de registros retornados.
     *
     * @param integer $posicao
     * @param integer $qtd
     * @return bool
     */
    public function selectAll($qtd = 10, $posicao = 0)
    {
        // Retorno da função selectAll préviamente definida. (true, false)
        return parent::selectAll($qtd, $posicao);
    }


    /**
     * selectById
     * 
     * Função que busca registro por id.
     * Retorna um array da linha.
     * Retorna um array com os campos da linha.
     * É necessário preencher um dos dois parâmetros.
     *
     * @param int $id
     * @param string $where
     * @return bool|array
     */
    public function selectById($id = null, $where = null)
    {
        // Função que busca registro por id.
        return parent::selectById($id, $where);
    }


    /**
     * count
     * 
     * Função genérica para retornar a quantidade de registros da tabela.
     *
     * @return int
     */
    public function count()
    {
        // Retorna a quantidade de registros na tabela.
        return parent::count();
    }


    /**
     * consultaPersonalizada
     * 
     * Modelo para criação de uma consulta personalizada.
     * É possível fazer inner joins e filtros personalizados.
     * User sempre que possível a função "select()" em vez de "executeQuery()".
     * ATENÇÃO: Não deixar brechas para SQL Injection.
     *
     * @param PDO $conn
     * @return bool|array
     */
    public function consultaPersonalizada($id)
    {
        // Ajusta nome real da tabela.
        $table = parent::fullTableName();
        // $tableInnerMidia = parent::fullTableName('midia');
        // $tableInnerLogin = parent::fullTableName('login');
        // $tableInnerUsers = parent::fullTableName('users');

        // Monta SQL.
        $sql = "SELECT * FROM $table WHERE id = '$id' LIMIT 1;";

        // Executa o select
        $r = parent::executeQuery($sql);

        // Verifica se não teve retorno.
        if (!$r)
            return false;

        // Retorna primeira linha.
        return $r[0];
    }


    /**
     * insertsIniciais
     * 
     * Realização dos inserts iniciais.
     *
     * @return bool|array
     */
    public function seeds()
    {
        // Retorno padrão.
        $r = true;


        /**
         * ****************** TABELA *
         * Select: Status
         * Qualquer id que não precisa de mais status além de ativo e inativo.
         */
        parent::insert(['nome' => 'Ativo', 'obs' => 'Status ativo Geral']); // 1
        parent::insert(['nome' => 'Inativo', 'obs' => 'Status Inativo Geral']); // 2

        /**
         * ****************** TABELA LOGINS
         * Select: Status
         */
        parent::insert(['nome' => 'Ativo', 'obs' => 'Login ativo.', 'statusGrupo' => 'login/idStatus']);
        parent::insert(['nome' => 'Inativo', 'obs' => 'Login inativo', 'statusGrupo' => 'login/idStatus']);

        /**
         * ****************** TABELA LOGINS
         * Select: Grupo
         */
        parent::insert(['nome' => 'Administradores', 'obs' => 'Grupo de Administradores.', 'statusGrupo' => 'login/idGrupo']);
        parent::insert(['nome' => 'Público', 'obs' => 'Grupo público para menus e informações genéricas.', 'statusGrupo' => 'login/idGrupo']);
        parent::insert(['nome' => 'Colaborador', 'obs' => 'Grupo geral para colaborador.', 'statusGrupo' => 'login/idGrupo']);
        parent::insert(['nome' => 'Ferramentas', 'obs' => 'Novo grupo para abrigar as ferramentas dos colaboradores.', 'statusGrupo' => 'login/idGrupo']);
        parent::insert(['nome' => 'TI', 'obs' => 'Grupo de TI.', 'statusGrupo' => 'login/idGrupo']);
        parent::insert(['nome' => 'RH', 'obs' => 'Grupo de RH.', 'statusGrupo' => 'login/idGrupo']);
        parent::insert(['nome' => 'Marketing', 'obs' => 'Grupo de Marketing.', 'statusGrupo' => 'login/idGrupo']);
        parent::insert(['nome' => 'Contabilidade', 'obs' => 'Grupo de Contabilidade.', 'statusGrupo' => 'login/idGrupo']);
        parent::insert(['nome' => 'Logística', 'obs' => 'Grupo da logística.', 'statusGrupo' => 'login/idGrupo']);
        parent::insert(['nome' => 'Coordenadores', 'obs' => 'Coordenadores de área', 'statusGrupo' => 'login/idGrupo']);
        parent::insert(['nome' => 'Gerentes', 'obs' => 'Gerentes', 'statusGrupo' => 'login/idGrupo']);

        /**
         * ****************** TABELA LOGINS
         * Select: Status Pontuação
         */
        // Campo: idStatusPontuacao
        parent::insert(['nome' => 'Bloqueado', 'obs' => 'Pontos bloqueados.', 'statusGrupo' => 'users/statusPontuacao']);
        parent::insert(['nome' => 'Liberado', 'obs' => 'Pontos liberara.', 'statusGrupo' => 'users/statusPontuacao']);

        /**
         * Tabela: Pages
         */
        // Campo: idStatus
        parent::insert(['nome' => 'Ativo', 'obs' => 'Status ativa.', 'statusGrupo' => 'pages/idStatus']);
        parent::insert(['nome' => 'Inativo', 'obs' => 'Status inativa', 'statusGrupo' => 'pages/idStatus']);

        /**
         * Tabela: PagesContent
         */
        // Campo: idStatus
        parent::insert(['nome' => 'Ativo', 'obs' => 'Status ativa.', 'statusGrupo' => 'pagesContent/idStatus']);
        parent::insert(['nome' => 'Inativo', 'obs' => 'Status inativa', 'statusGrupo' => 'pagesContent/idStatus']);

        /**
         * Tabela: Options
         */
        // Campo: idStatus
        parent::insert(['nome' => 'Ativo', 'obs' => 'Status ativa.', 'statusGrupo' => 'options/idStatus']);
        parent::insert(['nome' => 'Inativo', 'obs' => 'Status inativa', 'statusGrupo' => 'options/idStatus']);

        /**
         * Tabela: Permissões
         */
        // Campo: idStatus
        parent::insert(['nome' => 'Ativo', 'obs' => 'Status ativa.', 'statusGrupo' => 'permissions/idStatus']);
        parent::insert(['nome' => 'Inativo', 'obs' => 'Status inativa', 'statusGrupo' => 'permissions/idStatus']);



        /**
         * ****************** TABELA MIDIAS
         * Select: Status
         */
        parent::insert(['nome' => 'Ativo', 'obs' => 'Status ativo', 'statusGrupo' => 'midias/idStatus']); // 38
        parent::insert(['nome' => 'Inativo', 'obs' => 'Status Inativo', 'statusGrupo' => 'midias/idStatus']); // 39


        /**
         * ****************** TABELA ADRESSES
         * Select: status
         */
        parent::insert(['nome' => 'Ativo', 'obs' => 'Status ativo', 'statusGrupo' => 'adresses/idStatus']); // 40
        parent::insert(['nome' => 'Inativo', 'obs' => 'Status Inativo', 'statusGrupo' => 'adresses/idStatus']); // 41


        /**
         * ****************** TABELA ADRESSES
         * Select: Zona
         */
        parent::insert(['nome' => 'Urbana', 'obs' => 'Propriedade em zona urbana.', 'statusGrupo' => 'adresses/zona']);
        parent::insert(['nome' => 'Rual', 'obs' => 'Propriedade em zona rural.', 'statusGrupo' => 'adresses/zona']);


        /**
         * ****************** TABELA ADRESSES
         * Select: Logradouro
         * Ref.: http://suporte.quarta.com.br/LayOuts/eSocial/Tabelas/Tabela_20.htm
         */
        parent::insert(['nome' => 'R.', 'obs' => 'Rua.', 'statusGrupo' => 'adresses/logradouro']);
        parent::insert(['nome' => 'AV.', 'obs' => 'Avenida.', 'statusGrupo' => 'adresses/logradouro']);
        parent::insert(['nome' => 'AL.', 'obs' => 'Alameda.', 'statusGrupo' => 'adresses/logradouro']);
        parent::insert(['nome' => 'EST.', 'obs' => 'Estrada.', 'statusGrupo' => 'adresses/logradouro']);
        parent::insert(['nome' => 'ROD.', 'obs' => 'Rodovia.', 'statusGrupo' => 'adresses/logradouro']);
        parent::insert(['nome' => 'PC.', 'obs' => 'Praça.', 'statusGrupo' => 'adresses/logradouro']);


        /**
         * ****************** TABELA CONTACTS
         * Select: Status
         */
        parent::insert(['nome' => 'Ativo', 'obs' => 'Contato ativo', 'statusGrupo' => 'contacts/idStatus']);
        parent::insert(['nome' => 'Inativo', 'obs' => 'Contato Inativo', 'statusGrupo' => 'contacts/idStatus']);
        parent::insert(['nome' => 'Profissional', 'obs' => 'Profissional. Uso da Coopama.', 'statusGrupo' => 'contacts/idStatus']);
        parent::insert(['nome' => 'Pessoal', 'obs' => 'Pessoal. Acesso apenas RH.', 'statusGrupo' => 'contacts/idStatus']);
        parent::insert(['nome' => 'Contato', 'obs' => 'Contato de outra pessoa próxima. Acesso apenas RH.', 'statusGrupo' => 'contacts/idStatus']);

        /**
         * ****************** TABELA CONTACTS
         * Select: Tipo
         */
        parent::insert(['nome' => 'E-mail', 'obs' => 'E-mail geral.', 'statusGrupo' => 'contacts/tipo']);
        parent::insert(['nome' => 'Telefone', 'obs' => 'Telefone geral.', 'statusGrupo' => 'contacts/tipo']);
        parent::insert(['nome' => 'Telefone Fixo', 'obs' => 'Telefone Fixo', 'statusGrupo' => 'contacts/tipo']);
        parent::insert(['nome' => 'Telefone Fixo Whatsapp', 'obs' => 'Telefone fixo com whatsapp', 'statusGrupo' => 'contacts/tipo']);
        parent::insert(['nome' => 'Celular', 'obs' => 'Telefone Celular.', 'statusGrupo' => 'contacts/tipo']);
        parent::insert(['nome' => 'Celular Whatsapp', 'obs' => 'Telefone Celular com whatsapp.', 'statusGrupo' => 'contacts/tipo']);
        parent::insert(['nome' => 'Site', 'obs' => 'Site. Link.', 'statusGrupo' => 'contacts/tipo']);
        parent::insert(['nome' => 'URL', 'obs' => 'Endereço web geral. Link.', 'statusGrupo' => 'contacts/tipo']);
        parent::insert(['nome' => 'Instagram', 'obs' => 'Link completo. Instagram.', 'statusGrupo' => 'contacts/tipo']);
        parent::insert(['nome' => 'Facebook', 'obs' => 'Link completo. Facebook.', 'statusGrupo' => 'contacts/tipo']);
        parent::insert(['nome' => 'Linkedin', 'obs' => 'Link completo. Linkedin.', 'statusGrupo' => 'contacts/tipo']);
        parent::insert(['nome' => 'Youtube', 'obs' => 'Link completo. Youtube.', 'statusGrupo' => 'contacts/tipo']);
        parent::insert(['nome' => 'Skype', 'obs' => 'E-mail do Skype', 'statusGrupo' => 'contacts/tipo']);
        parent::insert(['nome' => 'Outro', 'obs' => 'Outra informação de contato.', 'statusGrupo' => 'contacts/tipo']);


        /**
         * ****************** TABELA DEPARTMENTS
         * Select: Status
         */
        parent::insert(['nome' => 'Ativo', 'obs' => 'Status ativo', 'statusGrupo' => 'departments/idStatus']);
        parent::insert(['nome' => 'Inativo', 'obs' => 'Status Inativo', 'statusGrupo' => 'departments/idStatus']);


        /**
         * ****************** TABELA QUALIFICATIONS
         * Select: Status
         */
        parent::insert(['nome' => 'Ativo', 'obs' => 'Status ativo', 'statusGrupo' => 'qualifications/idStatus']);
        parent::insert(['nome' => 'Inativo', 'obs' => 'Status Inativo', 'statusGrupo' => 'qualifications/idStatus']);


        /**
         * ****************** TABELA USERS
         * Select: Escolaridade
         */
        parent::insert(['nome' => 'Educação infantil', 'obs' => 'Educação infantil', 'statusGrupo' => 'users/escolaridade']);
        parent::insert(['nome' => 'Fundamental', 'obs' => 'Fundamental', 'statusGrupo' => 'users/escolaridade']);
        parent::insert(['nome' => 'Fundamental Incompleto', 'obs' => 'Fundamental Incompleto', 'statusGrupo' => 'users/escolaridade']);
        parent::insert(['nome' => 'Médio', 'obs' => 'Médio', 'statusGrupo' => 'users/escolaridade']);
        parent::insert(['nome' => 'Médio Incompleto', 'obs' => 'Médio Incompleto', 'statusGrupo' => 'users/escolaridade']);
        parent::insert(['nome' => 'Técnico', 'obs' => 'Técnico', 'statusGrupo' => 'users/escolaridade']);
        parent::insert(['nome' => 'Técnico Incompleto', 'obs' => 'Técnico Incompleto', 'statusGrupo' => 'users/escolaridade']);
        parent::insert(['nome' => 'Superior (Graduação)', 'obs' => 'Superior (Graduação)', 'statusGrupo' => 'users/escolaridade']);
        parent::insert(['nome' => 'Superior (Licenciatura)', 'obs' => 'Superior (Licenciatura)', 'statusGrupo' => 'users/escolaridade']);
        parent::insert(['nome' => 'Superior Incompleto', 'obs' => 'Superior Incompleto', 'statusGrupo' => 'users/escolaridade']);
        parent::insert(['nome' => 'Pós-graduação', 'obs' => 'Pós-graduação', 'statusGrupo' => 'users/escolaridade']);
        parent::insert(['nome' => 'Pós-graduação Incompleto', 'obs' => 'Pós-graduação Incompleto', 'statusGrupo' => 'users/escolaridade']);
        parent::insert(['nome' => 'Mestrado', 'obs' => 'Mestrado', 'statusGrupo' => 'users/escolaridade']);
        parent::insert(['nome' => 'Mestrado Incompleto', 'obs' => 'Mestrado Incompleto', 'statusGrupo' => 'users/escolaridade']);
        parent::insert(['nome' => 'Doutorado', 'obs' => 'Doutorado', 'statusGrupo' => 'users/escolaridade']);
        parent::insert(['nome' => 'Doutorado Incompleto', 'obs' => 'Doutorado Incompleto', 'statusGrupo' => 'users/escolaridade']);

        // Categoria CNH
        parent::insert(['nome' => 'ACC', 'obs' => 'Veículos ciclomotores de duas ou três rodas de até 50 cilindradas.', 'statusGrupo' => 'users/cnhCategoria']);
        parent::insert(['nome' => 'A', 'obs' => 'Motos', 'statusGrupo' => 'users/cnhCategoria']);
        parent::insert(['nome' => 'B', 'obs' => 'Carros e veículos de carga leve (até 3.500 kg ou 8 lugares para passageiros).', 'statusGrupo' => 'users/cnhCategoria']);
        parent::insert(['nome' => 'C', 'obs' => 'Caminhões pequenos e outros veículos de carga entre 3.500 e 6000 kgs de peso total).', 'statusGrupo' => 'users/cnhCategoria']);
        parent::insert(['nome' => 'D', 'obs' => 'Ônibus e microônibus com mais de 8 lugares para passageiros.', 'statusGrupo' => 'users/cnhCategoria']);
        parent::insert(['nome' => 'E', 'obs' => 'Todos os veículos das categorias B,C e D, além de veículos com reboque.', 'statusGrupo' => 'users/cnhCategoria']);
        parent::insert(['nome' => 'AB', 'obs' => 'Motos e Carros', 'statusGrupo' => 'users/cnhCategoria']);


        // Campo: tipoContrato
        parent::insert(['nome' => 'CLT', 'obs' => 'Contratação sob as leis trabalhistas.', 'statusGrupo' => 'users/tipoContrato']);
        parent::insert(['nome' => 'PJ', 'obs' => 'Contratação como pessoa jurídica.', 'statusGrupo' => 'users/tipoContrato']);
        parent::insert(['nome' => 'Temporário', 'obs' => 'Contratação temporária para volume extra ou transição.', 'statusGrupo' => 'users/tipoContrato']);
        parent::insert(['nome' => 'Parcial', 'obs' => 'Contratação até 25 horas semanais.', 'statusGrupo' => 'users/tipoContrato']);
        parent::insert(['nome' => 'Estágio', 'obs' => 'Contratação com vínculo acadêmico.', 'statusGrupo' => 'users/tipoContrato']);
        parent::insert(['nome' => 'Jovem Aprendiz', 'obs' => 'Contratação de 4 a 6 horas por dia.', 'statusGrupo' => 'users/tipoContrato']);
        parent::insert(['nome' => 'Terceirização', 'obs' => 'Contratação onde empresa terceira realiza toda a responsabilidade.', 'statusGrupo' => 'users/tipoContrato']);
        parent::insert(['nome' => 'Home office', 'obs' => 'Contratação onde as regras são firmadas em acordo individual entre colaborador e empresa.', 'statusGrupo' => 'users/tipoContrato']);
        parent::insert(['nome' => 'Intermitente', 'obs' => 'Contratação onde os trabalhadores recebem por jornada ou hora de serviço.', 'statusGrupo' => 'users/tipoContrato']);
        parent::insert(['nome' => 'Autônomo', 'obs' => 'Contratação onde trabalhador também pode ser considerado um freelancer, mas é contratado como pessoa física e não jurídica.', 'statusGrupo' => 'users/tipoContrato']);


        /**
         * Tabela: messages
         */
        // Campo: finalidade
        parent::insert(['nome' => 'Geral', 'obs' => 'Finalidade Geral', 'statusGrupo' => 'messages/finalidade']);


        /**
         * Tabela: notifications
         */
        // Campo: destination
        parent::insert(['nome' => 'Departamento', 'obs' => 'Notificação para um departamento.', 'statusGrupo' => 'notifications/destination']);
        parent::insert(['nome' => 'Usuário', 'obs' => 'Notificação para um usuário específico.', 'statusGrupo' => 'notifications/destination']);


        /**
         * Tabela: Mídias
         * Acrescentando valores.
         */
        // Campo: idStatus
        // Registro: 342
        parent::insert(['nome' => 'Material de Marketing disponível', 'obs' => 'Material de marketing e publicidade distribuido para colaboradores usarem. Objetivo de padronizar e usar a marca.', 'statusGrupo' => 'midias/idStatus']);
        // Registro: 343
        parent::insert(['nome' => 'Material de Marketing indisponível', 'obs' => 'Material de marketing indisponível.', 'statusGrupo' => 'midias/idStatus']);




        /**
         * OUTROS
         */
        // Registro: 345
        parent::insert(['nome' => 'POP disponível', 'obs' => 'Documento disponível.', 'statusGrupo' => 'midias/idStatus']);
        // Registro: 346
        parent::insert(['nome' => 'POP indisponível', 'obs' => 'Documento indisponível.', 'statusGrupo' => 'midias/idStatus']);
        // Registro: 348
        parent::insert(['nome' => 'Principal', 'obs' => 'Endereço principal.', 'statusGrupo' => 'adresses/idTipo']);
        // Registro: 349
        parent::insert(['nome' => 'Correspondência', 'obs' => 'Endereço para recebimento de correspondências.', 'statusGrupo' => 'adresses/idTipo']);
        // Registro: 350
        parent::insert(['nome' => 'Cobrança', 'obs' => 'Endereço para realização de cobrança.', 'statusGrupo' => 'adresses/idTipo']);
        // Registro: 351
        parent::insert(['nome' => 'Secundário', 'obs' => 'Endereço de familiar, vizinho, empresa, etc.', 'statusGrupo' => 'adresses/idTipo']);
        // Registro: 352
        parent::insert(['nome' => 'Outro', 'obs' => 'Endereço com especificação no campo OBS.', 'statusGrupo' => 'adresses/idTipo']);
        // Registro: 353
        parent::insert(['nome' => 'Solteiro', 'obs' => 'Estado Civil Solteiro.', 'statusGrupo' => 'users/estadoCivil']);
        // Registro: 354
        parent::insert(['nome' => 'Casado', 'obs' => 'Estado Civil Casado.', 'statusGrupo' => 'users/estadoCivil']);
        // Registro: 355
        parent::insert(['nome' => 'Divorciado', 'obs' => 'Estado Civil Divorciado.', 'statusGrupo' => 'users/estadoCivil']);
        // Registro: 356
        parent::insert(['nome' => 'Viúvo', 'obs' => 'Estado Civil Viúvo.', 'statusGrupo' => 'users/estadoCivil']);

        // CNH
        parent::insert(['nome' => 'AC', 'obs' => 'Motos e Carros.', 'statusGrupo' => 'users/cnhCategoria']);
        parent::insert(['nome' => 'AD', 'obs' => 'Motos e Caminhões.', 'statusGrupo' => 'users/cnhCategoria']);
        parent::insert(['nome' => 'AE', 'obs' => 'Motos e Todos os veículos.', 'statusGrupo' => 'users/cnhCategoria']);

        // Status Geral Excluido
        // Registro: 360
        parent::insert(['nome' => 'Deletado', 'obs' => 'Registro está excluido digitalmente.', 'statusGrupo' => '']);


        // Adress campo país
        parent::insert(['nome' => 'Afeganistão', 'obs' => 'Afeganistão - Cabul - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'África do Sul', 'obs' => 'África do Sul - Pretória - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Albânia', 'obs' => 'Albânia - Tirana - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Alemanha', 'obs' => 'Alemanha - Berlim - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Andorra', 'obs' => 'Andorra - Andorra-a-Velha - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Angola', 'obs' => 'Angola - Luanda - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Antiga e Barbuda', 'obs' => 'Antiga e Barbuda - São João - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Arábia Saudita', 'obs' => 'Arábia Saudita - Riade - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Argélia', 'obs' => 'Argélia - Argel - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Argentina', 'obs' => 'Argentina - Buenos Aires - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Arménia', 'obs' => 'Arménia - Erevã - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Austrália', 'obs' => 'Austrália - Camberra - Oceania', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Áustria', 'obs' => 'Áustria - Viena - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Azerbaijão', 'obs' => 'Azerbaijão - Bacu - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Bahamas', 'obs' => 'Bahamas - Nassau - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Bangladexe', 'obs' => 'Bangladexe - Daca - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Barbados', 'obs' => 'Barbados - Bridgetown - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Barém', 'obs' => 'Barém - Manama - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Bélgica', 'obs' => 'Bélgica - Bruxelas - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Belize', 'obs' => 'Belize - Belmopã - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Benim', 'obs' => 'Benim - Porto Novo - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Bielorrússia', 'obs' => 'Bielorrússia - Minsque - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Bolívia', 'obs' => 'Bolívia - Sucre - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Bósnia e Herzegovina', 'obs' => 'Bósnia e Herzegovina - Saraievo - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Botsuana', 'obs' => 'Botsuana - Gaborone - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Brasil', 'obs' => 'Brasil - Brasília - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Brunei', 'obs' => 'Brunei - Bandar Seri Begauã - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Bulgária', 'obs' => 'Bulgária - Sófia - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Burquina Faso', 'obs' => 'Burquina Faso - Uagadugu - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Burúndi', 'obs' => 'Burúndi - Bujumbura - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Butão', 'obs' => 'Butão - Timbu - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Cabo Verde', 'obs' => 'Cabo Verde - Praia - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Camarões', 'obs' => 'Camarões - Iaundé - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Camboja', 'obs' => 'Camboja - Pnom Pene - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Canadá', 'obs' => 'Canadá - Otava - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Catar', 'obs' => 'Catar - Doa - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Cazaquistão', 'obs' => 'Cazaquistão - Astana - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Chade', 'obs' => 'Chade - Jamena - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Chile', 'obs' => 'Chile - Santiago - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'China', 'obs' => 'China - Pequim - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Chipre', 'obs' => 'Chipre - Nicósia - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Colômbia', 'obs' => 'Colômbia - Bogotá - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Comores', 'obs' => 'Comores - Moroni - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Congo-Brazzaville', 'obs' => 'Congo-Brazzaville - Brazavile - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Coreia do Norte', 'obs' => 'Coreia do Norte - Pionguiangue - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Coreia do Sul', 'obs' => 'Coreia do Sul - Seul - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Cosovo', 'obs' => 'Cosovo - Pristina - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Costa do Marfim', 'obs' => 'Costa do Marfim - Iamussucro - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Costa Rica', 'obs' => 'Costa Rica - São José - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Croácia', 'obs' => 'Croácia - Zagrebe - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Cuaite', 'obs' => 'Cuaite - Cidade do Cuaite - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Cuba', 'obs' => 'Cuba - Havana - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Dinamarca', 'obs' => 'Dinamarca - Copenhaga - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Dominica', 'obs' => 'Dominica - Roseau - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Egito', 'obs' => 'Egito - Cairo - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Emirados Árabes Unidos', 'obs' => 'Emirados Árabes Unidos - Abu Dabi - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Equador', 'obs' => 'Equador - Quito - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Eritreia', 'obs' => 'Eritreia - Asmara - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Eslováquia', 'obs' => 'Eslováquia - Bratislava - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Eslovénia', 'obs' => 'Eslovénia - Liubliana - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Espanha', 'obs' => 'Espanha - Madrid - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Essuatíni', 'obs' => 'Essuatíni - Lobamba - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Estado da Palestina', 'obs' => 'Estado da Palestina - Jerusalém Oriental - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Estados Unidos', 'obs' => 'Estados Unidos - Washington, D.C. - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Estónia', 'obs' => 'Estónia - Talim - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Etiópia', 'obs' => 'Etiópia - Adis Abeba - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Fiji', 'obs' => 'Fiji - Suva - Oceania', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Filipinas', 'obs' => 'Filipinas - Manila - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Finlândia', 'obs' => 'Finlândia - Helsínquia - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'França', 'obs' => 'França - Paris - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Gabão', 'obs' => 'Gabão - Libreville - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Gâmbia', 'obs' => 'Gâmbia - Banjul - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Gana', 'obs' => 'Gana - Acra - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Geórgia', 'obs' => 'Geórgia - Tebilíssi - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Granada', 'obs' => 'Granada - São Jorge - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Grécia', 'obs' => 'Grécia - Atenas - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Guatemala', 'obs' => 'Guatemala - Cidade da Guatemala - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Guiana', 'obs' => 'Guiana - Georgetown - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Guiné', 'obs' => 'Guiné - Conacri - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Guiné Equatorial', 'obs' => 'Guiné Equatorial - Malabo - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Guiné-Bissau', 'obs' => 'Guiné-Bissau - Bissau - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Haiti', 'obs' => 'Haiti - Porto Príncipe - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Honduras', 'obs' => 'Honduras - Tegucigalpa - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Hungria', 'obs' => 'Hungria - Budapeste - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Iémen', 'obs' => 'Iémen - Saná - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Ilhas Marechal', 'obs' => 'Ilhas Marechal - Majuro - Oceania', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Índia', 'obs' => 'Índia - Nova Déli - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Indonésia', 'obs' => 'Indonésia - Jacarta - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Irão', 'obs' => 'Irão - Teerão - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Iraque', 'obs' => 'Iraque - Bagdade - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Irlanda', 'obs' => 'Irlanda - Dublim - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Islândia', 'obs' => 'Islândia - Reiquiavique - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Israel', 'obs' => 'Israel - Jerusalém - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Itália', 'obs' => 'Itália - Roma - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Jamaica', 'obs' => 'Jamaica - Kingston - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Japão', 'obs' => 'Japão - Tóquio - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Jibuti', 'obs' => 'Jibuti - Jibuti - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Jordânia', 'obs' => 'Jordânia - Amã - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Laus', 'obs' => 'Laus - Vienciana - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Lesoto', 'obs' => 'Lesoto - Maseru - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Letónia', 'obs' => 'Letónia - Riga - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Líbano', 'obs' => 'Líbano - Beirute - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Libéria', 'obs' => 'Libéria - Monróvia - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Líbia', 'obs' => 'Líbia - Trípoli - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Listenstaine', 'obs' => 'Listenstaine - Vaduz - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Lituânia', 'obs' => 'Lituânia - Vílnius - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Luxemburgo', 'obs' => 'Luxemburgo - Luxemburgo - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Macedónia do Norte', 'obs' => 'Macedónia do Norte - Escópia - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Madagáscar', 'obs' => 'Madagáscar - Antananarivo - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Malásia', 'obs' => 'Malásia - Cuala Lumpur - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Maláui', 'obs' => 'Maláui - Lilôngue - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Maldivas', 'obs' => 'Maldivas - Malé - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Mali', 'obs' => 'Mali - Bamaco - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Malta', 'obs' => 'Malta - Valeta - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Marrocos', 'obs' => 'Marrocos - Rebate - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Maurícia', 'obs' => 'Maurícia - Porto Luís - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Mauritânia', 'obs' => 'Mauritânia - Nuaquechote - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'México', 'obs' => 'México - Cidade do México - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Mianmar', 'obs' => 'Mianmar - Nepiedó - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Micronésia', 'obs' => 'Micronésia - Paliquir - Oceania', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Moçambique', 'obs' => 'Moçambique - Maputo - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Moldávia', 'obs' => 'Moldávia - Quixinau - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Mónaco', 'obs' => 'Mónaco - Mónaco - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Mongólia', 'obs' => 'Mongólia - Ulã Bator - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Montenegro', 'obs' => 'Montenegro - Podgoritsa - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Namíbia', 'obs' => 'Namíbia - Vinduque - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Nauru', 'obs' => 'Nauru - Iarém - Oceania', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Nepal', 'obs' => 'Nepal - Catmandu - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Nicarágua', 'obs' => 'Nicarágua - Manágua - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Níger', 'obs' => 'Níger - Niamei - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Nigéria', 'obs' => 'Nigéria - Abuja - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Noruega', 'obs' => 'Noruega - Oslo - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Nova Zelândia', 'obs' => 'Nova Zelândia - Wellington - Oceania', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Omã', 'obs' => 'Omã - Mascate - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Países Baixos', 'obs' => 'Países Baixos - Amesterdão - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Palau', 'obs' => 'Palau - Ngerulmud - Oceania', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Panamá', 'obs' => 'Panamá - Cidade do Panamá - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Papua Nova Guiné', 'obs' => 'Papua Nova Guiné - Porto Moresby - Oceania', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Paquistão', 'obs' => 'Paquistão - Islamabade - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Paraguai', 'obs' => 'Paraguai - Assunção - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Peru', 'obs' => 'Peru - Lima - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Polónia', 'obs' => 'Polónia - Varsóvia - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Portugal', 'obs' => 'Portugal - Lisboa - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Quénia', 'obs' => 'Quénia - Nairóbi - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Quirguistão', 'obs' => 'Quirguistão - Bisqueque - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Quiribáti', 'obs' => 'Quiribáti - Taraua do Sul - Oceania', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Reino Unido', 'obs' => 'Reino Unido - Londres - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'República Centro-Africana', 'obs' => 'República Centro-Africana - Bangui - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'República Checa', 'obs' => 'República Checa - Praga - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'República Democrática do Congo', 'obs' => 'República Democrática do Congo - Quinxassa - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'República Dominicana', 'obs' => 'República Dominicana - São Domingos - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Roménia', 'obs' => 'Roménia - Bucareste - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Ruanda', 'obs' => 'Ruanda - Quigali - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Rússia', 'obs' => 'Rússia - Moscovo - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Salomão', 'obs' => 'Salomão - Honiara - Oceania', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Salvador', 'obs' => 'Salvador - São Salvador - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Samoa', 'obs' => 'Samoa - Apia - Oceania', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Santa Lúcia', 'obs' => 'Santa Lúcia - Castries - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'São Cristóvão e Neves', 'obs' => 'São Cristóvão e Neves - Basseterre - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'São Marinho', 'obs' => 'São Marinho - São Marinho - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'São Tomé e Príncipe', 'obs' => 'São Tomé e Príncipe - São Tomé - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'São Vicente e Granadinas', 'obs' => 'São Vicente e Granadinas - Kingstown - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Seicheles', 'obs' => 'Seicheles - Vitória - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Senegal', 'obs' => 'Senegal - Dacar - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Serra Leoa', 'obs' => 'Serra Leoa - Freetown - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Sérvia', 'obs' => 'Sérvia - Belgrado - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Singapura', 'obs' => 'Singapura - Singapura - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Síria', 'obs' => 'Síria - Damasco - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Somália', 'obs' => 'Somália - Mogadíscio - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Sri Lanca', 'obs' => 'Sri Lanca - Sri Jaiavardenapura-Cota - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Sudão', 'obs' => 'Sudão - Cartum - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Sudão do Sul', 'obs' => 'Sudão do Sul - Juba - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Suécia', 'obs' => 'Suécia - Estocolmo - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Suíça', 'obs' => 'Suíça - Berna - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Suriname', 'obs' => 'Suriname - Paramaribo - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Tailândia', 'obs' => 'Tailândia - Banguecoque - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Taiuã', 'obs' => 'Taiuã - Taipé - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Tajiquistão', 'obs' => 'Tajiquistão - Duchambé - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Tanzânia', 'obs' => 'Tanzânia - Dodoma - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Timor-Leste', 'obs' => 'Timor-Leste - Díli - Oceania', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Togo', 'obs' => 'Togo - Lomé - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Tonga', 'obs' => 'Tonga - Nucualofa - Oceania', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Trindade e Tobago', 'obs' => 'Trindade e Tobago - Porto de Espanha - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Tunísia', 'obs' => 'Tunísia - Tunes - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Turcomenistão', 'obs' => 'Turcomenistão - Asgabate - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Turquia', 'obs' => 'Turquia - Ancara - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Tuvalu', 'obs' => 'Tuvalu - Funafuti - Oceania', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Ucrânia', 'obs' => 'Ucrânia - Quieve - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Uganda', 'obs' => 'Uganda - Campala - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Uruguai', 'obs' => 'Uruguai - Montevideu - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Usbequistão', 'obs' => 'Usbequistão - Tasquente - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Vanuatu', 'obs' => 'Vanuatu - Porto Vila - Oceania', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Vaticano', 'obs' => 'Vaticano - Vaticano - Europa', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Venezuela', 'obs' => 'Venezuela - Caracas - América', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Vietname', 'obs' => 'Vietname - Hanói - Ásia', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Zâmbia', 'obs' => 'Zâmbia - Lusaca - África', 'statusGrupo' => 'adresses/pais']);
        parent::insert(['nome' => 'Zimbábue', 'obs' => 'Zimbábue - Harare - África', 'statusGrupo' => 'adresses/pais']);


        // Adress campo uf
        parent::insert(['nome' => 'AC', 'obs' => 'Estado: Acre. Capital: Rio Branco. Km2: 152581', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'AL', 'obs' => 'Estado: Alagoas. Capital: Maceió. Km2: 27767', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'AP', 'obs' => 'Estado: Amapá. Capital: Macapá. Km2: 142814', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'AM', 'obs' => 'Estado: Amazonas. Capital: Manaus. Km2: 1570745', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'BA', 'obs' => 'Estado: Bahia. Capital: Salvador. Km2: 564692', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'CE', 'obs' => 'Estado: Ceará. Capital: Fortaleza. Km2: 148825', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'DF', 'obs' => 'Estado: Distrito Federal. Capital: Brasília. Km2: 5822', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'ES', 'obs' => 'Estado: Espírito Santo. Capital: Vitória. Km2: 46077', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'GO', 'obs' => 'Estado: Goiás. Capital: Goiânia. Km2: 340086', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'MA', 'obs' => 'Estado: Maranhão. Capital: São Luís. Km2: 331983', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'MT', 'obs' => 'Estado: Mato Grosso. Capital: Cuiabá. Km2: 903357', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'MS', 'obs' => 'Estado: Mato Grosso do Sul. Capital: Campo Grande. Km2: 357125', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'MG', 'obs' => 'Estado: Minas Gerais. Capital: Belo Horizonte. Km2: 586528', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'PA', 'obs' => 'Estado: Pará. Capital: Belém. Km2: 1247689', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'PB', 'obs' => 'Estado: Paraíba. Capital: João Pessoa. Km2: 56439', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'PR', 'obs' => 'Estado: Paraná. Capital: Curitiba. Km2: 199314', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'PE', 'obs' => 'Estado: Pernambuco. Capital: Recife. Km2: 98311', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'PI', 'obs' => 'Estado: Piauí. Capital: Teresina. Km2: 251529', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'RJ', 'obs' => 'Estado: Rio de Janeiro. Capital: Rio de Janeiro. Km2: 43696', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'RN', 'obs' => 'Estado: Rio Grande do Norte. Capital: Natal. Km2: 52796', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'RS', 'obs' => 'Estado: Rio Grande do Sul. Capital: Porto Alegre. Km2: 281748', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'RO', 'obs' => 'Estado: Rondônia. Capital: Porto Velho. Km2: 237576', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'RR', 'obs' => 'Estado: Roraima. Capital: Boa Vista. Km2: 224299', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'SC', 'obs' => 'Estado: Santa Catarina. Capital: Florianópolis. Km2: 95346', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'SP', 'obs' => 'Estado: São Paulo. Capital: São Paulo. Km2: 248209', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'SE', 'obs' => 'Estado: Sergipe. Capital: Aracaju. Km2: 21910', 'statusGrupo' => 'adresses/uf']);
        parent::insert(['nome' => 'TO', 'obs' => 'Estado: Tocantins. Capital: Palmas. Km2: 277620', 'statusGrupo' => 'adresses/uf']);


        // Finaliza a função.
        return $r;
    }
}
