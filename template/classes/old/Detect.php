<?php

namespace classes;

use Sinergi\BrowserDetector\Device;
use Sinergi\BrowserDetector\Browser;
use Sinergi\BrowserDetector\Language;
use Sinergi\BrowserDetector\Os;

/**
 * Classe Modelo.
 * Usado para executar funções específicas de um determinado assunto.
 */
class Detect
{

	/**
	 * Função que retorna o nome do browser.
	 * Recebe um valor, trata e retorna.
	 *
	 * @return string
	 */
	public static function browser()
	{
		// Instancia classe do device.
		$browser = new Browser();

		// Retorna o nome do browser.
		return $browser->getName();
	}

	/**
	 * Função que retorna o nome do browser.
	 * Recebe um valor, trata e retorna.
	 *
	 * @return string
	 */
	public static function device()
	{
		// Instancia classe do device.
		$device = new Device();

		// Retorna o nome do device.
		return $device->getName();
	}

	/**
	 * Função que retorna o nome da lingua.
	 * Recebe um valor, trata e retorna.
	 *
	 * @return string
	 */
	public static function language()
	{
		// Instancia classe da language.
		$language = new Language();

		// Retorna o nome do browser.
		return $language->getLanguage();
	}

	/**
	 * Função que retorna o nome do sistema operacional.
	 * Recebe um valor, trata e retorna.
	 *
	 * @return string
	 */
	public static function os()
	{
		// Instancia classe do SO.
		$os = new Os();

		// Retorna o nome do browser.
		return $os->getName();
	}
}
