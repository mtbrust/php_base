<?php

namespace classes;

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Classe para controle de envio de e-mails.
 */
class Email
{

	/**
	 * Função para Envio de e-mail.
	 *
	 * @param string $destinatario
	 * @param string $remetente
	 * @param string $mailCopia
	 * @param string $conteudo
	 * @param string $assunto
	 * @return void
	 */
	public static function enviar($destinatario, $remetente, $assunto, $conteudo, $mailCopia = null, $file = null)
	{


		// Inicia a classe PHPMailer
		$mail = new PHPMailer();

		// Método de envio
		$mail->IsSMTP();

		// Enviar por SMTP
		$mail->Host = "smtp.mandic.com.br";

		// Você pode alterar este parametro para o endereço de SMTP do seu provedor
		$mail->Port = 587;


		// Usar autenticação SMTP (obrigatório)
		$mail->SMTPAuth = true;

		// Usuário do servidor SMTP (endereço de email)
		// obs: Use a mesma senha da sua conta de email
		$mail->Username = 'noreply@coopama.coop.br';
		$mail->Password = 'V4{zM[92ZIVQ';

		// Configurações de compatibilidade para autenticação em TLS
		$mail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true));

		// Você pode habilitar esta opção caso tenha problemas. Assim pode identificar mensagens de erro.
		//$mail->SMTPDebug = 2;

		// Define o remetente
		// Seu e-mail
		//$mail->From = "noreply@coopama.com.br";
		$mail->From = "noreply@coopama.coop.br";

		// Seu nome
		$mail->FromName = $remetente;

		// Define o(s) destinatário(s)
		$mail->AddAddress($destinatario);

		// Opcional: mais de um destinatário
		// $mail->AddAddress('fernando@email.com');

		// Opcionais: CC e BCC

		$mail->AddCC($mailCopia);
		// $mail->AddBCC('roberto@gmail.com', 'Roberto');

		// Definir se o e-mail é em formato HTML ou texto plano
		// Formato HTML . Use "false" para enviar em formato texto simples ou "true" para HTML.
		$mail->IsHTML(true);

		// Charset (opcional)
		$mail->CharSet = 'UTF-8';

		// Assunto da mensagem
		$mail->Subject = $assunto;

		// Corpo do email
		$mail->Body = $conteudo;

		// Opcional: Anexos
		if (isset($file)) {
			$mail->AddAttachment($file['tmp_name'], $file['name']);
		}

		// print_r($file);
		// exit;

		// Envia o e-mail
		$enviado = $mail->Send();

		// Exibe uma mensagem de resultado
		if ($enviado) {
			//echo "Seu email foi enviado com sucesso!";
			return true;
		} else {
			//echo "Houve um erro enviando o email: " . $mail->ErrorInfo;
			return false;
		}
	}

	/**
	 * Função para envio de currículos anexos.
	 *
	 * @param string $nome
	 * @param string $email
	 * @param string $tel
	 * @param $_FILES $file
	 * @return void
	 */
	public static function enviarCurriculo($nome, $email, $tel, $file){
		
		// if (isset($file)) {
		// 	$nomeArquivo = Slugifi::convert($nome) . date('m-Y');
		// 	$options = [
		// 		'nomeArquivo'   => $nomeArquivo,                            // Nome do arquivo / Título
		// 		'dir'           => 'curriculos/',                                  // Pasta que vai ficar dentro de m/midia/.
		// 		'desc'          => '',                     // Descrição da mídia.
		// 		'larguraMaxima' => 1920,                                        // Largura máxima.
		// 	];
		// 	Midia::armazenar2($file, $options);
		// }

	}
}
