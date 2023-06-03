<?php

namespace classes;

/**
 * Classe LyceumDev.
 * Usado para executar funções específicas de um determinado assunto.
 */
class LyceumDev
{
	/**
	 * foo
	 * 
	 * Função teste.
	 * Recebe um valor, trata e retorna.
	 *
	 * @param  mixed $options
	 * @return array
	 */
	public static function teste($options)
	{
		set_time_limit((60 * 60));

		define('DB_HOST', "10.22.235.7");
		define('DB_USER', "vinicius.teixeira");
		define('DB_PASSWORD', "Vinícius@+1011");
		define('DB_NAME', "LYCEUMDEV");
		define('DB_DRIVER', "sqlsrv");

		// $codigo_pedido = $_GET['pedido'];

		echo 'Início.<br>';

		$server = DB_HOST;
		$options = array("UID" => DB_USER, "PWD" => DB_PASSWORD, "Database" => DB_NAME, "LoginTimeout" => 60 * 60);
		$conn = sqlsrv_connect($server, $options);


		// $proc = "{CALL API_SP_ALUNO_TESTE(?)}";
		// $params = array(&$codigo_pedido);
		// $statement = sqlsrv_prepare($conn, $proc, $params);
		$sql = "SELECT TOP 1 * FROM LY_ALUNO";
		$statement = sqlsrv_prepare($conn, $sql);

		// echo "<pre>";
		// print_r($statement);
		// echo "<pre>";

		// // Precisa executar 2x vezes:
		// sqlsrv_execute($statement);
		// sqlsrv_execute($statement);

		// sqlsrv_close($conn);
	}
}
