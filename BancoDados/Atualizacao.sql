INSERT INTO TB_SUPORTE (dt_cadastro, ds_assunto, st_tipo_assunto, co_assinante) VALUES ("2024-06-10 23:52:09", "dwdwdw", "1", "12");

INSERT INTO sol.TB_IMAGEM (ds_caminho) VALUES ("suporte-1-6667bbda04ea5.PNG");

INSERT INTO TB_HISTORICO_SUPORTE (co_suporte, dt_cadastro, ds_mensagem, st_lido, co_usuario, co_imagem) VALUES ("1", "2024-06-10 23:52:09", "<p>dd oidslkakdlsa d</p>", "N", "13", "5");

INSERT INTO sol.TB_ENDERECO (ds_endereco) VALUES ("");

UPDATE sol.TB_EMPRESA SET co_endereco = "6" where co_empresa = 14;

INSERT INTO sol.TB_CONTATO (ds_email, nu_tel1) VALUES ("leonardomcbessa@gmail.com", "61993274991");

INSERT INTO sol.TB_PESSOA (no_pessoa, co_contato, dt_cadastro) VALUES ("Rodrigo", "16", "2024-06-11 14:56:30");

INSERT INTO sol.TB_EMPRESA (no_fantasia, dt_cadastro) VALUES ("Arm. e Papelaria Rosa de Saron", "2024-06-11 14:56:30");

INSERT INTO TB_ASSINANTE (tp_assinante, co_pessoa, co_empresa, dt_cadastro, dt_expiracao) VALUES ("M", "16", "15", "2024-06-11 14:56:30", "2024-12-11");

INSERT INTO sol.TB_USUARIO (co_assinante, co_pessoa, ds_senha, ds_code, st_status, dt_cadastro) VALUES ("13", "16", "PQK8FST9", "VUZGTE9FWlRWRGs9", "A", "2024-06-11 14:56:30");

INSERT INTO TB_PLANO_ASSINANTE_ASSINATURA (co_plano_assinante, co_assinante, nu_filiais, nu_valor_assinatura, tp_pagamento, dt_cadastro, dt_expiracao, co_plano_assinante_assinatura_ativo, st_pagamento, dt_modificado, st_status) VALUES ("11", "13", "0", "487.00", "9", "2024-06-11 14:56:30", "2025-06-11", "11"_assinatura_ativo, "3", "2024-06-11 14:56:30", "A");

INSERT INTO TB_HISTORICO_PAG_ASSINATURA (co_plano_assinante_assinatura, dt_cadastro, ds_acao, ds_usuario, st_pagamento) VALUES ("13", "2024-06-11 14:56:30", "Cadastro no Sistema", "Leo Bessa Fez o Cadastro", "3");

INSERT INTO sol.TB_USUARIO_PERFIL (co_perfil, co_usuario) VALUES ("2", "14");

INSERT INTO sol.TB_CONTATO (ds_email, nu_tel1) VALUES ("leonardomcbessa@gmail.com", "61993274991");

INSERT INTO sol.TB_PESSOA (no_pessoa, co_contato, dt_cadastro) VALUES ("LEONARDO MACHADO CARVALHO BESSA", "17", "2024-06-11 15:03:13");

INSERT INTO sol.TB_EMPRESA (no_fantasia, dt_cadastro) VALUES ("LEONARDO MACHADO CARVALHO BESSA", "2024-06-11 15:03:13");

INSERT INTO TB_ASSINANTE (tp_assinante, co_pessoa, co_empresa, dt_cadastro, dt_expiracao) VALUES ("M", "17", "16", "2024-06-11 15:03:13", "2024-12-11");

INSERT INTO sol.TB_USUARIO (co_assinante, co_pessoa, ds_senha, ds_code, st_status, dt_cadastro) VALUES ("14", "17", "GPF1JHK0", "UjFCR01VcElTekE9", "A", "2024-06-11 15:03:13");

INSERT INTO TB_PLANO_ASSINANTE_ASSINATURA (co_plano_assinante, co_assinante, nu_filiais, nu_valor_assinatura, tp_pagamento, dt_cadastro, dt_expiracao, co_plano_assinante_assinatura_ativo, st_pagamento, dt_modificado, st_status) VALUES ("11", "14", "0", "487.00", "9", "2024-06-11 15:03:13", "2025-06-11", "11"_assinatura_ativo, "3", "2024-06-11 15:03:13", "A");

INSERT INTO TB_HISTORICO_PAG_ASSINATURA (co_plano_assinante_assinatura, dt_cadastro, ds_acao, ds_usuario, st_pagamento) VALUES ("14", "2024-06-11 15:03:13", "Cadastro no Sistema", "Leo Bessa Fez o Cadastro", "3");

INSERT INTO sol.TB_USUARIO_PERFIL (co_perfil, co_usuario) VALUES ("2", "15");

INSERT INTO sol.TB_CONTATO (ds_email, nu_tel1) VALUES ("leonardomcbessa@gmail.com", "61993274991");

INSERT INTO sol.TB_PESSOA (no_pessoa, co_contato, dt_cadastro) VALUES ("LEONARDO MACHADO CARVALHO BESSA", "18", "2024-06-11 15:08:06");

INSERT INTO sol.TB_EMPRESA (no_fantasia, dt_cadastro) VALUES ("LEONARDO MACHADO CARVALHO BESSA", "2024-06-11 15:08:06");

INSERT INTO TB_ASSINANTE (tp_assinante, co_pessoa, co_empresa, dt_cadastro, dt_expiracao) VALUES ("M", "18", "17", "2024-06-11 15:08:06", "2024-09-11");

INSERT INTO sol.TB_USUARIO (co_assinante, co_pessoa, ds_senha, ds_code, st_status, dt_cadastro) VALUES ("15", "18", "CFG1JRO0", "UTBaSE1VcFNUekE9", "A", "2024-06-11 15:08:06");

INSERT INTO TB_PLANO_ASSINANTE_ASSINATURA (co_plano_assinante, co_assinante, nu_filiais, nu_valor_assinatura, tp_pagamento, dt_cadastro, dt_expiracao, co_plano_assinante_assinatura_ativo, st_pagamento, dt_modificado, st_status) VALUES ("12", "15", "0", "247.00", "9", "2024-06-11 15:08:06", "2024-12-11", "12"_assinatura_ativo, "3", "2024-06-11 15:08:06", "A");

INSERT INTO TB_HISTORICO_PAG_ASSINATURA (co_plano_assinante_assinatura, dt_cadastro, ds_acao, ds_usuario, st_pagamento) VALUES ("15", "2024-06-11 15:08:06", "Cadastro no Sistema", "Leo Bessa Fez o Cadastro", "3");

INSERT INTO sol.TB_USUARIO_PERFIL (co_perfil, co_usuario) VALUES ("2", "16");

UPDATE sol.TB_USUARIO SET st_status = "A" where co_usuario = 16;

INSERT INTO sol.TB_CONTATO (ds_email, nu_tel1) VALUES ("leonardomcbessa@gmail.com", "61993274991");

INSERT INTO sol.TB_PESSOA (no_pessoa, co_contato, dt_cadastro) VALUES ("MARIA KARLENE RAMOS LIMA", "19", "2024-06-11 15:14:39");

INSERT INTO sol.TB_EMPRESA (no_fantasia, dt_cadastro) VALUES ("Arm. e Papelaria Rosa de Saron", "2024-06-11 15:14:39");

INSERT INTO TB_ASSINANTE (tp_assinante, co_pessoa, co_empresa, dt_cadastro, dt_expiracao) VALUES ("M", "19", "18", "2024-06-11 15:14:39", "2024-12-11");

INSERT INTO sol.TB_USUARIO (co_assinante, co_pessoa, ds_senha, ds_code, st_status, dt_cadastro) VALUES ("16", "19", "DJM2MAK4", "UkVwTk1rMUJTelE9", "A", "2024-06-11 15:14:39");

INSERT INTO TB_PLANO_ASSINANTE_ASSINATURA (co_plano_assinante, co_assinante, nu_filiais, nu_valor_assinatura, tp_pagamento, dt_cadastro, dt_expiracao, co_plano_assinante_assinatura_ativo, st_pagamento, dt_modificado, st_status) VALUES ("11", "16", "0", "487.00", "9", "2024-06-11 15:14:39", "2025-06-11", "11"_assinatura_ativo, "3", "2024-06-11 15:14:40", "A");

INSERT INTO TB_HISTORICO_PAG_ASSINATURA (co_plano_assinante_assinatura, dt_cadastro, ds_acao, ds_usuario, st_pagamento) VALUES ("16", "2024-06-11 15:14:40", "Cadastro no Sistema", "Leo Bessa Fez o Cadastro", "3");

INSERT INTO sol.TB_USUARIO_PERFIL (co_perfil, co_usuario) VALUES ("2", "17");

INSERT INTO sol.TB_CONTATO (ds_email, nu_tel1) VALUES ("ramos.amaury96@gmail.com", "61993274991");

INSERT INTO sol.TB_PESSOA (no_pessoa, co_contato, dt_cadastro) VALUES ("AMAURY COSTA SILVA RAMOS", "20", "2024-06-11 15:19:47");

INSERT INTO sol.TB_EMPRESA (no_fantasia, dt_cadastro) VALUES ("AMAURY COSTA SILVA RAMOS", "2024-06-11 15:19:47");

INSERT INTO TB_ASSINANTE (tp_assinante, co_pessoa, co_empresa, dt_cadastro, dt_expiracao) VALUES ("M", "20", "19", "2024-06-11 15:19:47", "2025-06-11");

INSERT INTO sol.TB_USUARIO (co_assinante, co_pessoa, ds_senha, ds_code, st_status, dt_cadastro) VALUES ("17", "20", "JUA4MQT2", "U2xWQk5FMVJWREk9", "A", "2024-06-11 15:19:47");

INSERT INTO TB_PLANO_ASSINANTE_ASSINATURA (co_plano_assinante, co_assinante, nu_filiais, nu_valor_assinatura, tp_pagamento, dt_cadastro, dt_expiracao, co_plano_assinante_assinatura_ativo, st_pagamento, dt_modificado, st_status) VALUES ("10", "17", "0", "997.00", "9", "2024-06-11 15:19:47", "2026-06-11", "10"_assinatura_ativo, "3", "2024-06-11 15:19:47", "A");

INSERT INTO TB_HISTORICO_PAG_ASSINATURA (co_plano_assinante_assinatura, dt_cadastro, ds_acao, ds_usuario, st_pagamento) VALUES ("17", "2024-06-11 15:19:47", "Cadastro no Sistema", "Leo Bessa Fez o Cadastro", "3");

INSERT INTO sol.TB_USUARIO_PERFIL (co_perfil, co_usuario) VALUES ("2", "18");

INSERT INTO sol.TB_CONTATO (ds_email, nu_tel1) VALUES ("leonardomcbessa@gmail.com", "61993274991");

INSERT INTO sol.TB_PESSOA (no_pessoa, co_contato, dt_cadastro) VALUES ("Leonardo Bessa", "21", "2024-06-11 15:21:40");

INSERT INTO sol.TB_EMPRESA (no_fantasia, dt_cadastro) VALUES ("Leonardo Bessa", "2024-06-11 15:21:40");

INSERT INTO TB_ASSINANTE (tp_assinante, co_pessoa, co_empresa, dt_cadastro, dt_expiracao) VALUES ("M", "21", "20", "2024-06-11 15:21:40", "2024-09-11");

INSERT INTO sol.TB_USUARIO (co_assinante, co_pessoa, ds_senha, ds_code, st_status, dt_cadastro) VALUES ("18", "21", "IWB5YHL8", "U1ZkQ05WbElURGc9", "A", "2024-06-11 15:21:40");

INSERT INTO TB_PLANO_ASSINANTE_ASSINATURA (co_plano_assinante, co_assinante, nu_filiais, nu_valor_assinatura, tp_pagamento, dt_cadastro, dt_expiracao, co_plano_assinante_assinatura_ativo, st_pagamento, dt_modificado, st_status) VALUES ("12", "18", "0", "247.00", "9", "2024-06-11 15:21:40", "2024-12-11", "12"_assinatura_ativo, "3", "2024-06-11 15:21:40", "A");

INSERT INTO TB_HISTORICO_PAG_ASSINATURA (co_plano_assinante_assinatura, dt_cadastro, ds_acao, ds_usuario, st_pagamento) VALUES ("18", "2024-06-11 15:21:40", "Cadastro no Sistema", "Leo Bessa Fez o Cadastro", "3");

INSERT INTO sol.TB_USUARIO_PERFIL (co_perfil, co_usuario) VALUES ("2", "19");

UPDATE sol.TB_FUNCIONALIDADE SET no_funcionalidade = "Cadastro Assinante", ds_action = "CadastroAssinante", st_menu = "N", co_controller = "12" where co_funcionalidade = 41;

DELETE FROM sol.TB_PERFIL_FUNCIONALIDADE where co_funcionalidade in (41);

UPDATE TB_HISTORICO_SUPORTE SET st_lido = "S" where co_historico_suporte = 1;

INSERT INTO sol.TB_IMAGEM (ds_caminho) VALUES ("suporte-1-6668aaa25af29.jpg");

INSERT INTO TB_HISTORICO_SUPORTE (co_suporte, dt_cadastro, ds_mensagem, st_lido, co_usuario, co_imagem) VALUES ("1", "2024-06-11 16:50:58", "<p>Estamos trabalhando para melhor Receber</p>", "N", "1", "6");

UPDATE TB_CATEGORIA_FC_FILHA SET ds_texto = "Investimentos em Desenvolvimento Empresarial 2" where co_categoria_fc_filha = 12;

UPDATE TB_CATEGORIA_FC_FILHA SET ds_texto = "Investimentos em Desenvolvimento Empresarial" where co_categoria_fc_filha = 12;

INSERT INTO TB_CATEGORIA_FC_NETA (ds_texto, nu_codigo, co_categoria_fc_filha) VALUES ("Teste", "4.2.3", "12");

DELETE FROM TB_CATEGORIA_FC_NETA where co_categoria_fc_neta = "68";

INSERT INTO TB_CONTA_BANCARIA (st_status, nu_agencia, nu_conta, no_banco, dt_cadastro, co_assinante) VALUES ("S", "1", "3345455", "DINHEIRO (Caixa da loja)", "2024-06-11 17:30:52", "12");

INSERT INTO TB_HIST_SALDO_CB (co_conta_bancaria, nu_saldo, ds_observacao, dt_cadastro, co_usuario) VALUES ("10", "289.80", "Caixa da loja", "2024-06-11 17:30:52", "13");

INSERT INTO TB_CONTA_BANCARIA (st_status, nu_agencia, nu_conta, no_banco, dt_cadastro, co_assinante) VALUES ("S", "2345", "000002", "Nu Bank", "2024-06-11 17:32:19", "12");

INSERT INTO TB_HIST_SALDO_CB (co_conta_bancaria, nu_saldo, ds_observacao, dt_cadastro, co_usuario) VALUES ("11", "2765.39", "", "2024-06-11 17:32:19", "13");

INSERT INTO TB_HIST_SALDO_CB (dt_cadastro, co_usuario, nu_valor_pago, tp_fluxo, co_conta_bancaria, ds_observacao, nu_saldo) VALUES ("2024-06-11 17:33:24", "13", "250.00", "2", "10", "Transferência entre contas.", "39.8");

INSERT INTO TB_HIST_SALDO_CB (dt_cadastro, co_usuario, nu_valor_pago, tp_fluxo, co_conta_bancaria, ds_observacao, nu_saldo) VALUES ("2024-06-11 17:33:24", "13", "250.00", "1", "11", "transferência entre contas.", "3015.39");

INSERT INTO TB_HIST_TRANSFERENCIA (co_conta_bancaria_origem, dt_realizado, co_conta_bancaria_destino, nu_valor_transferido, dt_cadastro, co_usuario, co_assinante, nu_saldo_origem_ant, nu_saldo_origem_dep, nu_saldo_destino_ant, nu_saldo_destino_dep) VALUES ("10", "2024-06-11 17:33:24", "11", "250.00", "2024-06-11 17:33:24", "13", "12", "289.80", "39.8", "2765.39", "3015.39");

INSERT INTO TB_REPRESENTACAO (no_representacao, ds_email, nu_tel1, co_assinante) VALUES ("LEONARDO MACHADO CARVALHO BESSA", "leonardomcbessa@gmail.com", "", "12");

INSERT INTO TB_REPRESENTACAO (no_representacao, ds_email, nu_tel1, co_assinante) VALUES ("AMAURY COSTA SILVA RAMOS", "ramos.amaury96@gmail.com", "", "12");

