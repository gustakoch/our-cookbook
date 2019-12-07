<div class="wrapper">
    <img src="../../../assets/images/logo.png" alt="Logotipo" width="100" onclick="window.location='/'" title="Ir para Página inicial" style="cursor:pointer;">
    <h3>Criar uma nova conta</h3>

    <?php if (isset($_GET['ok'])) { ?>
        <span class="animated heartBeat ok-message">Conta criada com sucesso!</span>
        <small class="animated bouce text-success" style="margin-bottom:10px;">Sua conta precisa ser ativada por um administrador. Por favor, aguarde...</small>
    <?php } ?>

    <?php if (isset($this->dados->erro_validacao)) { ?>
        <small class="animated bounce">* Erro: <?= $this->dados->erro_validacao['msg']; ?></small>
    <?php } ?>

    <form action="/criarnovaconta" method="post">
        <input type="text" value="<?php if (isset($this->dados->erro_validacao['nome'])){ echo $this->dados->erro_validacao['nome']; } ?>" name="nome" id="nome" placeholder="Seu nome completo">
        <input type="email" value="<?php if (isset($this->dados->erro_validacao['email'])){ echo $this->dados->erro_validacao['email']; } ?>" name="email" id="email" placeholder="Seu melhor e-mail">

        <div class="show-hide-password">
            <input type="password" value="<?php if (isset($this->dados->erro_validacao['senha'])){ echo $this->dados->erro_validacao['senha']; } ?>" name="senha" id="senha" placeholder="Sua senha secreta">
            <button id="btn-password" type="button" title="Mostrar/ocultar senha"><i class="fas fa-eye"></i></button>
        </div>
        <small id="txtcapslock" style="display:none;">ATENÇÃO! A tecla CapLock está ativada!</small>

        <div class="show-hide-password">
            <input type="password" name="confirmar_senha" id="confirmar_senha" placeholder="Confirme sua senha secreta">
            <button id="btn-password-confirmar" type="button" title="Mostrar/ocultar senha"><i class="fas fa-eye"></i></button>
        </div>
        <small id="txtcapslock2" style="display:none;">ATENÇÃO! A tecla CapLock está ativada!</small>

        <button class="btn-custom load-button" id="registrarse" type="submit">
            <span class="spinner-border-sm"></span>
            <span class="loading">Registrar-se &raquo;</span>
        </button>

        <div class="info text-center">
            <span>Já possui uma conta? <a href="/">Fazer login.</a></span>
        </div>
    </form>
</div>
