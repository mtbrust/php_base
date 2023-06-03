<?php

namespace classes;


/**
 * Classe responsável por criar as tabelas no banco de dados.
 * Usado para executar funções específicas de um determinado assunto.
 */
class CreateTablesBd
{

	/**
	 * Função modelo.
	 * Recebe um valor, trata e retorna.
	 *
	 * @param array $options
	 * @return void
	 */
	public static function start($options = [])
	{
		$optionsDefault = [
			'' => '',
		];

		// Junta
		array_merge($options, $optionsDefault);

		self::dependences();

		// Cria o resultado.
		$r = true;

		\BdLogins::tableCreate();
		\BdLogs::tableCreate();
		\BdModelo::tableCreate();
		\BdStatus::tableCreate();
		\BdLoginsGroups::tableCreate();
		\BdPermissions::tableCreate();


		// Retorna o resultado.
		return $r;
	}

	// Carrega dependências de classes.
	public static function dependences()
	{
		require_once VC_PATHS['P_PATH_BD'] . 'BdModelo.php';
	}


	public static function test()
	{
		echo "Classe funciona.";
		return true;
	}
}
