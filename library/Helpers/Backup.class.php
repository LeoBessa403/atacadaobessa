<?php

/**
 * Backup.class [ HELPER ]
 * Reponsável por realizar o backup do Banco de Dados!
 *
 * @copyright (c) 2015, Leonardo Bessa
 */
class Backup
{
    var $charset = '';
    var $conn;

    /**
     * Constructor initializes database
     * Backup constructor.
     * @param $validar
     */
    function __construct($validar = true)
    {
        if ($validar) {
            $backup = fopen('BancoDados/Backup.txt', "a+");
            $backupDates = fgets($backup);
            $backupDate = explode('//', $backupDates);
            $dias = Valida::CalculaDiferencaDiasData(date("d/m/Y"), Valida::DataShow($backupDate[0]));

            if ($dias < 1):
                $this->gerarBackup();
            endif;
        } else {
            $this->gerarBackup();
        }
    }

    /**
     * Backup the whole database or just some tables
     * Use '*' for whole database or 'table1 table2 table3...'
     * @param string $tables
     * @return bool
     */
    public function RealizarBackup($tables = '*')
    {
        try {

            $sql = "-- Atualizado em: " . Valida::DataAtual() .
                "\n-- Link HOME: " . HOME .
                "\n-- AMBIENTE: " . AMBI .
                "\n-- BANCO: " . DBSA . "\n\n";
            $sql .= 'CREATE DATABASE IF NOT EXISTS ' . DBSA . ";\n\n";
            $sql .= 'USE ' . DBSA . ";\n\n";

            if (BANCO == 1) {
                $sql = $this->backupMySql($tables, $sql);
            } elseif (BANCO == 2) {
//                $sql = $this->backupPostGres($tables, $sql);
            }

        } catch (Exception $e) {
            var_dump($e->getMessage());
            return false;
        }

        return $this->saveFile($sql);
    }


    /**
     * Save SQL to file
     * @param string $sql
     * @param string $tables
     * @return bool
     */
    protected function backupMySql($tables, $sql)
    {
        /**
         * Tables to export
         */
        if ($tables == '*') {
            $tables = array();
            $result = mysqli_query($this->conn, 'SHOW TABLES');
            while ($row = mysqli_fetch_row($result)) {
                if ($this->liberaBackup($row[0])) {
                    $tables[] = $row[0];
                }
            }
        } else {
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }

        foreach ($tables as $table) {
            $table = strtoupper($table);
            $result = mysqli_query($this->conn, 'SELECT * FROM ' . $table);
            $numFields = mysqli_num_fields($result);

            $sql .= 'DROP TABLE IF EXISTS ' . $table . ';';
            $row2 = mysqli_fetch_row(mysqli_query($this->conn, 'SHOW CREATE TABLE ' . $table));
            $sql .= "\n\n\n" . str_replace(strtolower($row2[0]), $row2[0], $row2[1]) . ";\n\n\n";

            for ($i = 0; $i < $numFields; $i++) {
                while ($row = mysqli_fetch_row($result)) {
                    $sql .= 'INSERT INTO ' . $table . ' VALUES(';
                    for ($j = 0; $j < $numFields; $j++) {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = str_replace("\n", "\\n", $row[$j]);
                        if (!empty($row[$j])) {
                            $sql .= "'" . $row[$j] . "'";
                        } else {
                            $sql .= 'NULL';
                        }

                        if ($j < ($numFields - 1)) {
                            $sql .= ',';
                        }
                    }
                    $sql .= ");\n\n";
                }
            }
            $sql .= "\n\n\n";
        }

        return $sql;
    }

    /**
     * Save SQL to file
     * @param string $sql
     * @param string $tables
     * @return bool
     */
    protected function backupPostGres($tables, $sql)
    {
        /**
         * Tables to export
         */
        if ($tables == '*') {
            $tables = array();
            $result = pg_query($this->conn, "SELECT *
                                            FROM pg_catalog.pg_tables
                                            WHERE schemaname != 'pg_catalog' AND
                                                    schemaname != 'information_schema'");
            while ($row = pg_fetch_row($result)) {
                $tables[] = $row[1];
            }
        } else {
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }


        foreach ($tables as $table) {
            $table = DBSA . '.' . $table;
            $result = pg_query($this->conn, 'SELECT * FROM ' . $table);
            $numFields = pg_num_fields($result);

            $sql .= "DROP TABLE IF EXISTS " . $table . ";";

            $row2 = pg_fetch_row(pg_query($this->conn, 'SELECT
                                                f.attname AS name
                                        FROM pg_attribute f
                                                 JOIN pg_class c ON c.oid = f.attrelid
                                                 JOIN pg_type t ON t.oid = f.atttypid
                                                 LEFT JOIN pg_attrdef d ON d.adrelid = c.oid AND d.adnum = f.attnum
                                                 LEFT JOIN pg_namespace n ON n.oid = c.relnamespace
                                                 LEFT JOIN pg_constraint p ON p.conrelid = c.oid AND f.attnum = ANY (p.conkey)
                                                 LEFT JOIN pg_class AS g ON p.confrelid = g.oid
                                        WHERE c.relkind = \'r\'::char
                                          AND n.nspname = \'' . DBSA . '\'  -- Replace with Schema name
                                          AND c.relname = \'' . str_replace(DBSA . '.', '', $table) . '\'  -- Replace with table name
                                          AND f.attnum > 0'));


            $sql .= "\n\n\n" . str_replace(strtolower($row2[0]), $row2[0], $row2[1]) . ";\n\n\n";

            for ($i = 0; $i < $numFields; $i++) {
                while ($row = mysqli_fetch_row($result)) {
                    $sql .= 'INSERT INTO ' . $table . ' VALUES(';
                    for ($j = 0; $j < $numFields; $j++) {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = str_replace("\n", "\\n", $row[$j]);
                        if (!empty($row[$j])) {
                            $sql .= "'" . $row[$j] . "'";
                        } else {
                            $sql .= 'NULL';
                        }

                        if ($j < ($numFields - 1)) {
                            $sql .= ',';
                        }
                    }
                    $sql .= ");\n\n";
                }
            }
            $sql .= "\n\n\n";
        }

        return $sql;
    }

    /**
     * Save SQL to file
     * @param string $sql
     * @return bool
     */
    protected function saveFile(&$sql)
    {
        if (!$sql) return false;
        try {
            // 1 = Desenvolvimento, 2 = Teste , 3 = Produção
            $ambi = 'Desenvolvimento';
            if (AMBI == 2) {
                $ambi = 'Teste';
            } elseif (AMBI == 3) {
                $ambi = 'Producao';
            }
            $handle = fopen(PASTABACKUP . 'Backup-' . Valida::ValNome(DESC . '-' . $ambi) . '.sql', 'w+');
            fwrite($handle, $sql);
            fclose($handle);
        } catch (Exception $e) {
            Notificacoes::geraMensagem(
                'Error ao gerar o arquivo de backup. ' . $e->getMessage(),
                TiposMensagemEnum::ERRO
            );
            return false;
        }
        return true;
    }

    /**
     * Realiza o controle da versão
     */
    public function controleVersao()
    {
        $linhas = fopen('versao.txt', "a+");
        $versoes = fgets($linhas);
        $versao = explode('//', $versoes);
        $versaoNova = explode('.', $versao[2]);
        $nova = $versaoNova[0] . '.' . $versaoNova[1] . '.' . ($versaoNova[2] + 1);
        $versao[2] = $nova;
        $versaoAtualizada = implode('//', $versao);
        $backupVersao = fopen('versao.txt', "w");
        fwrite($backupVersao, $versaoAtualizada);
        fclose($backupVersao);
    }

    /**
     * Realiza o controle da versão
     */
    private function limpaArquivoAtualizacaoBanco()
    {
        $AtualizaArqBanco = fopen('BancoDados/Atualizacao.sql', "w");
        fwrite($AtualizaArqBanco, "");
        fclose($AtualizaArqBanco);
    }

    /**
     * Realiza o controle da versão
     */
    private function limpaArquivoBackup()
    {
        $novaData = Valida::CalculaData(date("d/m/Y"), BACKUP, "+");
        $backupCheck = fopen('BancoDados/Backup.txt', "w");
        fwrite($backupCheck, Valida::DataDBDate($novaData) . "//" . Valida::DataAtualBanco());
        fclose($backupCheck);
    }

    /**
     * Realiza o BackUp
     */
    private function gerarBackup()
    {
        $this->limpaArquivoBackup();
        $this->limpaArquivoAtualizacaoBanco();
        $this->charset = 'utf8';
        $this->controleVersao();
        $conn = new ObjetoPDO();
        $this->conn = $conn->inicializarConexao();
        $this->RealizarBackup();
    }

    /**
     * Realiza o BackUp
     */
    public static function getDataUltimoBackup()
    {
        $backup = fopen('BancoDados/Backup.txt', "a+");
        $backupDates = fgets($backup);
        $backupDate = explode('//', $backupDates);
        return $backupDate[1];
    }

    protected function liberaBackup($Tabela)
    {
        $sem_auditoria = explode(', ', SEM_AUDITORIA);
        if (TABELA_AUDITORIA && !in_array(strtoupper($Tabela), $sem_auditoria)) {
            return true;
        }
        return false;
    }
}