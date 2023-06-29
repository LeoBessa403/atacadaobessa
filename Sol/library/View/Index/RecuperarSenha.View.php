<?php
include_once './library/Partial/AcessoPermitido/topo_inicial.php';
?>

    <div class="col-12 align-self-center">
        <div class="row align-items-center justify-content-center">
            <div class="col-12 col-sm-8 cx-login col-md-6 col-lg-5 col-xl-4 col-xxl-3 text-center">
                <h3 class="mb-3 mb-lg-4 text-theme-2">Recuperar Senha</h3>
                <p class="mb-4 text-theme-2"><strong>Por Favor! Entre com o E-Mail para recuperar sua senha.
                        <br><small><?php include_once 'library/Partial/Admin/controle_versao.php'; ?></small></strong>
                </p>
                <div class="mb-4 text-start">
                    <!-- alert messages -->
                    <div class="alert alert-danger fade show d-none mb-2 global-alert text-start" role="alert">
                        <div class="row">
                            <div class="col"><strong>Alerta!</strong> Usuário Inválido.</div>
                        </div>
                    </div>
                    <div class="alert alert-success fade show d-none mb-2 global-success text-start" role="alert">
                        <div class="row">
                            <div class="col-auto align-self-center ">
                                <div class="spinner-border spinner-border-sm text-success me-2" role="status">
                                    <span class="visually-hidden">Carregando...</span>
                                </div>
                            </div>
                            <div class="col ps-0">
                                <strong>Um momento!</strong> Levando você para a próxima página.
                            </div>
                        </div>
                    </div>
                    <!-- Form elements -->
                    <div class="form-group mb-2 position-relative check-valid">
                        <div class="input-group input-group-lg">
                                <span class="input-group-text text-theme border-end-0"><i
                                            class="bi bi-envelope"></i></span>
                            <div class="form-floating">
                                <input type="email" placeholder="Digite o Email" required
                                       class="form-control border-start-0 ob email" autofocus id="<?= DS_EMAIL; ?>"
                                       name="<?= DS_EMAIL; ?>">
                                <label>Email</label>
                            </div>
                        </div>
                    </div>
                    <div class="invalid-feedback">Email inválido! Favor verificar.</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4 col-xxl-3 mt-auto mb-4 text-center d-grid">
        <!-- submit button -->
        <button class="btn btn-lg cx-login btn-theme z-index-5 mb-4" href="<?= PASTAADMIN; ?>Index/Registrar"
                type="button" id="submitbtn">Recuperar senha <i class="bi bi-arrow-right"></i></button>
        <p class="text-white"><a href="<?= PASTAADMIN; ?>Index/Acessar"
                                 class="btn btn-mini cx-login btn-theme z-index-5 mb-4"> Voltar ao Login</a></p>
    </div>

<?php
include_once './library/Partial/AcessoPermitido/rodape_inicial.php';
?>