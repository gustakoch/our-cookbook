<div class="wrapper">
    <img src="../../../assets/images/logo.png" alt="Logotipo" width="100" title="Ir para Página inicial" onclick="window.location='/'" style="cursor:pointer;">
    <h3>Alteração de senha</h3>

    <?php if (isset($this->dados->validacao)) { ?>
        <small class="animated bounce">* Erro: <?= $this->dados->validacao['msg']; ?></small>
    <?php } ?>

     <?php if (isset($this->dados->msg_ok)) { ?>
        <span class="animated heartBeat ok-message"><?= $this->dados->msg_ok; ?></span>
        <small class="animated bouce text-success" style="margin-bottom:10px;">Você já pode acessar o sistema com a nova senha.</small>
    <?php } ?>

    <form action="/cadastrarnovasenha" method="post">
        <input type="hidden" name="chave" value="<?= $this->dados->chave ?>">

        <input type="email" name="email" id="email" value="<?= $this->dados->validacao['email']; ?>" placeholder="Seu e-mail de cadastro">
        <div class="show-hide-password">
            <input type="password" value="<?= $this->dados->validacao['senha']; ?>" name="senha" id="senha" placeholder="Sua nova senha secreta">
            <button id="btn-password" type="button" title="Mostrar/ocultar senha"><i class="fas fa-eye"></i></button>
        </div>
        <small id="txtcapslock" style="display:none;">ATENÇÃO! A tecla CapLock está ativada!</small>

        <div class="show-hide-password">
            <input type="password" name="confirmar_senha" id="confirmar_senha" placeholder="Confirme sua nova senha secreta">
            <button id="btn-password-confirmar" type="button" title="Mostrar/ocultar senha"><i class="fas fa-eye"></i></button>
        </div>
        <small id="txtcapslock2" style="display:none;">ATENÇÃO! A tecla CapLock está ativada!</small>

        <button class="btn-custom" id="login" type="submit">Alterar senha &raquo;</button>
    </form>

    <div class="links-recuperacao alteracao-de-senha">
        <a href="/">Voltar para a página inicial.</a>
    </div>
</div>
