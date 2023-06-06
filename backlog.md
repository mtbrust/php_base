
Ajustar controller endpoint.
  Criar as funções necessárias para carregar todos os parâmetros. (acho que já esta carregando)
  Criar as funções necessárias para executar o endpoint. (acho que já esta executando.)
  Ajustar paths de require (acho que já esta correto)

Ajustar controller security.
  Ajustar como será realizada a criação de permissões.
  Verificar como será realizada a criação de grupos.
  Como será realizado a criação de permissões específicas por endpoint.
  Ajustar para criar o formato de sessão.

Ajustar Classe "Session.php"


Arrumar criação de classes

Arrumar inclusão de plugins.


Na API
acrescentar o stauts para o código de retorno http (além do response).
self::$params['response'] = []
self::$params['status'] = 404


ENGINE.PHP
colocar a opção de definir informações por banco de dados.
para não precisar ficar preenchendo arquivo.
criar os bds necessários


Comparar endpoint de pages.
  api -> modelo.php
  com
  page -> c -> index.php
  Ao final criar um modelo de endpoint page.
  Ao final criar um modelo limpo.