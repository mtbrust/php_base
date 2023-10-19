<?php

namespace controllers;

/**
 * DataBase
 * 
 * Classe responsável por administrar as conexões definidas na config.php
 */
class DataBase
{


	/**
	 * Guarda um array de conexões com o banco de dados.
	 */
	private static $conns = []; // Guarda apenas conexão.

	/**
	 * Guarda último sql executado.
	 */
	public static $sql = ''; // Guarda apenas conexão.



	/**
	 * Atribui a variavel tableName o valor do nome da tabela.
	 * Definido na classe herdada.
	 * É usado em todas as funções para identificar qual a tabela das querys.
	 *
	 * @var string
	 */
	protected $tableName = 'modelo';


	/**
	 * Conexão padrão do banco de dados.
	 * Definido na classe herdada.
	 * Verificar conexão na config.
	 *
	 * @var int
	 */
	protected $conn = 0;



	/**
	 * getConn
	 * 
	 * Retorna os dados da conexão escolhida e já realiza a conexão.
	 * As informações de conexão estão em config.php
	 *
	 * @return mixed
	 */
	protected static function getConn($conn)
	{
		// Condições para interromper processo.
		// 1 - Não existir dados de conexão.
		// 2 - Não estiver ativo.
		if (!isset(BASE_BDS[$conn]) || !BASE_BDS[$conn]['ACTIVE']) {
			return false;
		}

		// Verifica se já existe conexão criada
		if (isset(self::$conns[$conn])) {
			return self::$conns[$conn];
		}

		// Retorno padrão.
		$pdo_conn = false;

		// Tenta realizar a conexão com a conn atual.
		try {

			// Monta string de conexão PDO de acordo com DB Manager.
			switch (BASE_BDS[$conn]['DBMANAGER']) {

				case 'mysql':
				case 'mariadb':
					$stringConnection = "mysql:host=" . BASE_BDS[$conn]['HOST'] . ';port=' . BASE_BDS[$conn]['PORT'] . ';dbname=' . BASE_BDS[$conn]['DATABASE'] . ';charset=' . BASE_BDS[$conn]['CHARSET'];
					break;

				case 'sqlserver':
					$stringConnection = '';
					// FeedBack
					\classes\FeedBackMessagens::add('danger', 'Erro.', 'Db Manager [' . BASE_BDS[$conn]['DBMANAGER'] . '] não implementado.');
					break;

				case 'firebase':
					$stringConnection = '';
					// FeedBack
					\classes\FeedBackMessagens::add('danger', 'Erro.', 'Db Manager [' . BASE_BDS[$conn]['DBMANAGER'] . '] não implementado.');
					break;

				case 'postgres':
					$stringConnection = '';
					// FeedBack
					\classes\FeedBackMessagens::add('danger', 'Erro.', 'Db Manager [' . BASE_BDS[$conn]['DBMANAGER'] . '] não implementado.');
					break;

				default:
					$stringConnection = '';
					// Finaliza conexão caso não identifique DBManager.
					return false;
			}

			// Cria objeto de conexão via PDO.
			$pdo_conn = new \PDO($stringConnection, BASE_BDS[$conn]['USERNAME'], BASE_BDS[$conn]['PASSWORD']);
			// Oculta erros de conexão.
			$pdo_conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_SILENT);

			// Guarda objeto de conexão no parâmetro conn.
			self::$conns[$conn] = $pdo_conn;
		} catch (\PDOException $error) {
			// Caso não consiga realizar a conexão, salva mensagem de erro.
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível conectar com [' . BASE_BDS[$conn]['DBMANAGER'] . ']. Conexão: ' . BASE_BDS[$conn]['TITLE'] . $error->getMessage());
		}

		// Retorna conexão.
		return $pdo_conn;
	}


	/**
	 * Retorna o nome completo da tabela.
	 * Prefixo + Nome da tabela.
	 *
	 * @return string
	 */
	public function fullTableName($tableName = null)
	{
		// Verifica se não tem dados de conexão ou conexão inativa e finaliza.
		if (!isset(BASE_BDS[$this->conn]) || !BASE_BDS[$this->conn]['ACTIVE']) {
			// FeedBack
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível obter dados da conexão [<b>' . $this->conn . '</b>].');
			return false;
		}

		// Se não for passado o nome da tabela. pega do objeto.
		if (!$tableName) {
			$tableName = $this->tableName;
		}

		// Retorna o prefixo da tabela na conexão selecionada.
		return BASE_BDS[$this->conn]['PREFIX'] . $tableName;
	}


	/**
	 * Retorna todas as tabelas ou a solicitada.
	 * [$this->tableName] já acrescenta o prefixo. Basta colocar o nome final da tabela.
	 *
	 * @param string $tableName
	 * @return bool|array
	 */
	public function getTables($tableName = '')
	{
		// Verifica se não tem dados de conexão ou conexão inativa e finaliza.
		if (!isset(BASE_BDS[$this->conn]) || !BASE_BDS[$this->conn]['ACTIVE']) {
			// FeedBack
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível obter dados da conexão [<b>' . $this->conn . '</b>].');
			return false;
		}

		// $this->conn agora é o objeto de conexão.
		$pdo = self::getConn($this->conn);

		// Caso passe o nome da tabela, filtra por essa tabela.
		if ($tableName)
			$tableName =  "WHERE Tables_in_" . BASE_BDS[$this->conn]['DBNAME'] . " LIKE '" . BASE_BDS[$this->conn]['PREFIX'] . "$tableName'";

		// Monta a Sql com filtro ou sem nada.
		$sql = "SHOW TABLES $tableName";

		// Guarda SQL gerado.
		self::$sql = $sql;

		// Executa a query e retorna um PDO Object.
		$result = $pdo->query($sql, \PDO::FETCH_ASSOC);

		// Retorna um array associativo dos valores.
		return $result->fetchAll();
	}


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
	public function createTable($fields)
	{
		// Verifica se não tem dados de conexão ou conexão inativa e finaliza.
		if (!isset(BASE_BDS[$this->conn]) || !BASE_BDS[$this->conn]['ACTIVE']) {
			// FeedBack
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível obter dados da conexão [<b>' . $this->conn . '</b>].');
			return false;
		}

		// $this->conn agora é o objeto de conexão.
		$pdo = self::getConn($this->conn);

		// Acrescenta valores default caso não exista.
		$fields = array_merge($this->acrescentaCamposObrigatorios(), $fields);

		// Guarda o código sql dos campos.
		$sql_fields = '';

		// Junta e trata os campos e tipos.
		foreach ($fields as $key => $value) {
			$sql_fields .= ',' . $key . ' ' . $value;
		}
		// Ajusta texto.
		$sql_fields[0] = ' ';

		// Constrói SQL tipo (MYSQL).
		$sql = "CREATE TABLE IF NOT EXISTS " . BASE_BDS[$this->conn]['PREFIX'] . "$this->tableName (";
		$sql .= $sql_fields;
		$sql .= ") engine=InnoDB default charset " . BASE_BDS[$this->conn]['CHARSET'] . ";";

		// Guarda SQL gerado.
		self::$sql = $sql;

		// Executa query de criação.
		if (!$pdo->query($sql, \PDO::FETCH_ASSOC)) {
			// FeedBack
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível criar a tabela. ' . print_r($pdo->errorInfo(), true));
			return false;
		}

		// LOG Das ações na plataforma.
		$obs = 'Classe: ' . get_called_class() . ' Função ' . __FUNCTION__ . '.';
		$type = 'CREATE TABLE';
		$this->gravaLog($obs, $type, $sql);

		// FeedBack
		\classes\FeedBackMessagens::add('success', 'Sucesso.', 'Tabela criada com sucesso. Tabela [<b>' . $this->tableName . '</b>].');

		return true;
	}


	/**
	 * dropTable
	 * 
	 * Função genérica para deletar tabela.
	 *
	 * @return bool
	 */
	public function dropTable()
	{
		// Verifica se não tem dados de conexão ou conexão inativa e finaliza.
		if (!isset(BASE_BDS[$this->conn]) || !BASE_BDS[$this->conn]['ACTIVE']) {
			// FeedBack
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível obter dados da conexão [<b>' . $this->conn . '</b>].');
			return false;
		}

		// $this->conn agora é o objeto de conexão.
		$pdo = self::getConn($this->conn);

		// Constrói sql.
		$sql = "DROP TABLE IF EXISTS " . BASE_BDS[$this->conn]['PREFIX'] . $this->tableName;

		// Guarda SQL gerado.
		self::$sql = $sql;

		// Prepara a Query.
		$sth = $pdo->prepare($sql);

		// Executa query de criação.
		if (!$sth->execute()) {
			// FeedBack
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível deletar tabela [<b>' . $this->conn . '</b>].');
			return false;
		}

		// LOG Das ações na plataforma.
		$obs = 'Classe: ' . get_called_class() . ' Função ' . __FUNCTION__ . '.';
		$type = 'DROP TABLE';
		$this->gravaLog($obs, $type, $sql);

		// FeedBack
		\classes\FeedBackMessagens::add('success', 'Sucesso.', 'Tabela deletada com sucesso. Tabela [<b>' . $this->tableName . '</b>].');

		// Caso ocorra tudo corretamente.
		return true;
	}


	/**
	 * Fecha as conexões.
	 */
	public function close()
	{
		// Verifica se não foi aberta conexões.
		if (!self::$conns) {
			return true;
		}

		// Finaliza todas as conexões criadas.
		foreach (self::$conns as $key => $value) {
			$value->query('KILL CONNECTION_ID()');
		}
	}


	/**
	 * Função genérica para selecionar por id.
	 * Retorna um vetor da linha selecionada.
	 *
	 * @param int $id
	 * @return bool|array
	 */
	public function select($fields = "*", $where = null, $orderby = 'id DESC', $joins = null, $groupby = null, $qtd = 10, $page = 1)
	{
		// Verifica se não tem dados de conexão ou conexão inativa e finaliza.
		if (!isset(BASE_BDS[$this->conn]) || !BASE_BDS[$this->conn]['ACTIVE']) {
			// FeedBack
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível obter dados da conexão [<b>' . $this->conn . '</b>].');
			return false;
		}

		// $this->conn agora é o objeto de conexão.
		$pdo = self::getConn($this->conn);

		// Limpa variáveis.
		$qtd = $this->limpaInject($qtd);
		$page = $this->limpaInject($page);

		// Inicializa limite.
		$limit = '';

		// Grava SQL final.
		$sql = '';

		// Prepara as partes do 
		$where   = ($where)   ? ' WHERE ' . $where : '';
		$joins = ($joins) ? ' ' . $joins : '';
		$groupby = ($groupby) ? ' GROUP BY ' . $groupby : '';
		$orderby = ($orderby) ? ' ORDER BY ' . $orderby : '';

		// Tipo de SQL.
		switch (BASE_BDS[$this->conn]['DBMANAGER']) {
			case 'mysql':
				// Monta limite para mysql.
				$limit = "LIMIT " . (($page - 1) * $qtd) . ", $qtd;";
				// Grava SQL final.
				$sql = "SELECT $fields FROM " . BASE_BDS[$this->conn]['PREFIX'] . "$this->tableName $where $orderby $limit";
				break;

			case 'oci':
				// NÃO TEM COMO APLICAR LIMITE (VERSÃO DO ORACLE ATUAL É 11);
				// Grava SQL final. 
				$sql = "SELECT * FROM " . BASE_BDS[$this->conn]['PREFIX'] . "$this->tableName";
				break;
		}

		// Prepara a Query.
		$sth = $pdo->prepare($sql);

		// Guarda SQL gerado.
		self::$sql = $sql;

		// Executa query de criação.
		if (!$sth->execute()) {
			// FeedBack
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível executar a query. Tabela [<b>' . $this->tableName . '</b>].' . print_r($sth->errorInfo(), true));
			return false;
		}

		// LOG Das ações na plataforma.
		$obs = 'Classe: ' . get_called_class() . ' Função ' . __FUNCTION__ . '.';
		$type = 'SELECT ALL';
		$this->gravaLog($obs, $type, $sql);

		// Caso ocorra tudo corretamente.
		return $sth->fetchAll(\PDO::FETCH_ASSOC);
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
		// Verifica se não tem dados de conexão ou conexão inativa e finaliza.
		if (!isset(BASE_BDS[$this->conn]) || !BASE_BDS[$this->conn]['ACTIVE']) {
			// FeedBack
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível obter dados da conexão [<b>' . $this->conn . '</b>].');
			return false;
		}

		// $this->conn agora é o objeto de conexão.
		$pdo = self::getConn($this->conn);

		// Acrescenta valores default caso não exista.
		$fields = array_merge($this->acrescentaValoresObrigatorios(true), $fields);

		// Obtém as chaves (nome dos campos).
		$cols = implode(', ', array_keys($fields));
		// Obtém as chaves como parâmetro (incluido em values), para depois trocar pelos valores.
		$params = implode(', :', array_keys($fields));

		// Constrói sql.
		$sql = "INSERT INTO " . BASE_BDS[$this->conn]['PREFIX'] . $this->tableName . " ($cols) VALUES(:$params)";

		// Prepara a Query.
		$sth = $pdo->prepare($sql);

		// Percorre os valores e adiciona ao bind.
		foreach ($fields as $key => $value) {
			// Monta sql com os valores.
			$sql = str_replace(":$key", $value, $sql);
			// Trata os valores para dentro da query preparada.
			$sth->bindValue(":$key", $value);
		}

		// Guarda SQL gerado.
		self::$sql = $sql;

		

		// Executa query de criação.
		if (!$sth->execute()) {
			// FeedBack
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível inserir o registro. Tabela [<b>' . $this->tableName . '</b>].' . print_r($sth->errorInfo(), true));
			return false;
		}
		$id = $pdo->lastInsertId();

		// Insere um log caso não seja a própria tabela log.
		if ($this->tableName != 'log_bd') {

			// LOG Das ações na plataforma.
			$obs = 'Classe: ' . get_called_class() . ' Função ' . __FUNCTION__ . '.';
			$type = 'INSERT';
			$this->gravaLog($obs, $type, $sql);

			// FeedBack
			\classes\FeedBackMessagens::add('success', 'Sucesso.', 'Registro inserido com sucesso. Tabela [<b>' . $this->tableName . '</b>].');
		}

		// Caso ocorra tudo corretamente.
		return $id;
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
		// Verifica se não tem dados de conexão ou conexão inativa e finaliza.
		if (!isset(BASE_BDS[$this->conn]) || !BASE_BDS[$this->conn]['ACTIVE']) {
			// FeedBack
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível obter dados da conexão [<b>' . $this->conn . '</b>].');
			return false;
		}

		// $this->conn agora é o objeto de conexão.
		$pdo = self::getConn($this->conn);

		// Acrescenta valores default caso não exista.
		$fields = array_merge($this->acrescentaValoresObrigatorios(), $fields);

		// Prepara o SET (key, values)
		$set = "";
		// Percorre os valores e adiciona ao bind.
		foreach ($fields as $key => $value) {
			$set .= ", $key=:$key";
		}
		$set[0] = " "; // Tira a virgula inicial.

		// Prepara as partes do where 
		$sql_where = " WHERE 1=1 ";
		$sql_where .= ($id) ? "AND id = $id " : "";
		$sql_where .= ($where) ? "AND " . $where : "";

		// Constrói sql.
		$sql = "UPDATE " . BASE_BDS[$this->conn]['PREFIX'] . "$this->tableName SET$set $sql_where";

		// Prepara a Query.
		$sth = $pdo->prepare($sql);

		// Percorre os valores e adiciona ao bind.
		foreach ($fields as $key => $value) {
			// Monta sql com os valores.
			$sql = str_replace(":$key", "'$value'", $sql);
			// Trata os valores para dentro da query preparada.
			$sth->bindValue(":$key", $value);
		}

		// Guarda SQL gerado.
		self::$sql = $sql;

		// Executa query de criação.
		if (!$sth->execute()) {
			// FeedBack
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível atualizar o registro. Tabela [<b>' . $this->tableName . '</b>].' . print_r($sth->errorInfo(), true));
			return false;
		}

		// LOG Das ações na plataforma.
		$obs = 'Classe: ' . get_called_class() . ' Função ' . __FUNCTION__ . '.';
		$type = 'UPDATE';
		$this->gravaLog($obs, $type, $sql);

		// FeedBack
		\classes\FeedBackMessagens::add('success', 'Sucesso.', 'Registro [' . $id . '] atualizado com sucesso. Tabela [<b>' . $this->tableName . '</b>].');

		// Caso ocorra tudo corretamente.
		return true;
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
		// Verifica se não tem dados de conexão ou conexão inativa e finaliza.
		if (!isset(BASE_BDS[$this->conn]) || !BASE_BDS[$this->conn]['ACTIVE']) {
			// FeedBack
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível obter dados da conexão [<b>' . $this->conn . '</b>].');
			return false;
		}

		// É necessário preencher um dos dois parâmetros.
		if (!$id && !$where) {
			return false;
		}

		// $this->conn agora é o objeto de conexão.
		$pdo = self::getConn($this->conn);

		// Prepara as partes do where 
		$sql_where = "";
		$sql_where .= ($id) ? "AND id = $id " : "";
		$sql_where .= ($where) ? "AND " . $where : "";

		// Constrói sql.
		$sql = "DELETE FROM " . BASE_BDS[$this->conn]['PREFIX'] . $this->tableName . " WHERE 1=1 $sql_where";

		// Guarda SQL gerado.
		self::$sql = $sql;

		// Verifica se registro não existe (já foi deletado).
		if (!self::select('1', '1=1 ' . $sql_where)) {

			// LOG Das ações na plataforma.
			$obs = 'Classe: ' . get_called_class() . ' Função ' . __FUNCTION__ . '. Registro já deletado';
			$type = 'DELETE STATUS';
			$this->gravaLog($obs, $type, $sql);

			// FeedBack
			\classes\FeedBackMessagens::add('success', 'Sucesso.', 'Registro já foi deletado. Tabela [<b>' . $this->tableName . '</b>].');

			// Registro já deletado.
			return true;
		}

		// Prepara a Query.
		$sth = $pdo->prepare($sql);

		// Executa query de criação.
		if (!$sth->execute()) {
			// FeedBack
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível deletar o registro. Tabela [<b>' . $this->tableName . '</b>].' . print_r($sth->errorInfo(), true));
			return false;
		}

		// LOG Das ações na plataforma.
		$obs = 'Classe: ' . get_called_class() . ' Função ' . __FUNCTION__ . '.';
		$type = 'DELETE';
		$this->gravaLog($obs, $type, $sql);

		// FeedBack
		\classes\FeedBackMessagens::add('success', 'Sucesso.', 'Registro deletado com sucesso. Tabela [<b>' . $this->tableName . '</b>].');

		// Caso ocorra tudo corretamente.
		return true;
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
		// Verifica se não tem dados de conexão ou conexão inativa e finaliza.
		if (!isset(BASE_BDS[$this->conn]) || !BASE_BDS[$this->conn]['ACTIVE']) {
			// FeedBack
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível obter dados da conexão [<b>' . $this->conn . '</b>].');
			return false;
		}

		// É necessário preencher um dos dois parâmetros.
		if (!$id && !$where) {
			return false;
		}

		// $this->conn agora é o objeto de conexão.
		$pdo = self::getConn($this->conn);

		// Acrescenta valores default caso não exista.
		$fields = array_merge($this->acrescentaValoresObrigatorios(), ['idStatus' => '0']);

		// Prepara o SET (key, values)
		$set = "";
		// Percorre os valores e adiciona ao bind.
		foreach ($fields as $key => $value) {
			$set .= ", $key=:$key";
		}
		$set[0] = " "; // Tira a virgula inicial.

		// Prepara as partes do where 
		$sql_where = "";
		$sql_where .= ($id) ? "AND id = $id " : "";
		$sql_where .= ($where) ? "AND " . $where : "";

		// Constrói sql.
		$sql = "UPDATE " . BASE_BDS[$this->conn]['PREFIX'] . "$this->tableName SET$set WHERE 1=1 $sql_where";

		// Prepara a Query.
		$sth = $pdo->prepare($sql);

		// Percorre os valores e adiciona ao bind.
		foreach ($fields as $key => $value) {
			// Monta sql com os valores.
			$sql = str_replace(":$key", "'$value'", $sql);
			// Trata os valores para dentro da query preparada.
			$sth->bindValue(":$key", $value);
		}

		// Guarda SQL gerado.
		self::$sql = $sql;

		// Executa query de criação.
		if (!$sth->execute()) {
			// FeedBack
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível deletar status do registro. Tabela [<b>' . $this->tableName . '</b>].' . print_r($sth->errorInfo(), true));
			return false;
		}

		// LOG Das ações na plataforma.
		$obs = 'Classe: ' . get_called_class() . ' Função ' . __FUNCTION__ . '.';
		$type = 'DELETE STATUS';
		$this->gravaLog($obs, $type, $sql);

		// FeedBack
		\classes\FeedBackMessagens::add('success', 'Sucesso.', 'Registro status deletado com sucesso. Tabela [<b>' . $this->tableName . '</b>].');

		// Caso ocorra tudo corretamente.
		return true;
	}


	/**
	 * selectAll
	 * 
	 * Função genérica para selecionar todos os registros.
	 * Retorna um array de registros.
	 *
	 * @param integer $posicao
	 * @param integer $qtd
	 * @return bool|array
	 */
	public function selectAll($qtd = 10, $posicao = 0)
	{
		// Verifica se não tem dados de conexão ou conexão inativa e finaliza.
		if (!$this->verifyConn()) {
			return false;
		}

		// $this->conn agora é o objeto de conexão.
		$pdo = self::getConn($this->conn);

		// Limpa variáveis.
		$qtd = $this->limpaInject($qtd);
		$posicao = $this->limpaInject($posicao);

		// Constrói sql.
		$limit = '';

		// Grava SQL final.
		$sql = '';

		// Tipo de SQL.
		switch (BASE_BDS[$this->conn]['DBMANAGER']) {
			case 'mysql':
				if ($posicao > 0)
					$limit = "LIMIT " . ((int)$posicao - 1) . ", $qtd;";
				// Grava SQL final.
				$sql = "SELECT * FROM " . BASE_BDS[$this->conn]['PREFIX'] . "$this->tableName ORDER BY id DESC $limit";
				break;

			case 'oci':
				// NÃO TEM COMO APLICAR LIMITE (VERSÃO DO ORACLE ATUAL É 11);
				// Grava SQL final. 
				$sql = "SELECT * FROM " . BASE_BDS[$this->conn]['PREFIX'] . "$this->tableName";
				break;
		}

		// Prepara a Query.
		$sth = $pdo->prepare($sql);

		// Executa query de criação.
		if (!$sth->execute()) {

			// FeedBack
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível executar a query. Tabela [<b>' . $this->tableName . '</b>].' . print_r($sth->errorInfo(), true));
			return false;
		}

		// Caso ocorra tudo corretamente.
		return $sth->fetchAll(\PDO::FETCH_ASSOC);
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
		// Verifica se não tem dados de conexão ou conexão inativa e finaliza.
		if (!$this->verifyConn()) {
			return false;
		}

		// É necessário preencher um dos dois parâmetros.
		if (!$id && !$where) {
			return false;
		}

		// $this->conn agora é o objeto de conexão.
		$pdo = self::getConn($this->conn);

		// Prepara as partes do where 
		$sql_where = "";
		$sql_where .= ($id) ? "AND id = $id " : "";
		$sql_where .= ($where) ? "AND " . $where : "";

		// Constrói sql.
		$sql = "SELECT * FROM " . BASE_BDS[$this->conn]['PREFIX'] . "$this->tableName WHERE 1=1 $sql_where";

		// Prepara a Query.
		$sth = $pdo->prepare($sql);

		// Executa query de criação.
		if (!$sth->execute()) {

			// FeedBack
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível executar a query. Tabela [<b>' . $this->tableName . '</b>].' . print_r($sth->errorInfo(), true));
			return false;
		}

		// Transforma resultado em array.
		$r = $sth->fetchAll(\PDO::FETCH_ASSOC);

		// Caso seja um array e não tenha resultados.
		if (!isset($r[0]))
			return false;

		// Caso ocorra tudo corretamente.
		return $r[0];
	}


	/**
	 * count
	 * 
	 * Função genérica para retornar a quantidade de registros da tabela.
	 *
	 * @return int
	 */
	protected function count()
	{
		// Verifica se não tem dados de conexão ou conexão inativa e finaliza.
		if (!$this->verifyConn()) {
			return false;
		}

		// $this->conn agora é o objeto de conexão.
		$pdo = self::getConn($this->conn);

		// Constrói sql.
		$sql = "SELECT count(*) QTD FROM " . BASE_BDS[$this->conn]['PREFIX'] . "$this->tableName";

		// Prepara a Query.
		$sth = $pdo->prepare($sql);

		// Guarda SQL gerado.
		self::$sql = $sql;

		// Executa query de criação.
		if (!$sth->execute()) {
			// FeedBack
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível contar os registros. Tabela [<b>' . $this->tableName . '</b>].' . print_r($sth->errorInfo(), true));
			return false;
		}

		// Caso ocorra tudo corretamente.
		return $sth->fetchAll(\PDO::FETCH_ASSOC)[0]['QTD'];
	}


	/**
	 * executeQuery
	 * 
	 * Função genérica para executar querys.
	 * Prefira sempre executar com a função "select()".
	 *
	 * @param  mixed $query
	 * @return bool|array
	 */
	protected function executeQuery($sql)
	{
		// Verifica se não tem dados de conexão ou conexão inativa e finaliza.
		if (!$this->verifyConn()) {
			return false;
		}

		// $this->conn agora é o objeto de conexão.
		$pdo = self::getConn($this->conn);

		// Prepara a Query.
		$sth = $pdo->prepare($sql);

		// Guarda SQL gerado.
		self::$sql = $sql;

		// Executa query de criação.
		if (!$sth->execute()) {
			// FeedBack
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível executar a query. ' . print_r($sth->errorInfo(), true));
			return false;
		}

		// Verifica se não é SELECT e cria feedback.
		if (!strpos($sql, "ELECT")){
			// FeedBack
			\classes\FeedBackMessagens::add('success', 'Sucesso.', 'SQL executado com sucesso.');

			// LOG Das ações na plataforma.
			$obs = 'Classe: ' . get_called_class() . ' Função ' . __FUNCTION__ . '.';
			$type = 'EXECUTE QUERY';
			$this->gravaLog($obs, $type, $sql);
		}

		// Grava Retorno
		$r = $sth->fetchAll(\PDO::FETCH_ASSOC);

		// Caso ocorra tudo corretamente.
		if (is_array($r)) {
			return $r;
		}

		return false;
	}


	/**
	 * Função responsável por gravar os log_bd da aplicação.
	 *
	 * @param string $obs
	 * @param string $type
	 * @param string $sql

	 * @return boolean
	 */
	protected function gravaLog($obs = 'Log Simples', $type = 'ND', $sql = 'ND')
	{
		return true;
		// Verifica se no tipo EXECUTE tem os seguintes tipos para realizar gravação de log.
		$queryType = $this->verificaTipo($sql);

		// Caso a query for uma consulta (SELECT), não grava log.
		if ($queryType == 'SELECT') {
			return true;
		}

		$options = [
			'conn'      => $this->conn,        // Conexão utilizada.
			'query'     => $sql,                // Query executada.
			'tableName' => $this->tableName,   // Tabela principal da Query executada.
			'queryType' => $queryType,          // Tipo da query.
			'type'      => $type,               // Tipo da query.
			'obs'       => $obs,                // Observação aberta.
		];

		return $this->insertLog($options);
	}


	/**
	 * insertLog
	 * 
	 * Função para insersão padrão de log_bd.
	 *
	 * @param array $options
	 * @return bool
	 */
	private function insertLog($options)
	{
		// Acrescenta valores padrão.
		$fields = [
			// 'url'           => VC_INFOURL['url_friendly'],        // Url atual.
			// 'attr'          => json_encode(VC_INFOURL['attr']),   // Parametros da url atual.
			'post'          => json_encode($_POST),               // POST.
			'get'           => json_encode($_GET),                // GET.
			// 'controller'    => VC_INFOURL['controller_path'],     // GET.
			'conn'          => $options['conn'],                  // Conexão utilizada.
			'query'         => $options['query'],                 // Query executada.
			'tableName'     => $options['tableName'],             // Tabela principal da Query executada.
			'queryType'     => $options['queryType'],             // Tipo da query.
			'type'          => $options['type'],                  // Tipo da query.
			'obs'           => $options['obs'],                   // Observação aberta.
		];

		// $this->conn agora é o objeto de conexão.
		$pdo = self::getConn($this->conn);

		// Acrescenta valores default caso não exista.
		$fields = array_merge($this->acrescentaValoresObrigatorios(true), $fields);

		// Obtém as chaves (nome dos campos).
		$cols = implode(', ', array_keys($fields));
		// Obtém as chaves como parâmetro (incluido em values), para depois trocar pelos valores.
		$params = implode(', :', array_keys($fields));

		// Constrói sql.
		$sql = "INSERT INTO " . BASE_BDS[$this->conn]['PREFIX'] . 'logDb' . " ($cols) VALUES(:$params)";

		// Prepara a Query.
		$sth = $pdo->prepare($sql);

		// Percorre os valores e adiciona ao bind.
		foreach ($fields as $key => $value) {
			// Monta sql com os valores.
			$sql = str_replace(":$key", $value, $sql);
			// Trata os valores para dentro da query preparada.
			$sth->bindValue(":$key", $value);
		}

		// Guarda SQL gerado.
		self::$sql = $sql;

		// Executa query de criação.
		if (!$sth->execute()) {
			// Não gravou log.
			return false;
		}

		// Gravou log.
		return true;
	}


	/**
	 * verificaTipo
	 * 
	 * Verifica em uma string se contém recorrência de palavras (tipos).
	 * Usado para auxiliar a função gravalog().
	 *
	 * @param  mixed $sql
	 * @return string
	 */
	private function verificaTipo($sql)
	{
		// Se sql está vazio, encerra.
		if (empty($sql)) {
			return 'LESS';
		}

		// Tipos de query encontradas no select.
		$tipos = ['CREATE ', 'UPDATE ', 'DROP ', 'INSERT ', 'DELETE ', 'PROCEDURE ', 'SELECT '];

		// Converte para upper case.
		$string = strtoupper($sql);

		// Procura os tipos (palavras chave) na sql.
		foreach ($tipos as $key => $value) {
			// Caso encontre o tipo. finaliza com true.
			if (mb_strpos($string, strtoupper($value)) !== false) {
				return $value;
			}
		}

		// Caso não encontre o tipo retorna false.
		return 'ND';
	}


	/**
	 * acrescentaValoresObrigatorios
	 * 
	 * Função que retorna os campos obrigatórios com valores default.
	 *
	 * @param boolean $insert
	 * @return array
	 */
	private function acrescentaValoresObrigatorios($insert = false)
	{

		// Monta valores de update.
		$fields = [
			'idStatus'      => 1,                                    // Observação aberta.
			'idLoginUpdate' => \classes\Session::get('id'),   // ID usuário. (só que não altera mais).
			'dtUpdate'      => date("Y-m-d H:i:s"),                  // Data. (só que não altera mais)
		];

		// Monta valores de insert.
		if ($insert) {
			$fields['obs']           = 'Preenchimento padrão.';             // Observação.
			$fields['idStatus']      = 1;                                   // Status 1 [Ativo].
			$fields['idLoginCreate'] = \classes\Session::get('id');  // ID usuário logado.
			$fields['dtCreate']      = date("Y-m-d H:i:s");                 // Data de criação deste log.
		}

		return $fields;
	}


	/**
	 * acrescentaCamposObrigatorios
	 * 
	 * Função que acrescenta campos obrigatórios de controle nas tabelas.
	 *
	 * @return array
	 */
	private function acrescentaCamposObrigatorios()
	{
		// Monta valores de update.
		$fields = [
			// Identificador Padrão (obrigatório).
			"id" => "INT NOT NULL AUTO_INCREMENT primary key",

			// Observações do registro (obrigatório).
			"obs" => "VARCHAR(255) NULL",

			// Controle padrão do registro (obrigatório).
			"idStatus"      => "INT NULL",        // Status grupo: "login/idStatus" ou [1] Ativo, [2] Inativo.
			"idLoginCreate" => "INT NULL",        // Login que realizou a criação.
			"dtCreate"      => "DATETIME NULL",   // Data em que registro foi criado.
			"idLoginUpdate" => "INT NULL",        // Login que realizou a edição.
			"dtUpdate"      => "DATETIME NULL",   // Data em que registro foi alterado.
		];

		return $fields;
	}


	/**
	 * limpaInject
	 * 
	 * Limpa variável de SQL injection.
	 *
	 * @param  string $string
	 * @return string
	 */
	protected function limpaInject($string)
	{
		return preg_replace('/[^[:alnum:]_]/', '', $string);
	}


	/**
	 * verifyConn
	 * 
	 * Verifica se não tem dados de conexão ou conexão inativa e finaliza.
	 *
	 * @return bool
	 */
	private function verifyConn()
	{

		if (!isset(BASE_BDS[$this->conn]) || !BASE_BDS[$this->conn]['ACTIVE']) {
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível obter dados da conexão [<b>' . $this->conn . '</b>].');
			return false;
		}

		// Conexão ok.
		return true;
	}
}
