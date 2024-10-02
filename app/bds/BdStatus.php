<?php

class BdStatus extends \controllers\DataBase
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
        parent::insert(['id' => 0, 'nome' => 'Inativo', 'obs' => 'Status Inativo Geral']); // 0
        parent::update(1,['id' => 0]);
        parent::insert(['id' => 1, 'nome' => 'Ativo', 'obs' => 'Status ativo Geral']); // 1

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
        parent::insert(['nome' => 'Profissional', 'obs' => 'Profissional. Uso da Organização.', 'statusGrupo' => 'contacts/idStatus']);
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


        // Finaliza a função.
        return $r;
    }
}
