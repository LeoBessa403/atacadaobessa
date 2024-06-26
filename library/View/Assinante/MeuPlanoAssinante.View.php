<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- start: PAGE TITLE & BREADCRUMB -->
                <ol class="breadcrumb">
                    <li>
                        <i class="clip-grid-6"></i>
                        <a href="#">
                            Assinante
                        </a>
                    </li>
                    <li class="active">
                        Assinaturas
                    </li>
                </ol>
                <div class="page-header">
                    <h1>Assinante
                        <small>Listar Assinaturas</small>
                        <?php Valida::geraBtnNovo('Renovar Assinatura', 'RenovaPlanoAssinante'); ?>
                    </h1>
                </div>
                <!-- end: PAGE TITLE & BREADCRUMB -->
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php include_once 'DetalhesPagamento.View.php' ?>
                        <i class="fa fa-external-link-square"></i>
                        Assinaturas de Planos
                    </div>
                    <div class="panel-body">
                        <div class="alert alert-block alert-warning fade in col-md-12"
                             style="margin-bottom: 15px;">
                            <h4 class="alert-heading"><i class="fa fa-money"></i> Status de Pagamento</h4>
                            <?php
                            foreach (StatusPagamentoEnum::$descricao as $chave => $desc) {
                                echo '<span class="circle-img label_span label-' . StatusPagamentoEnum::$cores[$chave] . '">';
                                echo '&nbsp;&nbsp;&nbsp;&nbsp;</span> ' . $desc . ' / ';
                            }
                            ?>
                        </div>
                        <?php
                        Modal::load();
                        Modal::confirmacao("confirma_Assinante");
                        $grid = new Grid();
                        if (PerfilService::perfilMaster()) {
                            $arrColunas = array('Assinante', 'Code', 'Status', 'Plano', 'Data Pagamento', 'Meio de Pagamento', 'Valor R$',
                                'Sit. Pagamento', 'Ações');
                        } else {
                            $arrColunas = array('Status', 'Plano', 'Data Pagamento', 'Meio de Pagamento', 'Valor R$',
                                'Sit. Pagamento', 'Expiração', 'Ações');
                        }
                        $grid->setColunasIndeces($arrColunas);
                        $grid->criaGrid();
                        $statusSis = '';
                        /** @var PlanoAssinanteAssinaturaEntidade $res */
                        foreach ($result as $res):
                            $acao = '<button class="btn btn-primary btn-visualizar tooltips" data-coPlanoAssAss="' .
                                $res->getCoPlanoAssinanteAssinatura() . '"  
                                        data-original-title="Visualizar Pagamento" data-placement="top">
                                         <i class="clip-eye"></i>
                                     </button>';
                            if ($res->getCoPlanoAssinante()->getCoPlano()->getCoPlano() > 1) {
                                if ($res->getStPagamento() < 1) {
                                    $acao .= ' <a href="' . PASTAADMIN . 'Assinante/RenovaPlanoAssinante/' .
                                        Valida::GeraParametro(CO_PLANO_ASSINANTE_ASSINATURA . "/" .
                                            $res->getCoPlanoAssinanteAssinatura()) . '"
                                class="btn btn-green tooltips"
                                    data-original-title="Pagar a Renovação da Assinatura" data-placement="top">
                                     <i class="fa fa-money"></i>
                                 </a>';
                                }
                                if ($res->getStPagamento() == StatusPagamentoEnum::AGUARDANDO_PAGAMENTO ||
                                    $res->getStPagamento() == StatusPagamentoEnum::EM_ANALISE) {
                                    if ($res->getTpPagamento() == TipoPagamentoEnum::BOLETO
                                        && $res->getDsLinkBoleto()) {
                                        $acao .= ' <a href="' . $res->getDsLinkBoleto() . '" target="_blank"
                                                    class="btn btn-warning tooltips" 
                                                        data-original-title="Abrir Boleto" data-placement="top">
                                                         <i class="clip-file-pdf"></i>
                                                     </a>';
                                    } elseif ($res->getTpPagamento() == TipoPagamentoEnum::PIX
                                        && $res->getDsLinkBoleto()) {
                                        $acao .= ' <a href="' . $res->getDsLinkBoleto() . '" target="_blank"
                                                    class="btn btn-warning tooltips" 
                                                        data-original-title="Abrir Página do Banco" data-placement="top">
                                                         <i class="clip-banknote"></i>
                                                     </a>';
                                    }
                                }
                                if (PerfilService::perfilMaster() && $res->getStPagamento() > 0) {
                                    if ($res->getStPagamento() == StatusPagamentoEnum::AGUARDANDO_PAGAMENTO ||
                                        $res->getStPagamento() == StatusPagamentoEnum::EM_ANALISE) {
                                        $acao .= ' <a href="' . PASTAADMIN . 'Assinante/CancelarAssinaturaAssinante/' .
                                            Valida::GeraParametro(DS_CODE_TRANSACAO . "/" .
                                                $res->getDsCodeTransacao()) . '" 
                                                class="btn btn-danger tooltips" 
                                                    data-original-title="Cancelar Assinatura do Assinante" data-placement="top">
                                                     <i class="fa fa-trash-o"></i>
                                                 </a>';
                                    } elseif ($res->getStPagamento() == StatusPagamentoEnum::PAGO ||
                                        $res->getStPagamento() == StatusPagamentoEnum::DISPONIVEL ||
                                        $res->getStPagamento() == StatusPagamentoEnum::EM_DISPUTA) {
                                        $acao .= ' <a href="' . PASTAADMIN . 'Assinante/EstornarAssinaturaAssinante/' .
                                            Valida::GeraParametro(DS_CODE_TRANSACAO . "/" .
                                                $res->getDsCodeTransacao()) . '" 
                                class="btn btn-danger tooltips" 
                                    data-original-title="Estornar Assinatura do Assinante" data-placement="top">
                                     <i class="fa fa-trash-o"></i>
                                 </a>';
                                    }
                                }
                            }
                            $dtPagamento = ($res->getDtConfirmaPagamento())
                                ? Valida::DataShow($res->getDtConfirmaPagamento())
                                : null;
                            $tpPagamento = ($res->getTpPagamento())
                                ? TipoPagamentoEnum::getDescricaoValor($res->getTpPagamento())
                                : null;
                            if (PerfilService::perfilMaster()) {
                                $noEmpresa = AssinanteService::getNoEmpresaCoAssinante(
                                    $res->getCoAssinante()->getCoAssinante()
                                );
                                $grid->setColunas($noEmpresa, 3);
                                $grid->setColunas($res->getDsCodeTransacao(), 2);
                            }

                            $spanLabel = '<span class="circle-img label_span label-' .
                                StatusPagamentoEnum::$cores[$res->getStPagamento()] . '">
                                            &nbsp;&nbsp;&nbsp;&nbsp;</span> ';

                            $grid->setColunas(Valida::StatusLabel($res->getStStatus()), 2);
                            $grid->setColunas($res->getCoPlanoAssinante()->getCoPlano()->getNoPlano());
                            $grid->setColunas($dtPagamento, 2);
                            $grid->setColunas($tpPagamento, 4);
                            $grid->setColunas($res->getNuValorAssinatura(), 2);
                            $grid->setColunas($spanLabel .
                                StatusPagamentoEnum::getDescricaoValor($res->getStPagamento()), 3);
                            if (!PerfilService::perfilMaster()) {
                                $grid->setColunas(Valida::DataShow($res->getDtExpiracao()), 2);
                            }
                            $grid->setColunas($acao, 3);
                            $grid->criaLinha($res->getCoPlanoAssinanteAssinatura());
                        endforeach;
                        $grid->finalizaGrid();
                        ?>
                    </div>
                </div>
                <?php
                if (PerfilService::perfilMaster()) {
                    ?>
                    <div class="pull-right">
                        <!-- end: DYNAMIC TABLE PANEL -->
                        <?php Valida::geraBtnVoltar('Assinante/ListarAssinante'); ?>
                    </div>
                    <br><br><br>
                <?php } ?>
                <!-- end: DYNAMIC TABLE PANEL -->
            </div>
        </div>
        <!-- end: PAGE CONTENT-->
    </div>
</div>
<!-- end: PAGE -->