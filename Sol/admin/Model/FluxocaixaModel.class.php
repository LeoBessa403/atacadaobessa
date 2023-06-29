<?php

/**
 * FluxoCaixaModel.class [ MODEL ]
 * @copyright (c) 2021, Leo Bessa
 */
class  FluxocaixaModel extends AbstractModel
{

    public function __construct()
    {
        parent::__construct(FluxocaixaEntidade::ENTIDADE);
    }

    public function PesquisaAvancada($where)
    {
        $tabela = FluxocaixaEntidade::TABELA . " tfc" .
            " left join " . RepresentacaoEntidade::TABELA . " rep" .
            " on rep." . RepresentacaoEntidade::CHAVE . " = tfc." . RepresentacaoEntidade::CHAVE .
            " left join " . CentroCustoEntidade::TABELA . " cen" .
            " on cen." . CentroCustoEntidade::CHAVE . " = tfc." . CentroCustoEntidade::CHAVE .
            " left join " . ContaBancariaEntidade::TABELA . " con" .
            " on con." . ContaBancariaEntidade::CHAVE . " = tfc." . ContaBancariaEntidade::CHAVE .
            " left join " . CategoriaFcNetaEntidade::TABELA . " ctn" .
            " on ctn." . CategoriaFcNetaEntidade::CHAVE . " = tfc." . CategoriaFcNetaEntidade::CHAVE;


        $campos = "tfc.co_fluxo_caixa, tfc.dt_realizado, tfc.dt_vencimento, tfc.nu_valor, tfc.nu_valor_pago, tfc.st_pagamento, 
        cen.no_centro_custos, rep.no_representacao, ctn.ds_texto as no_neta, ctn.nu_codigo as nu_codigo_n,
        tfc.tp_fluxo, tfc.dt_cadastro, tfc.tp_pagamento, con.no_banco";
        $pesquisa = new Pesquisa();
        $where = $where . ' ORDER BY ' . FluxocaixaEntidade::CHAVE . ' DESC LIMIT 100';
        $pesquisa->Pesquisar($tabela, $where, null, $campos);

        return $pesquisa->getResult();
    }

    public function PesquisaAvancadaFC($where)
    {
        $tabela = FluxocaixaEntidade::TABELA . " tfc" .
            " left join " . RepresentacaoEntidade::TABELA . " rep" .
            " on rep." . RepresentacaoEntidade::CHAVE . " = tfc." . RepresentacaoEntidade::CHAVE .
            " left join " . CentroCustoEntidade::TABELA . " cen" .
            " on cen." . CentroCustoEntidade::CHAVE . " = tfc." . CentroCustoEntidade::CHAVE .
            " left join " . ContaBancariaEntidade::TABELA . " con" .
            " on con." . ContaBancariaEntidade::CHAVE . " = tfc." . ContaBancariaEntidade::CHAVE .
            " left join " . CategoriaFcEntidade::TABELA . " cat" .
            " on cat." . CategoriaFcEntidade::CHAVE . " = tfc." . CategoriaFcEntidade::CHAVE .
            " left join " . CategoriaFcFilhaEntidade::TABELA . " ctf" .
            " on ctf." . CategoriaFcFilhaEntidade::CHAVE . " = tfc." . CategoriaFcFilhaEntidade::CHAVE .
            " left join " . CategoriaFcNetaEntidade::TABELA . " ctn" .
            " on ctn." . CategoriaFcNetaEntidade::CHAVE . " = tfc." . CategoriaFcNetaEntidade::CHAVE;


        $campos = "tfc.dt_realizado, tfc.dt_vencimento, tfc.nu_valor, tfc.nu_valor_pago, tfc.st_pagamento, 
        tfc.co_categoria_fc, tfc.co_categoria_fc_filha, tfc.co_categoria_fc_neta, 
        ctf.ds_texto as no_filha,  ctf.nu_codigo as nu_codigo_f, ctn.ds_texto as no_neta, ctn.nu_codigo as nu_codigo_n";
        $pesquisa = new Pesquisa();
        $where = $where . ' ORDER BY cat.' . CategoriaFcEntidade::CHAVE . ', ctf.' . CategoriaFcFilhaEntidade::CHAVE . ', 
        ctn.' . CategoriaFcNetaEntidade::CHAVE . ', dt_realizado, dt_vencimento ASC';
        $pesquisa->Pesquisar($tabela, $where, null, $campos);

        return $pesquisa->getResult();
    }


    public function PesquisaAvancadaValorPesquisa()
    {
        $campos = "max(nu_valor) as maior_valor, min(nu_valor) as menor_valor, 
        max(nu_valor_pago) as maior_valor_pago, max(nu_valor_pago) as menor_valor_pago";
        $pesquisa = new Pesquisa();
        $where = ' ORDER BY ' . FluxocaixaEntidade::CHAVE . ' DESC LIMIT 200';
        $pesquisa->Pesquisar(FluxocaixaEntidade::TABELA, $where, null, $campos);

        return $pesquisa->getResult()[0];
    }


    public function PesquisaAvancadaFCGrafico1($where)
    {
        $tabela = FluxocaixaEntidade::TABELA . ' tfi
                inner join TB_CATEGORIA_FC_NETA tcn
                on tcn.co_categoria_fc_neta = tfi.co_categoria_fc_neta';

        $campos = "tcn.ds_texto, SUM(nu_valor_pago) as total";
        $pesquisa = new Pesquisa();
        $where = $where . ' GROUP BY tfi.co_categoria_fc_neta ORDER BY total DESC LIMIT 6';
        $pesquisa->Pesquisar($tabela, $where, null, $campos);

        return $pesquisa->getResult();
    }

    public function PesquisaAvancadaFCGrafico2($where)
    {
        $tabela = FluxocaixaEntidade::TABELA . ' tfi
                inner join TB_CATEGORIA_FC_FILHA tcn
                on tcn.co_categoria_fc_filha = tfi.co_categoria_fc_filha';

        $campos = "tcn.ds_texto, SUM(nu_valor_pago) as total, tfi.co_categoria_fc_filha";
        $pesquisa = new Pesquisa();
        $where = $where . ' GROUP BY tfi.co_categoria_fc_filha ORDER BY total DESC LIMIT 6';
        $pesquisa->Pesquisar($tabela, $where, null, $campos);

        return $pesquisa->getResult();
    }

    public function PesquisaAvancadaFCGrafico3($where)
    {
        $campos = "distinct 
                        (SELECT
                             sum(nu_valor_pago)
                         FROM
                             " . FluxocaixaEntidade::TABELA . "
                         WHERE co_categoria_fc in(2,3) " . $where . ") AS despesas,
                        (SELECT
                             sum(f2.nu_valor_pago)
                         FROM " . FluxocaixaEntidade::TABELA . " f2
                         WHERE co_categoria_fc in(1) " . $where . ") AS recebimentos";
        $pesquisa = new Pesquisa();
        $pesquisa->Pesquisar(FluxocaixaEntidade::TABELA, null, null, $campos);

        return $pesquisa->getResult();
    }

    public function PesquisaAvancadaFCGrafico4($where)
    {
        $campos = "distinct 
                        (SELECT
                             sum(nu_valor)
                         FROM
                             " . FluxocaixaEntidade::TABELA . "
                         WHERE co_categoria_fc in(2,3) " . $where . ") AS despesas,
                        (SELECT
                             sum(f2.nu_valor)
                         FROM " . FluxocaixaEntidade::TABELA . " f2
                         WHERE co_categoria_fc in(1) " . $where . ") AS recebimentos";
        $pesquisa = new Pesquisa();
        $pesquisa->Pesquisar(FluxocaixaEntidade::TABELA, null, null, $campos);

        return $pesquisa->getResult();
    }

    public function PesquisaAvancadaFCGrafico5()
    {
        $campos = "sum(nu_saldo) as saldo_geral";
        $where = 'where co_hist_saldo_cb in (SELECT max(hs.co_hist_saldo_cb)
                            FROM ' . HistSaldoCbEntidade::TABELA . ' hs
                                     inner join ' . ContaBancariaEntidade::TABELA . ' tcb
                            on hs.co_conta_bancaria = tcb.co_conta_bancaria
                            where ' . CO_ASSINANTE . ' in (' . AssinanteService::getCoAssinanteLogado() . ')
                          group by hs.co_conta_bancaria)';
        $pesquisa = new Pesquisa();
        $pesquisa->Pesquisar(HistSaldoCbEntidade::TABELA, $where, null, $campos);

        return $pesquisa->getResult()[0];
    }


}