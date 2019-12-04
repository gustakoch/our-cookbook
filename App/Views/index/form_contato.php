<section class="content">
    <div class="col-md-12 d-flex justify-content-center mt-3">
        <div class="nova-receita form-nova-mensagem" style="max-width:500px;">
            <h4>Entre em contato</h4>

            <?php if (isset($this->dados->validacao)) { ?>
                <small class="animated bounce text-danger">* Erro: <?= $this->dados->validacao['msg']; ?></small>
            <?php } ?>

            <?php if (isset($this->dados->msg)) { ?>
                <span class="animated bounce text-success" style="margin-bottom:3px;"><?= $this->dados->msg; ?></span>
            <?php } ?>

            <form action="/novamensagem" method="post">
                <label for="nome"><strong>Nome: *</strong></label>
                <input class="form-inputs" type="text" name="nome" id="nome" value="<?php if (isset($this->dados->validacao)) { echo $this->dados->validacao['nome']; } else { if (isset($_SESSION['nome'])) { echo $this->dados->usuario['nome']; } } ?>" placeholder="Digite seu nome">

                <label for="email"><strong>E-mail: *</strong></label>
                <input class="form-inputs" type="email" name="email" id="email" value="<?php if (isset($this->dados->validacao)) { echo $this->dados->validacao['email']; } else { if (isset($_SESSION['nome'])) { echo $this->dados->usuario['email']; } } ?>" placeholder="Digite seu e-mail">

                <label for="telefone"><strong>Telefone:</strong></label>
                <input class="form-inputs" type="text" name="telefone" id="telefone" value="<?php if (isset($this->dados->validacao)) { echo $this->dados->validacao['telefone']; } ?>" placeholder="Digite seu número de telefone (opcional)">

                <label for="assunto"><strong>Assunto: *</strong></label>
                <input class="form-inputs" type="text" name="assunto" id="assunto" value="<?php if (isset($this->dados->validacao)) { echo $this->dados->validacao['assunto']; } ?>" placeholder="Digite o assunto" maxlength="200">

                <label for="mensagem"><strong>Mensagem: *</strong></label>
                <textarea class="form-inputs" name="mensagem" id="mensagem" rows="7" placeholder="Digite aqui a sua mensagem"><?php if (isset($this->dados->validacao)) { echo $this->dados->validacao['mensagem']; } ?></textarea>

                <button id="enviar-mensagem" class="btn-custom" type="submit">Enviar mensagem &raquo;</button>
            </form>

            <?php if ($_SESSION['id'] == "" && $_SESSION['nome'] == "") { ?>
                <div class="links-recuperacao contato-link-home">
                    <a href="/">Voltar para a página inicial.</a>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<footer class="fixed-bottom">
    <div class="main-footer">
        <span>© 2019 | Todos os direitos reservados</span>
    </div>
</footer>
