<div class="wrapper">
    <img src="../../../assets/images/logo.png" alt="Logotipo" width="100" title="Ir para Página inicial" onclick="window.location='/'" style="cursor:pointer;">
    <h3>Recuperação de senha</h3>

    <?php if (isset($this->dados->email)) { ?>
        <small class="animated bounce">* Erro: <?= $this->dados->email['msg']; ?></small>
    <?php } ?>

    <?php if (isset($this->dados->msg)) { ?>
        <img src="../../../assets/images/img-email.png" width="40" style="margin-bottom:0px;">
        <span class="animated heartBeat ok-message"><?= $this->dados->msg; ?></span>
        <small class="animated bouce text-success" style="margin-bottom:10px;">Instruções de redefinição da sua senha foram <br> encaminhadas para o seu email.</small>
    <?php } ?>

    <form action="/recuperarsenha" method="post">
        <input type="email" name="email" id="email" value="<?php if (isset($this->dados->email)) { echo $this->dados->email['email']; } ?>" placeholder="Seu e-mail de recuperação">
        <button class="btn-custom" id="recuperar-senha" type="submit">Recuperar &raquo;</button>
    </form>

   <div class="links-recuperacao alteracao-de-senha">
        <a href="/">Voltar para a página inicial.</a>
    </div>
</div>
