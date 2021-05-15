<?php


class BdStatusInsert extends Bd
{
    /**
     * Atribui a variavel tableName o valor do nome da tabela.
     * É usado em todas as funções para identificar qual a tabela das querys.
     *
     * @var string
     */
    private static $tableName = 'status';


    /**
     * Inicia a execução dos inserts.
     *
     * @return void
     */
    public static function start()
    {


        // Status Geral
        Self::Adicionar([
            'nome' => 'Ativo',
            'obs' => 'Status ativo',
            'statusGrupo' => '',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Inativo',
            'obs' => 'Status Inativo',
            'statusGrupo' => '',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);


        // tabela Login idStatus
        Self::Adicionar([
            'nome' => 'Ativo',
            'obs' => 'Login ativo.',
            'statusGrupo' => 'login/idStatus',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Inativo',
            'obs' => 'Login inativo',
            'statusGrupo' => 'login/idStatus',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);

        
        // tabela login idGrupo
        Self::Adicionar([
            'nome' => 'Administradores',
            'obs' => 'Grupo de Administradores.',
            'statusGrupo' => 'login/idGrupo',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'RH',
            'obs' => 'Grupo de RH.',
            'statusGrupo' => 'login/idGrupo',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Marketing',
            'obs' => 'Grupo de Marketing.',
            'statusGrupo' => 'login/idGrupo',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Contabilidade',
            'obs' => 'Grupo de Contabilidade.',
            'statusGrupo' => 'login/idGrupo',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'TI',
            'obs' => 'Grupo de TI.',
            'statusGrupo' => 'login/idGrupo',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);

        
        // tabela Users idStatusRh
        Self::Adicionar([
            'nome' => 'Estagiário',
            'obs' => 'Estagiário do RH.',
            'statusGrupo' => 'users/idStatusRh',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Membro',
            'obs' => 'Membro do RH.',
            'statusGrupo' => 'users/idStatusRh',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Analísta',
            'obs' => 'Analísta de RH.',
            'statusGrupo' => 'users/idStatusRh',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Supervisor',
            'obs' => 'Supervisor de RH.',
            'statusGrupo' => 'users/idStatusRh',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);

        
        // tabela Users idStatusMarketing
        Self::Adicionar([
            'nome' => 'Estagiário',
            'obs' => 'Estagiário do Marketing.',
            'statusGrupo' => 'users/idStatusMarketing',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Membro',
            'obs' => 'Membro do Marketing.',
            'statusGrupo' => 'users/idStatusMarketing',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Analísta',
            'obs' => 'Analísta de Marketing.',
            'statusGrupo' => 'users/idStatusMarketing',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Supervisor',
            'obs' => 'Supervisor de Marketing.',
            'statusGrupo' => 'users/idStatusMarketing',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);

        
        // tabela Users idStatusTi
        Self::Adicionar([
            'nome' => 'Estagiário',
            'obs' => 'Estagiário da TI.',
            'statusGrupo' => 'users/idStatusTi',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Membro',
            'obs' => 'Membro da TI.',
            'statusGrupo' => 'users/idStatusTi',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Analísta',
            'obs' => 'Analísta da TI.',
            'statusGrupo' => 'users/idStatusTi',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Supervisor',
            'obs' => 'Supervisor da TI.',
            'statusGrupo' => 'users/idStatusTi',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);

        
        // tabela Users idStatusContabilidade
        Self::Adicionar([
            'nome' => 'Estagiário',
            'obs' => 'Estagiário da Contabilidade.',
            'statusGrupo' => 'users/idStatusContabilidade',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Membro',
            'obs' => 'Membro da Contabilidade.',
            'statusGrupo' => 'users/idStatusContabilidade',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Analísta',
            'obs' => 'Analísta da Contabilidade.',
            'statusGrupo' => 'users/idStatusContabilidade',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Supervisor',
            'obs' => 'Supervisor da Contabilidade.',
            'statusGrupo' => 'users/idStatusContabilidade',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);

        
        // tabela Users idStatusPontuacao
        Self::Adicionar([
            'nome' => 'Bloqueado',
            'obs' => 'Pontos bloqueada.',
            'statusGrupo' => 'users/idStatusPontuacao',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Liberado',
            'obs' => 'Pontos liberara.',
            'statusGrupo' => 'users/idStatusPontuacao',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);


        // tabela pageInfo idStatus
        Self::Adicionar([
            'nome' => 'Ativo',
            'obs' => 'Página ativa.',
            'statusGrupo' => 'pageInfo/idStatus',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Inativo',
            'obs' => 'Página inativa',
            'statusGrupo' => 'pageInfo/idStatus',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);


        // tabela pageContent idStatus
        Self::Adicionar([
            'nome' => 'Ativo',
            'obs' => 'Página ativa.',
            'statusGrupo' => 'pageContent/idStatus',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Inativo',
            'obs' => 'Página inativa',
            'statusGrupo' => 'pageContent/idStatus',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);


        // tabela options idStatus
        Self::Adicionar([
            'nome' => 'Ativo',
            'obs' => 'Página ativa.',
            'statusGrupo' => 'options/idStatus',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Inativo',
            'obs' => 'Página inativa',
            'statusGrupo' => 'options/idStatus',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);


        // tabela areas idStatus
        Self::Adicionar([
            'nome' => 'Ativo',
            'obs' => 'Página ativa.',
            'statusGrupo' => 'areas/idStatus',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Inativo',
            'obs' => 'Página inativa',
            'statusGrupo' => 'areas/idStatus',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);


        // tabela banners idStatus
        Self::Adicionar([
            'nome' => 'Ativo',
            'obs' => 'Página ativa.',
            'statusGrupo' => 'banners/idStatus',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Inativo',
            'obs' => 'Página inativa',
            'statusGrupo' => 'banners/idStatus',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);


        // tabela eventos idStatus
        Self::Adicionar([
            'nome' => 'Ativo',
            'obs' => 'Página ativa.',
            'statusGrupo' => 'eventos/idStatus',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Inativo',
            'obs' => 'Página inativa',
            'statusGrupo' => 'eventos/idStatus',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);


        // tabela eventos idStatus
        Self::Adicionar([
            'nome' => 'Ativo',
            'obs' => 'Página ativa.',
            'statusGrupo' => 'eventos/idStatus',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Inativo',
            'obs' => 'Página inativa',
            'statusGrupo' => 'eventos/idStatus',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);


        // tabela galeria idStatus
        Self::Adicionar([
            'nome' => 'Ativo',
            'obs' => 'Página ativa.',
            'statusGrupo' => 'galeria/idStatus',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Inativo',
            'obs' => 'Página inativa',
            'statusGrupo' => 'galeria/idStatus',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);


        // tabela noticias idStatus
        Self::Adicionar([
            'nome' => 'Ativo',
            'obs' => 'Página ativa.',
            'statusGrupo' => 'noticias/idStatus',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Inativo',
            'obs' => 'Página inativa',
            'statusGrupo' => 'noticias/idStatus',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);


        // tabela permissions idStatus
        Self::Adicionar([
            'nome' => 'Ativo',
            'obs' => 'Página ativa.',
            'statusGrupo' => 'permissions/idStatus',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        Self::Adicionar([
            'nome' => 'Inativo',
            'obs' => 'Página inativa',
            'statusGrupo' => 'permissions/idStatus',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        


        /* EXAMPLE
        Self::Adicionar([
            'nome' => '',
            'obs' => '',
            'statusGrupo' => '',
            'idStatusPai' => '',
            'dtCreate' => date("Y-m-d H:i:s"),
        ]);
        */

        return true;
    }


    /**
     * Cria a função add passando as variaveis $fields e $coon como parametros
     *
     * @param array $fields
     * @param PDO $conn
     * @return bool
     */
    public static function Adicionar($fields, $conn = null)
    {
        // Retorno da função insert préviamente definida. (true, false)
        return Self::insert(Self::$tableName, $fields, $conn);
    }
}
