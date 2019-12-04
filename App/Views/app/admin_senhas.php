<section class="content">
    <div class="col-md-12 d-flex justify-content-center mt-3">
        <div class="nova-receita usuarios" style="max-width:500px;">
            <h4>Alteração de senhas</h4>

            <?php if (isset($this->dados->validacao)) { ?>
                <small class="animated bounce text-danger">* Erro: <?= $this->dados->validacao['msg']; ?></small>
            <?php } ?>

            <?php if (isset($this->dados->msg)) { ?>
                <span class="animated bounce text-success" style="margin-bottom:3px;"><?= $this->dados->msg; ?></span>
            <?php } ?>

            <form id="form-alteracao-senha" action="/alterarsenhausuario" method="post">
                <label for="id_usuario"><strong>E-mail do usuário:</strong></label>

                <select class="form-inputs" name="id_usuario" id="id_usuario">
                    <?php foreach ($this->dados->usuarios as $usuario) { ?>
                        <option value="<?= $usuario['id']; ?>" <?php if ($this->dados->validacao['id'] == $usuario['id']) { echo 'selected="selected"'; } ?>><?= $usuario['email'] ?></option>
                    <?php } ?>
                </select>

                <label for="nova_senha"><strong>Nova senha:</strong></label>
                <input class="form-inputs" type="password" name="nova_senha" id="nova_senha" value="<?php if (isset($this->dados->validacao)) { echo $this->dados->validacao['nova_senha']; } ?>" placeholder="Digite a nova senha">

                <label for="confirmar_senha"><strong>Confirme a nova senha:</strong></label>
                <input class="form-inputs" type="password" name="confirmar_senha" id="confirmar_senha" placeholder="Confirme a nova senha">

                <button id="alterar-senha" class="btn-custom" type="submit">Alterar senha &raquo;</button>
            </form>

        </div>
    </div>
</section>

<footer class="fixed-bottom">
    <div class="main-footer">
        <span>© 2019 | Todos os direitos reservados</span>
    </div>
</footer>
