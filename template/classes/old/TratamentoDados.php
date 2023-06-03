<?php

use Respect\Validation\Rules\Length;

namespace classes;

/**
 * Classe responsável por realizar tratamento em dados de input e outros.
 * Normalização e ajuste.
 */
class TratamentoDados
{
	/**
	 * Trata o valor e retorna somente número.
	 */
	public static function numberOnly($valor)
	{
		$valor = preg_replace('/[^0-9]/', '', $valor);
		return $valor;
	}


	/**
	 * Trata o valor de data e retorna sem o T.
	 */
	public static function dataSemT($valor)
	{
		$valor[10] = ' ';
		return $valor;
	}


	/**
	 * Trata o valor de data e retorna com o T.
	 */
	public static function dataComT($valor)
	{
		$valor[10] = 'T';
		return $valor;
	}



	/** 
	 * Função de máscara para input. 
	 * 
	 */
	public static function maskInput()
	{
		
		// Acrescenta as mascaras e inputfile (esqueci).
		$script = '
		$(document).ready(function(){
			bsCustomFileInput.init();
			//$(".mask-cpf").inputmask({"mask": "(999) 999-9999"}); //specifying options
			$(".mask-email").inputmask("email"); 
			$(".mask-cpf").inputmask({ mask: ["999.999.999-99"], outputFormat: "99999999999", keepStatic: true}); 
			$(".mask-cep").inputmask({ mask: ["99999-999"], outputFormat: "99999999", keepStatic: true}); 
			$(".mask-tel").inputmask({ mask: ["(99) 9999-9999", "(99) 9 9999-9999"], outputFormat: "99999999999", keepStatic: true}); 
			$(".mask-date").inputmask({ mask: ["99/99/9999", "99/99/9999 99:99:99"], keepStatic: true}); 
			$(".mask-mac").inputmask({ mask: ["**:**:**:**:**:**"], keepStatic: true}); 
			$(".mask-ip").inputmask({ mask: ["9[9][9].9[9][9].9[9][9].9[9][9]"], keepStatic: true}); 
		});
		';
		//Inputmask({ regex: "^([0-9]{1,3}\.){3}[0-9]{1,3}$" }).mask(".mask-ip");

		return $script;
	}


	/**
	 * Função que minifica texto (html) e retorna em uma linha.
	 * Cuidado ao ter comentários de linha sem fechamento.
	 *
	 * @param string $text
	 * @return string
	 */
	public static function minification($text){
		return str_replace(array("\r", "\n", "\t", "  "), '', $text);
	}

    /**
     * Função que transforma datas em formato brasileiro (d/m/Y).
     * @param $data
     */
	public static function dataBr($data){
        $valorFormatado = date("d/m/Y", strtotime($data));
        return $valorFormatado;
    }

    /**
     * Função que transforma data e hora em formato brasileiro (d/m/Y H:i:s). 
     * @param $dataHora
     */
    public static function dataHoraBr($dataHora){
        $valorFormatado = date("d/m/Y H:i:s", strtotime($dataHora));
        return $valorFormatado;
    }

    /**
     * Função que transforma datas em formato de banco de dados (y-m-d).
     * @param $data
     */
	public static function dataBD($data){
        $valorFormatado = date("Y-m-d", strtotime($data));
        return $valorFormatado;
    }

    /**
     * Função que transforma data e hora em formato de banco de dados (y-m-d).
     * @param $dataHora
     */
    public static function dataHoraBD($dataHora){
        $valorFormatado = date("Y-m-d H:i:s", strtotime($dataHora));
        return $valorFormatado;
    }

	/**
	 * Recebe um mês com 0 ou sem e retorna o nome do mê<s class=""></s>
	 *
	 * @param string $mes
	 * @return string
	 */
	public static function retornaMes($mes) {

		// Ajeita com 0 antes.
		$mes = str_pad($mes, 2, '0', STR_PAD_LEFT);

		// Meses
        $arrayMes = [
            '01'=>'Janeiro',
            '02'=>'Fevereiro',
            '03'=>'Março',
            '04'=>'Abril',
            '05'=>'Maio',
            '06'=>'Junho',
            '07'=>'Julho',
            '08'=>'Agosto',
            '09'=>'Setembro',
            '10'=>'Outubro',
            '11'=>'Novembro',
            '12'=>'Dezembro'
		];

		// Retorna o nome do mês
        return $arrayMes[$mes];
    }

    /**
     * Função que transforma imagem em base64
     * @param $path
     */
    public static function imgBase64($path){
		
		// Obtém a extensão.
		$type = pathinfo($path, PATHINFO_EXTENSION);
		// Obtém o conteúdo da imagem.
		$data = file_get_contents($path);
		// Transforma tudo já preparado para o src.
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

		// Retorno.
		return $base64;
    }

    /**
     * Função que limpa o texto.
	 * Tira os caracteres especiais como;
	 * 	Tabulação
	 * 	Quebra de linha
	 * 	Paragrafo
	 * 	Espaços
     * @param $path
     */
    public static function limpaTexto($texto){
		return str_replace(array("\n", "\t", "\r", "  "), '', $texto);
    }

	/**
	 * Limpa sql injection da variável.
	 *
	 * @param string $variavel
	 * @return string
	 */
	public static function limpaInject($variavel)
	{
		return preg_replace('/[^[:alnum:]_]/', '', $variavel);
	}

	/**
	 * Retorna número de telefone com ou sem DDD, fixo ou celular formatado BR.
	 * (35) 3295-0171
	 * (35) 9 9326-5491
	 * 3295-0171
	 * 9 9326-5491
	 *
	 * @param string $telefone
	 * @return string
	 */
	public static function telefoneBr($telefone, $options = array())
	{
		// Prepara as opções. (não usa)
		$optionsDefault = [
			'tipo' => 10, // [8] fixo sem DDD, [10] fixo com DDD, [9] celuar sem DDD, [11] celular com DDD
		];
		$options = array_merge($optionsDefault, $options);

		// Limpa telefone.
		$telefone = self::numberOnly($telefone);

		// Verifica o tipo de telefone.
		switch (strlen($telefone)) {
			case '8':
				// Telefone fixo sem DDD.
				$r = substr($telefone,0,4) . '-' . substr($telefone,4,4);
				break;
			
			case '10':
				// Telefone fixo com DDD.
				$r = '(' . substr($telefone,0,2) . ') ' . substr($telefone,2,4) . '-' . substr($telefone,6,4);
				break;
			
			case '9':
				// Celular sem DDD.
				$r = $telefone[0] . ' ' . substr($telefone,1,4) . '-' . substr($telefone,5,4);
				break;
			
			case '11':
				// Celular com DDD.
				$r = '(' . substr($telefone,0,2) . ') ' . $telefone[2] . ' ' . substr($telefone,3,4) . '-' . substr($telefone,7,4);
				break;
			
			default:
				$r = $telefone;
				break;
		}

		// Retorna número formatado BR.
		return $r;
	}
}
