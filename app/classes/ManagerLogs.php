<?php

namespace classes;

/**
 * Classe Modelo.
 * Usado para executar funções específicas de um determinado assunto.
 */
class ManagerLogs
{
	/**
	 * Para testar se o log está gravando.
	 *
	 * @return void
	 * 
	 */
	public static function test()
	{
		$domain = 'domain/debug2/teste';
		$content = '{"test":"Teste de gravação de log"}';
		self::register($domain, $content);
		self::registerNotice($domain, $content);
		self::registerWarning($domain, $content);
		self::registerError($domain, $content);
	}

	/**
	 * Registra uma notice no log.
	 *
	 * @param string $logDomain
	 * @param string $logContent
	 * 
	 * @return void
	 * 
	 */
	public static function registerNotice($logDomain, $logContent)
	{
		self::register($logDomain, $logContent, "notice");
	}


	/**
	 * Registra uma atenção no log.
	 *
	 * @param string $logDomain
	 * @param string $logContent
	 * 
	 * @return void
	 * 
	 */
	public static function registerWarning($logDomain, $logContent)
	{
		self::register($logDomain, $logContent, "warning");
	}


	/**
	 * Registra um erro no log.
	 *
	 * @param string $logDomain
	 * @param string $logContent
	 * 
	 * @return void
	 * 
	 */
	public static function registerError($logDomain, $logContent)
	{
		self::register($logDomain, $logContent, "error");
	}

	/**
	 * Registra o log no path e arquivo do dompinio do log e o conteúdo (json preferência).
	 *
	 * @param string $logDomain
	 * @param string $logContent
	 * 
	 * @return void
	 * 
	 */
	private static function register($logDomain, $logContent, $type = 'note')
	{
		ManagerFile::write('logs/' . date('Y-m-d') . '/' . $logDomain . '.txt', self::prefix($logContent, $type));
	}

	/**
	 * Monta conteúdo do log.
	 * Acrescenta a data e hora e o time de log.
	 * Tipo de log:
	 * 	note
	 * 	notice
	 * 	warning
	 * 	error
	 *
	 * @param string $logContent
	 * @param string $type
	 * 
	 * @return string
	 * 
	 */
	private static function prefix($logContent, $type = 'note')
	{
		return '[' . date('Y-m-d H:i:s') . '] ' . '[' . $type . '] ' . $logContent;
	}
}
