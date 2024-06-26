<?php

/**
 * UsuarioService.class [ SEVICE ]
 * @copyright (c) 2017, Leo Bessa
 */
class  UsuarioService extends AbstractService
{
    private $ObjetoModel;
    private $Email;

    public function __construct()
    {
        parent::__construct(UsuarioEntidade::ENTIDADE);
        $this->ObjetoModel = New UsuarioModel();
    }

    public static function getNoPerfilUsuarioLogado()
    {
        /** @var Session $session */
        $session = new Session();
        if (!$session->CheckSession(SESSION_USER)) {
            return NO_USUARIO_PADRAO;
        } else {
            /** @var Session $us */
            $us = unserialize(serialize($_SESSION[SESSION_USER]));
            $user = $us->getUser();
            return (!empty($user[md5('no_perfis')])) ? $user[md5('no_perfis')] : null;
        }
    }

    public static function getCoUsuarioLogado()
    {
        /** @var Session $session */
        $session = new Session();
        if (!$session->CheckSession(SESSION_USER)) {
            return CO_USUARIO_PADRAO;
        } else {
            /** @var Session $us */
            $us = unserialize(serialize($_SESSION[SESSION_USER]));
            $user = $us->getUser();
            return (!empty($user[md5(CO_USUARIO)])) ? $user[md5(CO_USUARIO)] : null;
        }

    }

    public static function getNoPessoaCoUsuario($coUsuario)
    {
        $UsuarioModel = new UsuarioModel();
        return $UsuarioModel->getNoPessoaCoUsuario($coUsuario);
    }

    public static function getPessoaCoUsuario($coUsuario)
    {
        $UsuarioModel = new UsuarioModel();
        return $UsuarioModel->getPessoaCoUsuario($coUsuario);
    }

    public function PesquisaAvancada($Condicoes)
    {
        return $this->ObjetoModel->PesquisaAvancada($Condicoes);
    }

    public static function PesquisaUsuariosCombo($Condicoes)
    {
        /** @var UsuarioService $usuarioService */
        $usuarioService = new UsuarioService();
        $comboUsuarios = [];
        $usuarios = $usuarioService->PesquisaAvancada($Condicoes);
        /** @var UsuarioEntidade $usuario */
        foreach ($usuarios as $usuario) {
            if ($usuario->getStStatus() == StatusUsuarioEnum::ATIVO) {
                $comboUsuarios[$usuario->getCoUsuario()]
                    = Valida::Resumi(strtoupper($usuario->getCoPessoa()->getNoPessoa()), 25);
            }
        }
        return $comboUsuarios;
    }

    public function salvaUsuario($dados, $foto, $resgistrar = false)
    {
        $usuarioValidador = new UsuarioValidador();
        /** @var PessoaValidador $validador */
        $validador = $usuarioValidador->validarUsuario($dados);
        if ($validador[SUCESSO]) {
            /** @var EnderecoService $enderecoService */
            $enderecoService = $this->getService(ENDERECO_SERVICE);
            /** @var ContatoService $contatoService */
            $contatoService = $this->getService(CONTATO_SERVICE);
            /** @var UsuarioService $usuarioService */
            $usuarioService = $this->getService(USUARIO_SERVICE);
            /** @var PessoaService $pessoaService */
            $pessoaService = $this->getService(PESSOA_SERVICE);
            /** @var ImagemService $imagemService */
            $imagemService = $this->getService(IMAGEM_SERVICE);
            /** @var UsuarioPerfilService $usuarioPerfilService */
            $usuarioPerfilService = $this->getService(USUARIO_PERFIL_SERVICE);
            /** @var PDO $PDO */
            $PDO = $this->getPDO();
            $retorno = [
                SUCESSO => true,
                MSG => null
            ];

            $session = new Session();
            if ($session->CheckSession(SESSION_USER)) {
                /** @var Session $us */
                $us = unserialize(serialize($_SESSION[SESSION_USER]));
                $user = $us->getUser();
                $meusPerfis = $user[md5(CAMPO_PERFIL)];
                $meusPerfis = explode(',', $meusPerfis);
            } else {
                $meusPerfis = array();
            }
            $idCoUsuario = (isset($dados[CO_USUARIO]) ? $dados[CO_USUARIO] : null);

            $endereco = $enderecoService->getDados($dados, EnderecoEntidade::ENTIDADE);
            $contato = $contatoService->getDados($dados, ContatoEntidade::ENTIDADE);
            $pessoa = $pessoaService->getDados($dados, PessoaEntidade::ENTIDADE);
            $pessoa[NO_PESSOA] = strtoupper(trim($dados[NO_PESSOA]));
            $pessoa[DT_NASCIMENTO] = Valida::DataDBDate($dados[DT_NASCIMENTO]);
            $pessoa[ST_SEXO] = $dados[ST_SEXO][0];

            $erro = false;
            $Campo = array();
            /** @var UsuarioEntidade $usuario */
            $usuarios = $usuarioService->PesquisaTodos();

            /** @var UsuarioEntidade $usuario */
            foreach ($usuarios as $usuario) {
                if ($usuario->getCoUsuario() != $idCoUsuario) {
                    if ($usuario->getCoPessoa()->getNoPessoa() == strtoupper($pessoa[NO_PESSOA])) {
                        $Campo[] = "Nome do Usuário";
                        $erro = true;
                    }
                    if ($usuario->getCoPessoa()->getCoContato()->getDsEmail() == $contato[DS_EMAIL]) {
                        $Campo[] = "E-mail";
                        $erro = true;
                    }
                    if ($usuario->getCoPessoa()->getNuCpf() == $pessoa[NU_CPF] && $pessoa[NU_CPF]) {
                        $Campo[] = "CPF";
                        $erro = true;
                    }
                }
                if ($erro) {
                    break;
                }
            }

            if ($erro):
                $session->setSession(MENSAGEM, "Já exite usuário cadastro com o mesmo "
                    . implode(", ", $Campo) . ", Favor Verificar.");
            else:
                $imagem[DS_CAMINHO] = "";
                if ($foto[DS_CAMINHO]["tmp_name"]):
                    $foto = $_FILES[DS_CAMINHO];
                    $nome = Valida::ValNome($dados[NO_PESSOA]);
                    $up = new Upload();
                    $up->UploadImagem($foto, $nome, "usuarios");
                    $imagem[DS_CAMINHO] = $up->getNameImage();
                endif;

                $usu[DS_CODE] = base64_encode(base64_encode($dados[DS_SENHA]));
                $usu[DS_SENHA] = trim($dados[DS_SENHA]);

                if (!empty($dados[ST_STATUS])):
                    $usu[ST_STATUS] = StatusUsuarioEnum::ATIVO;
                else:
                    $usu[ST_STATUS] = StatusUsuarioEnum::INATIVO;
                endif;


                $PDO->beginTransaction();
                $idCoUsuario = (isset($dados[CO_USUARIO])
                    ? $dados[CO_USUARIO]
                    : null);
                $idCoEndereco = (isset($dados[CO_ENDERECO])
                    ? $dados[CO_ENDERECO]
                    : null);
                $idCoContato = (isset($dados[CO_CONTATO])
                    ? $dados[CO_CONTATO]
                    : null);
                $idCoImagem = (isset($dados[CO_IMAGEM])
                    ? $dados[CO_IMAGEM]
                    : null);
                $idCoPessoa = (isset($dados[CO_PESSOA])
                    ? $dados[CO_PESSOA]
                    : null);

                if (!$idCoEndereco) {
                    $pessoa[CO_ENDERECO] = $enderecoService->Salva($endereco);
                } else {
                    $enderecoService->Salva($endereco, $idCoEndereco);
                }
                if (!$idCoContato) {
                    $pessoa[CO_CONTATO] = $contatoService->Salva($contato);
                } else {
                    $contatoService->Salva($contato, $idCoContato);
                }

                if (!$idCoImagem && $imagem[DS_CAMINHO]) {
                    $usu[CO_IMAGEM] = $imagemService->Salva($imagem);
                } elseif ($imagem[DS_CAMINHO]) {
                    $usu[CO_IMAGEM] = $idCoImagem;
                    $imagemService->Salva($imagem, $idCoImagem);
                }
                if (!$idCoPessoa) {
                    $pessoa[DT_CADASTRO] = Valida::DataHoraAtualBanco();
                    $usu[CO_PESSOA] = $pessoaService->Salva($pessoa);
                } else {
                    $usu[CO_PESSOA] = $idCoPessoa;
                    $pessoaService->Salva($pessoa, $idCoPessoa);
                }
                $usu[DT_CADASTRO] = Valida::DataHoraAtualBanco();
                if (PerfilService::perfilMaster()) {
                    $usu[CO_ASSINANTE] = (isset($dados[CO_ASSINANTE])
                        ? $dados[CO_ASSINANTE][0]
                        : null);
                } else {
                    $usu[CO_ASSINANTE] = (isset($dados[CO_ASSINANTE])
                        ? $dados[CO_ASSINANTE]
                        : null);
                }
                $usu[DT_CADASTRO] = Valida::DataHoraAtualBanco();
                if (!$idCoUsuario) {
                    $usuarioPerfil[CO_USUARIO] = $usuarioService->Salva($usu);
                    $dadosEmail = [
                        NO_PESSOA => $pessoa[NO_PESSOA],
                        DS_EMAIL => $contato[DS_EMAIL],
                        NU_TEL1 => $contato[NU_TEL1],
                        DS_SENHA => $usu[DS_SENHA]
                    ];
                    $this->enviaEmailNovoUsuario($dadosEmail, $usuarioPerfil[CO_USUARIO]);
                    $session->setSession(MENSAGEM, CADASTRADO);
                } else {
                    $usuarioService->Salva($usu, $idCoUsuario);
                    $usuarioPerfil[CO_USUARIO] = $idCoUsuario;
                    $session->setSession(MENSAGEM, ATUALIZADO);
                }
                $retorno = $idCoUsuario;

                // REGISTRAR ///
                if (!empty($dados['ds_perfil'])) {
                    $usuarioPerfilService->DeletaQuando([
                        CO_USUARIO => $idCoUsuario
                    ]);
                    foreach ($dados['ds_perfil'] as $perfil) {
                        if ($perfil != PERFIL_USUARIO_PADRAO) {
                            $usuarioPerfil[CO_PERFIL] = $perfil;
                            $usuarioPerfilService->Salva($usuarioPerfil);
                        }
                    }
                    $usuarioPerfil[CO_PERFIL] = PERFIL_USUARIO_PADRAO;
                    $retorno = $usuarioPerfilService->Salva($usuarioPerfil);
                }
                if ($retorno) {
                    $PDO->commit();
                } else {
                    $retorno[MSG] = 'Não foi possível Salvar o Usuário';
                    $PDO->rollBack();
                }

                if (!$resgistrar) {
                    if (in_array(1, $meusPerfis) || in_array(2, $meusPerfis)) {
                        Redireciona(UrlAmigavel::$modulo . '/' . UrlAmigavel::$controller . '/ListarUsuario/');
                    } else {
                        Redireciona(UrlAmigavel::$modulo . '/Index/Index/');
                    }
                } else {
                    Redireciona('admin/Index/Acessar/' . Valida::GeraParametro('acesso/C'));
                }
            endif;
        } else {
            Notificacoes::geraMensagem(
                $validador[MSG],
                TiposMensagemEnum::ALERTA
            );
            $retorno = $validador;
        }

        return $retorno;
    }

    public function TrocaSenha($dados)
    {
        /** @var UsuarioService $usuarioService */
        $usuarioService = $this->getService(USUARIO_SERVICE);
        $retorno = [
            SUCESSO => true,
            MSG => null
        ];
        $session = new Session();
        /** @var UsuarioValidador $usuarioValidador */
        $usuarioValidador = new UsuarioValidador();
        $validador = $usuarioValidador->validarTrocaSenha($dados);
        if ($validador[SUCESSO]) {

            $idCoUsuario = (isset($dados[CO_USUARIO]) ? $dados[CO_USUARIO] : null);
            if ($idCoUsuario) {
                /** @var UsuarioEntidade $user */
                $user = $usuarioService->PesquisaUmRegistro($idCoUsuario);

                if ($user->getDsSenha() != $dados['ds_senha_antiga']) {
                    Notificacoes::geraMensagem(
                        "Senha Antiga não está correta. Favor Verificar",
                        TiposMensagemEnum::ALERTA
                    );
                    $retorno = [
                        SUCESSO => false
                    ];
                    return $retorno;
                }
            }

            $usuario[DS_CODE] = base64_encode(base64_encode(trim($dados[DS_SENHA])));
            $usuario[DS_SENHA] = trim($dados[DS_SENHA]);
            $usuario[ST_TROCA_SENHA] = SimNaoEnum::SIM;

            $session->setSession(MENSAGEM, ATUALIZADO);
            $session->setSession(ST_TROCA_SENHA, "OK");
            $this->Salva($usuario, $idCoUsuario);
        } else {
            Notificacoes::geraMensagem(
                $validador[MSG],
                TiposMensagemEnum::ALERTA
            );
            $retorno = $validador;
        }

        return $retorno;
    }

    /**
     * @param $dados
     * @return int
     */
    public function PesquisaUsuarioLogar($dados)
    {
        return $this->ObjetoModel->PesquisaUsuarioLogar($dados);
    }

    /**
     * Salva o Usuário para logar inicialmente no sistema
     * @param $coPessoa
     * @param $dadosEmail
     * @param null $coAssinante
     * @return bool|INT CoUsuario
     */
    public function salvaUsuarioInicial($coPessoa, $dadosEmail, $coAssinante = null)
    {
        $usuario[CO_ASSINANTE] = ($coAssinante) ? $coAssinante : AssinanteService::getCoAssinanteLogado();
        $usuario[CO_PESSOA] = $coPessoa;
        $usuario[DS_SENHA] = trim(Valida::GeraCodigo());
        $usuario[DS_CODE] = base64_encode(base64_encode($usuario[DS_SENHA]));
        $usuario[ST_STATUS] = StatusUsuarioEnum::INATIVO;
        $usuario[DT_CADASTRO] = Valida::DataHoraAtualBanco();

        $coUsuario = $this->Salva($usuario);

        $dadosEmail[DS_SENHA] = $usuario[DS_SENHA];
        $dados[CO_USUARIO] = $coUsuario;
        $dados['dados'] = $dadosEmail;

        return $dados;
    }

    /**
     * @param array $dadosEmail
     * @param Int $coUsuario
     */
    public function enviaEmailNovoUsuario(array $dadosEmail, $coUsuario)
    {
        if ($coUsuario) {

            $whats = new WhatsAppService();
//            $retWhats = $whats->enviaMsgUsuarioInicial($dadosEmail, $coUsuario);

            /** @var Email $email */
            $email = new Email();

            // Índice = Nome, e Valor = Email.
            $emails = array(
                $dadosEmail[NO_PESSOA] => (PROD) ? $dadosEmail[DS_EMAIL] : USER_EMAIL
            );
            $Mensagem = "<h3>Olá " . $dadosEmail[NO_PESSOA] . ", Seu cadastro no " . DESC . " foi realizado com sucesso.</h3>";
            $Mensagem .= "<p>Sua senha é: <b>" . $dadosEmail[DS_SENHA] . ".</b></p>";
            $Mensagem .= "<p>Acesso o link para a <a href='" . HOME . "admin/Index/AtivacaoUsuario/" .
                Valida::GeraParametro(CO_USUARIO . "/" . $coUsuario) . "'>ATIVAÇÃO DO CADASTRO</a></p><br>";

            $email->setEmailDestinatario($emails)
                ->setTitulo(DESC . " - Ativação do seu cadastro")
                ->setMensagem($Mensagem);

            // Variável para validação de Emails Enviados com Sucesso.
            $this->Email = $email->Enviar();
        } else {
            Notificacoes::geraMensagem(
                "Confirmação da Ativação não enviada!",
                TiposMensagemEnum::INFORMATIVO
            );
        }
    }
}