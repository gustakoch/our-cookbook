<section class="content">
    <div class="col-md-12 d-flex justify-content-center mt-3">
        <div class="nova-receita mensagens" style="max-width:500px;">
            <h4>Mensagens recebidas</h4>

            <h6>Não lidas (<?= $this->dados->mensagens['nao_lidas']; ?>)</h6>
            <?php if ($this->dados->mensagens['nao_lidas'] > 0) { ?>
                <?php foreach ($this->dados->todas_mensagens as $mensagem) { ?>
                    <?php if ($mensagem['lido'] == 0) { ?>
                        <div class="nao-lida">
                            <div class="icon-autor-assunto">
                                <i class="fas fa-envelope"></i>
                                <div class="autor-assunto">
                                    <span>Por <?= $mensagem['nome']; ?></span>
                                    <a href="/mensagem?id=<?= $mensagem['id']; ?>"><strong><?= $mensagem['assunto']; ?></strong></a>
                                </div>
                            </div>
                            <div class="data-envio">
                                <span>Enviado em</span>
                                <strong><?= $mensagem['data_enviado']; ?></strong>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                <span class="sem-mensagens"><em>Sem novas mensagens!</em> <i class="fas fa-frown text-danger"></i></span>
            <?php } ?>

            <hr>

            <h6>Lidas (<?= $this->dados->mensagens['lidas']; ?>)</h6>
            <?php if ($this->dados->mensagens['lidas'] > 0) { ?>
                <?php foreach ($this->dados->todas_mensagens as $mensagem) { ?>
                    <?php if ($mensagem['lido'] == 1) { ?>
                        <div class="nao-lida lida">
                            <div class="icon-autor-assunto">
                                <i class="far fa-envelope-open icon-lido"></i>
                                <div class="autor-assunto">
                                    <span class="nome-autor">Por <?= $mensagem['nome']; ?></span>
                                    <a class="link-lida" href="/mensagem?id=<?= $mensagem['id']; ?>"><strong><?= $mensagem['assunto']; ?></strong></a>
                                </div>
                            </div>
                            <div class="data-envio">
                                <span>Enviado em</span>
                                <strong><?= $mensagem['data_enviado']; ?></strong>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                <span class="sem-mensagens"><em>Sem mensagens lidas!</em> <i class="fas fa-frown text-danger"></i></span>
            <?php } ?>

        </div>
    </div>
</section>

<footer class="fixed-bottom">
    <div class="main-footer">
        <span>© 2019 | Todos os direitos reservados.</span>
    </div>
</footer>
