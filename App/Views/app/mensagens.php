<section class="content">
    <div class="col-md-12 d-flex justify-content-center mt-3">
        <div class="nova-receita mensagens" style="max-width:700px;">
            <h4>Mensagens recebidas</h4>

            <h6 class="badge-mensagem">
                Não lidas <small class="badge badge-light"><?= $this->dados->mensagens['nao_lidas']; ?></small>
            </h6>
            <?php if ($this->dados->mensagens['nao_lidas'] > 0) { ?>
                <?php foreach ($this->dados->todas_mensagens as $mensagem) { ?>
                    <?php if ($mensagem['lido'] == 0) { ?>
                        <div class="nao-lida">
                            <div class="icon-autor-assunto">
                                <i class="fas fa-envelope"></i>
                                <div class="autor-assunto">
                                    <span>Por <?= $mensagem['nome']; ?></span>

                                    <?php $assunto = substr($mensagem['assunto'], 0, 35) . "..."; ?>
                                    <a class="link-assunto-mensagem" id="<?= $mensagem['id']; ?>" href="/mensagem?id=<?= $mensagem['id']; ?>"><strong><?= $assunto; ?></strong></a>
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

            <h6 class="badge-mensagem" style="max-width: 90px;">
                Lidas <small class="badge badge-light"><?= $this->dados->mensagens['lidas']; ?></small>
            </h6>
            <?php if ($this->dados->mensagens['lidas'] > 0) { ?>
                <?php foreach ($this->dados->todas_mensagens as $mensagem) { ?>
                    <?php if ($mensagem['lido'] == 1) { ?>
                        <div class="nao-lida lida">
                            <div class="icon-autor-assunto">
                                <i class="far fa-envelope-open icon-lido"></i>
                                <div class="autor-assunto">
                                    <span class="nome-autor">Por <?= $mensagem['nome']; ?></span>

                                    <?php $assunto = substr($mensagem['assunto'], 0, 35) . "..."; ?>
                                    <a class="link-assunto-mensagem link-lida" id="<?= $mensagem['id']; ?>" href="/mensagem?id=<?= $mensagem['id']; ?>"><strong><?= $assunto; ?></strong></a>
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
