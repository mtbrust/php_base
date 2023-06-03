
Ajustar controller endpoint.
  Criar as funções necessárias para carregar todos os parâmetros.
  Criar as funções necessárias para executar o endpoint.
  Ajustar paths de require

Ajustar controller security.
  Ajustar como será realizada a criação de permissões.
  Verificar como será realizada a criação de grupos.
  Como será realizado a criação de permissões específicas por endpoint.
  Ajustar para criar o formato de sessão.

Ajustar Classe "Session.php"

Arrumar config.
  separar por ambiente

Arrumar criação de classes
arrumar criação de Bds
arrumar criação de obj render


Na API
acrescentar o stauts para o código de retorno http (além do response).
self::$params['response'] = []
self::$params['status'] = 404


ENGINE.PHP
colocar a opção de definir informações por banco de dados.
para não precisar ficar preenchendo arquivo.
criar BD options
criar os bds necessários