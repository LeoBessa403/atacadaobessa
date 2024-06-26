<?php

class Usuario extends AbstractController
{
    public $form;
    public $result;
    public $perfis;
    public $PDO;

    public function Index()
    {
    }

    public function MeuPerfilUsuario()
    {
        $idUsuario = UsuarioService::getCoUsuarioLogado();
        Redireciona('admin/Usuario/CadastroUsuario/' . Valida::GeraParametro(CO_USUARIO . '/' . $idUsuario));
    }

    public function CadastroUsuario()
    {
        /** @var UsuarioService $usuarioService */
        $usuarioService = $this->getService(USUARIO_SERVICE);

        $id = "CadastroUsuario";
        $id2 = "ValidacaoPessoa";
        $idCoUsuario = false;
        $cadastro = false;

        if (!empty($_POST[$id])):
            $usuarioService->salvaUsuario($_POST, $_FILES);
        elseif (!empty($_POST[$id2])) :
            $cadastro = true;
            $PessoaValidador = new PessoaValidador();
            /** @var PessoaValidador $validador */
            $validador = $PessoaValidador->validarCPF($_POST);
            if ($validador[SUCESSO]) {
                /** @var PessoaService $pessoaService */
                $pessoaService = static::getServiceStatic(PESSOA_SERVICE);
                /** @var PessoaEntidade $pessoa */
                $pessoa = $pessoaService->PesquisaUmQuando([
                    NU_CPF => Valida::RetiraMascara($_POST[NU_CPF])
                ]);
                if ($pessoa) {
                    if ($pessoa->getCoUsuario()) {
                        $idCoUsuario = $pessoa->getCoUsuario()->getCoUsuario();
                    }
                }
            } else {
                Notificacoes::geraMensagem(
                    $validador[MSG],
                    TiposMensagemEnum::ALERTA
                );
                $this->form = PessoaForm::ValidarCPF(4);
            }
        endif;

        if (!$idCoUsuario):
            $idCoUsuario = UrlAmigavel::PegaParametro(CO_USUARIO);
        endif;
        $res = array();
        if ($idCoUsuario):
            /** @var UsuarioEntidade $usuario */
            $usuario = $usuarioService->PesquisaUmRegistro($idCoUsuario);


            $res['ds_senha_confirma'] = $usuario->getDsSenha();
            $res[DS_SENHA] = $usuario->getDsSenha();
            $res[CO_IMAGEM] = null;

            if (!empty($usuario->getCoImagem())):
                if ($usuario->getCoImagem()->getDsCaminho()):
                    $res[DS_CAMINHO] = "usuarios/" . $usuario->getCoImagem()->getDsCaminho();
                    $res[CO_IMAGEM] = "usuarios/" . $usuario->getCoImagem()->getCoImagem();
                endif;
            endif;
            $res[CO_USUARIO] = $usuario->getCoUsuario();
            $res[CO_PESSOA] = $usuario->getCoPessoa()->getCoPessoa();
            $res[CO_CONTATO] = $usuario->getCoPessoa()->getCoContato()->getCoContato();
            $res[NO_PESSOA] = $usuario->getCoPessoa()->getNoPessoa();
            $res[DS_EMAIL] = $usuario->getCoPessoa()->getCoContato()->getDsEmail();
            $res[ST_SEXO] = $usuario->getCoPessoa()->getStSexo();
            $res[ST_STATUS] = $usuario->getStStatus();

            $res[NU_CPF] = $usuario->getCoPessoa()->getNuCpf();
            $res[NU_RG] = $usuario->getCoPessoa()->getNuRg();
            if (!empty($usuario->getCoPessoa()->getDtNascimento())):
                $res[DT_NASCIMENTO] = Valida::DataShow($usuario->getCoPessoa()->getDtNascimento());
            endif;
            $res[NU_TEL1] = $usuario->getCoPessoa()->getCoContato()->getNuTel1();
            $res[NU_TEL2] = $usuario->getCoPessoa()->getCoContato()->getNuTel2();
            $res[CO_ASSINANTE] = $usuario->getCoAssinante();

            if (!empty($usuario->getCoPessoa()->getCoEndereco())):
                /** @var EnderecoService $enderecoService */
                $enderecoService = $this->getService(ENDERECO_SERVICE);
                $res = $enderecoService->getArrayDadosEndereco($usuario->getCoPessoa()->getCoEndereco(), $res);
            endif;
            $this->form = UsuarioForm::Cadastrar($res, false, 6);
        else:
            if ($cadastro):
                $res[NU_CPF] = $_POST[NU_CPF];
                $res[CO_ASSINANTE] = AssinanteService::getCoAssinanteLogado();
                $res[CO_USUARIO] = null;
                $res[CO_PESSOA] = null;
                $res[CO_CONTATO] = null;
                $res[CO_IMAGEM] = null;
                $res[CO_ENDERECO] = null;
                
                $this->form = UsuarioForm::Cadastrar($res, true, 6);
            else:
                $this->form = PessoaForm::ValidarCPF(4);
            endif;
        endif;
    }

    public function TrocaSenhaUsuario()
    {
        /** @var UsuarioService $usuarioService */
        $usuarioService = $this->getService(USUARIO_SERVICE);
        $id = "TrocaSenha";
        if (!empty($_POST[$id])):
            $retorno = $usuarioService->TrocaSenha($_POST);
            if ($retorno[SUCESSO]) {
                Redireciona(UrlAmigavel::$modulo . '/Index/Index/');
            }
        endif;

        $idUsuario = UsuarioService::getCoUsuarioLogado();
        $this->form = UsuarioForm::TrocaSenha($idUsuario);
    }

    public function ListarUsuario()
    {
        /** @var UsuarioService $usuarioService */
        $usuarioService = $this->getService(USUARIO_SERVICE);

        $Condicoes = array();
        $session = new Session();

        if ($session->CheckSession(PESQUISA_AVANCADA)) {
            $session->FinalizaSession(PESQUISA_AVANCADA);
        }
        $Condicoes['usu.' . CO_ASSINANTE] = AssinanteService::getCoAssinanteLogado();
        if (!empty($_POST)) {
            $Condicoes = array(
                "pes." . NO_PESSOA => trim($_POST[NO_PESSOA]),
                "pes." . NU_CPF => Valida::RetiraMascara($_POST[NU_CPF]),
            );
            $session->setSession(PESQUISA_AVANCADA, $Condicoes);
            $this->result = $usuarioService->PesquisaAvancada($Condicoes);
        } else {
            $this->result = $usuarioService->PesquisaAvancada($Condicoes);
        }

        /** @var UsuarioEntidade $value */
        foreach ($this->result as $value):
            $this->perfis[$value->getCoUsuario()] = implode(', ', PerfilService::montaComboPerfil($value));
        endforeach;
    }

    // AÇÃO DE EXPORTAÇÃO
    public function ExportarListarUsuario()
    {
        /** @var UsuarioService $usuarioService */
        $usuarioService = $this->getService(USUARIO_SERVICE);

        $session = new Session();
        if ($session->CheckSession(PESQUISA_AVANCADA)) {
            $Condicoes = $session->getSession(PESQUISA_AVANCADA);
            $result = $usuarioService->PesquisaAvancada($Condicoes);
        } else {
            $result = $usuarioService->PesquisaTodos();
        }
        $formato = UrlAmigavel::PegaParametro("formato");
        $i = 0;
        /** @var UsuarioEntidade $value */
        foreach ($result as $value) {
            $res[$i][NO_PESSOA] = $value->getCoPessoa()->getNoPessoa();
            $res[$i][NU_CPF] = Valida::MascaraCpf($value->getCoPessoa()->getNuCpf());
            $res[$i][ST_STATUS] = Valida::SituacaoAtivoInativo($value->getStStatus());
            $i++;
        }
        $Colunas = array('Nome', 'CPF', 'Status');
        $exporta = new Exportacao($formato);
        // $exporta->setPapelOrientacao("paisagem");
        $exporta->setColunas($Colunas);
        $exporta->setConteudo($res);
        $exporta->GeraArquivo();
    }

    public function ListarUsuarioPesquisaAvancada()
    {
        echo UsuarioForm::Pesquisar();
    }

}

?>
   