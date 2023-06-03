<?php

namespace classes;

/**
 * Classe Modelo.
 * Usado para executar funções específicas de um determinado assunto.
 */
class Modelo
{
	/**
	 * foo
	 * 
	 * Função modelo.
	 * Recebe um valor, trata e retorna.
	 *
	 * @param  mixed $options
	 * @return array
	 */
	public static function foo($options)
	{
		// Valores default.
		$optionsDefault = [
			'valor' => 'default',
		];

		// Junta e sobreescreve Default
		$options = array_replace_recursive($optionsDefault, $options);

		// Retorna o resultado.
		return $options;
	}


}
