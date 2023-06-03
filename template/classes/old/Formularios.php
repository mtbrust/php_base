<?php

namespace classes;

/**
 * Classe Modelo.
 * Usado para executar funções específicas de um determinado assunto.
 */
class Formularios
{

	/**
	 * Função que retorna o formulário de grupo.
	 * retorna um html a ser inserido dentro da tag row.
	 *
	 * @param array $options
	 * @return string
	 */
	public static function privacidade($options = array())
	{
		// Valores default
		$defaultOpt = [
			// Parâmetros
			'v'           	 => 1,       // Versão do formulário de privacidade. (v2 formulário que adiciona separadamente grupo ou login.)
			'privacidade'  	 => true,    // Exibe opções de privacidade ([0] Público, [1] Privado, [2] Oculto). False é igual a 1 Privado.
			'update'      	 => false,   // Caso seja de update.
			'id'           	 => false,   // Id que vai para a API v2.
			'formTokenApi' 	 => false,   // Token que vai para a API v2.
			'private'     	 => 2,       // Privacidade da mídia. (já vem selecionado o tipo de privacidade)
			'permissoes'  	 => false,	 // Incluir permissões de página (para ferramentas).

			// Grupo
			'grupo'          => true,
			'gruposItens'    => [],
			'grupoApiAdd'    => '',
			'grupoApiDelete' => '',
			'grupoApiGet' 	 => '',
			
			//Login
			'login'       	 => true,
			'loginItens'  	 => [],
			'loginApiAdd'    => '',
			'loginApiDelete' => '',
			'loginApiGet' 	 => '',
		];
		
		// Sobrescreve opções default e grava nos dados.
		$dados['opt'] = array_merge($defaultOpt, $options);

		// Preparação dos dados.
		// Grupos de logins.
		$dados['grupos'] = \controle\BdStatus::selecionaPorGrupo('login/idGrupo');
		$dados['gruposItens'] = $dados['opt']['gruposItens'];
		// Logins
		$dados['logins'] = \controle\BdLogins::selecionaTudo();
		$dados['loginItens'] = $dados['opt']['loginItens'];


		// Monta hormulário html.
		$formularioHtml = ControllerRender::renderObj('classes/formularios/privacidade_v' . $dados['opt']['v'], $dados); 

		// Cria o resultado.
		// $r = $options;

		// Retorna o resultado.
		return $formularioHtml;
	}

	/**
	 * Função que retorna o formulário de Contatos e Endereços.
	 * retorna um html a ser inserido dentro da tag row.
	 *
	 * @param array $options
	 * @return string
	 */
	public static function formasContato($options = array())
	{
		// Valores default
		$defaultOpt = [
			'v'            		 => 1,       // Versão do formulário de privacidade.
			'update'       		 => false,   // Caso seja de update.
			'id'           		 => false,   // Id que vai para a API.
			'formTokenApi' 		 => false,   // Token que vai para a API.
			
			// Contatos
			'contatos'           => false,   // Exibir.
			'contatosApiAdd'     => '',		 // Api para criar um novo contato.
			'contatosApiDelete'  => '',		 // Api para deletar um contato.
			'contatosItens'      => [],
			
			// Endereços
			'enderecos'          => false,   // Exibir.
			'enderecosApiAdd'    => '',      // Api para criar um novo endereço.
			'enderecosApiDelete' => '',      // Api para deletar um endereço.
			'enderecosItens'     => [],      // 
			
		];
		
		// Sobrescreve opções default e grava as opções.
		$dados = array_merge($defaultOpt, $options);
	
		// Caso seja para exibir formulário de contatos.
		if ($dados['contatos']) {

			// Obtém os valores para os selects.
			$dados['contatosTipos']  = \controle\BdStatus::selecionaPorGrupo('contacts/tipo');      // Relação de Tipos para conter
			$dados['contatosStatus'] = \controle\BdStatus::selecionaPorGrupo('contacts/idStatus');

			// Monta os itens HTML de Contatos.
			$htmlContatos = ControllerRender::renderObj('classes/formularios/contatosItensContato', $dados);
		}

		// Caso seja para exibir formulário de endereços.
		if ($dados['enderecos']) {

			// Obtém os valores para os selects.
			$dados['enderecosPais'] = \controle\BdStatus::selecionaPorGrupo('adresses/pais');
			$dados['enderecosZonas'] = \controle\BdStatus::selecionaPorGrupo('adresses/zona');
			$dados['enderecosUfs'] = \controle\BdStatus::selecionaPorGrupo('adresses/uf');
			$dados['enderecosLogradouros'] = \controle\BdStatus::selecionaPorGrupo('adresses/logradouro');
			$dados['enderecosTipos'] = \controle\BdStatus::selecionaPorGrupo('adresses/idTipo');
			$dados['enderecosStatus'] = \controle\BdStatus::selecionaPorGrupo('adresses/idStatus');

			// Monta os itens HTML de Endereços.
			$htmlEnderecos = ControllerRender::renderObj('classes/formularios/contatosItensEndereco', $dados);
		}

		$dados['htmlContatos'] = $htmlContatos;
		$dados['htmlEnderecos'] = $htmlEnderecos;
		$dados['htmlMaskInput'] = TratamentoDados::maskInput();

		// Monta HTML do java script.
		$htmlFormasContato = ControllerRender::renderObj('classes/formularios/contatos', $dados); 

		// Retorna o resultado.
		return $htmlFormasContato;
	}


	/**
	 * Cria um formulário para definição das permissões de página.
	 * Recebe um valor, trata e retorna.
	 *
	 * @param array $options
	 * @return void
	 */
	public static function permissoes($options = array())
	{
		// Valores default do options
		$defaultOpt = [
			'opt' => false,   // Valor modelo
		];
		
		// Sobrescreve opções default e grava as opções.
		$options = array_merge($defaultOpt, $options);

		// Monta HTML das permissões.
		$html = ControllerRender::renderObj('classes/formularios/permissoes', $options); 

		// Retorna o resultado.
		return $html;
	}




	/**
	 * Todo: Modelo de função.
	 * Função modelo.
	 * Recebe um valor, trata e retorna.
	 *
	 * @param [type] $options
	 * @return void
	 */
	public static function foo($options = array())
	{
		// Valores default do options
		$defaultOpt = [
			'opt' => false,   // Valor modelo
		];
		
		// Sobrescreve opções default e grava as opções.
		$options = array_merge($defaultOpt, $options);

		$r = true;

		// Retorna o resultado.
		return $r;
	}


}
