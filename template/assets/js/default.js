/**
 * Função Ajax com CallBack.
 * Função tem o objetivo de enviar dados POST para uma URL e realizar uma função CALLBACK personalizada com o retorno.
 * 
 * @param {*} url_api 
 * @param {*} dados 
 * @param {*} callback 
 * @param {*} type 
 */
function ajaxDados(url_api, dados, callback, type = 'POST'){
    
    // Realiza chamada AJAX.
    $.ajax({
    type: type,
    url: url_api,
    // async: false,
    myCallback: callback,
    data: dados,
    processData: false,
    contentType: false,
    beforeSend: function(ret) {
        // Preparação antes do envio.
    },
    success: function(ret) {
        // Envio com sucesso.
        this.myCallback(ret);
    },
    error: function(){
        // Prepara valores e passa para o callback chamar o erro.
        ret = {ret:'',msg:'Erro na chamada AJAX.'};
        this.myCallback(ret);
    },
    complete: function(ret) {
        // Ao finalizar toda a execução.
    },
    }).done(function (ret) {
        // Para concluir o processo.
    });
}

/**
 * Função geral para exibir notificação.
 * 
 * @param {*} options 
 */
function notificaBrowser(options) {

    // Verifica se o browser suporta notificações
    if (!("Notification" in window)) {
        console.log("Este browser não suporta notificações de Desktop")
    }

    // Se tiver permissão, exibe a notificação.
    else if (Notification.permission === "granted") {
        var notification = new Notification(options.title, {
            icon: options.icon,
            body: options.body
        });
    }

    // Se não tiver permissão, pergunta se usuário quer permitir notificação.
    else if (Notification.permission !== 'denied') {
        Notification.requestPermission(function (permission) {

            // Se usuário aceitar, envia a notificação.
            if (permission === "granted") {
                var notification = new Notification(options.title, {
                    icon: options.icon,
                    body: options.body
                });
            }
        });
    }
}
// Solicita permissão para notificação.
Notification.requestPermission();

/**
 * Função para copiar valor para área de transferência.
 * @param {*} value 
 */
// 
function cpTransferencia(value) {
    // Se input não está criado, cria.
    if (!$("input#cpTransferencia").length) {
        $("body").append('<input type="text" id="cpTransferencia" value="" class="m-0 p-0" style="height: 0px;border: 0;"/>');
    }

    // Atribui o valor a ser copiado ao input.
    $("#cpTransferencia").val(value);
    $("#cpTransferencia").attr('value', value);

    // Exibe formulário.
    $("#cpTransferencia").show();

    // Seleciona o texto.
    $("#cpTransferencia").select();

    // Realiza o comando copiar.
    document.execCommand('copy');
}

/**
 * Função que registra ação na tabela de registros.
 * 
 * @param {*} cod 
 * @param {*} obs 
 * @param {*} url 
 * @param {*} token // {{token.registro}}
 */
function btnRegistro(cod, obs, url, token) {

    // Prepara valores
    data = {
        cod: cod,
        obs: obs,
        token: token,
    };

    $.ajax({
        // type: 'GET',
        url: url,
        // data: data,
        processData: false,
        contentType: false,
        success: function (data) {
            // Envio com sucesso.
            console.log(data);
            // dados = data;
        },
        error: function (data) {
            // Erro ao realizar a chamada.
            console.log('Não registrou a ação: ' + data.cod);
        }
    });
}














/**
 * ******************************************************************************************************
 * TESTES
 */



/**
 * Exemplo de uso da ajaxDados(url, dados, callback);
 * Neste exemplo o script faz uma consulta na api da página enviando os dados criados e escreve o retorno no console.log.
 */
function teste_ajaxDados()
{
    // Console
    console.log('Início do teste ajaxDados');

    // Preparação dos dados.
    dados = new FormData(/* ID formulário */);
    dados.append('f-formToken', '{{tokens.pageApi}}');  // Token para uso de API da própria página.
    dados.append('f-formToken', '{{tokens.pageFunc}}'); // Token para uso envio de dados para própria página.
    dados.append('campo', 'valor'); // Exemplo de inclusão de valores.

    // Chamada AJAX
    ajaxDados('https://v3.local/api/00-modelo/teste/test', dados, function(ret){
        // Para testes
        console.log(ret);

        // Verifica se teve retorno ok.
        if (ret.ret) {
            
            // code...

            // Notificação.
            Swal.fire({
                icon: "success",
                title: "Sucesso.",
                text: ret.msg,
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        }else{

            // code...

            // Notificação.
            Swal.fire({
                icon: 'error',
                title: 'Erro.',
                text: ret.msg,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
            });
        }
    })

    // Console
    console.log('Fim do teste ajaxDados');
}

/**
 * Teste da função de notificação.
 */
function teste_notificaBrowser()
{
    // Console
    console.log('Início do teste notificaBrowser');

    // Prepara os dados.
    options = {
        title:'título da notificação',
        icon:'https://v3.local/favicon.ico',
        body: 'Texto da notificação.',
    }

    // Chama a notificação.
    notificaBrowser(options);

    // Console
    console.log('Fim do teste notificaBrowser');
}