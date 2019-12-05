<section class="content">
    <div class="col-md-12 d-flex justify-content-center mt-3">
        <div class="nova-receita" style="max-width:700px;">

            <h4>Mensagem #<?= $this->dados->mensagem['id']; ?></h4>
            <div class="mensagem-enviada">
                <div class="voltar-assunto">
                    <a href="/mensagens" title="Voltar para mensagens"> <i class="fas fa-chevron-left fa-lg"></i> </a>
                    &nbsp;&nbsp;<strong class="mensagem-assunto"><?= $this->dados->mensagem['assunto']; ?></strong>
                </div>

                <hr style="width:100%;margin: 20px 0;">

                <div class="informacoes-mensagem">
                    <div class="nome-email">
                        <div>
                            <span>De: &nbsp;</span><strong> <?= $this->dados->mensagem['nome']; ?></strong>&nbsp;
                            <<span><?= $this->dados->mensagem['email']; ?></span>>
                        </div>
                    </div>
                    <?php $telefone = $this->dados->mensagem['telefone'] != "" ? $this->dados->mensagem['telefone'] : "Não informado"; ?>

                    <span>Telefone: &nbsp;</span> <strong><?= $telefone; ?></strong><br>
                    <span>Data: &nbsp;</span><strong><?= $this->dados->mensagem['data_enviado']; ?></strong>

                    <hr style="width:100%;margin: 20px 0;">

                    <div class="corpo-mensagem">
                        <small><em>Mensagem recebida</em></small>
                        <p><?= nl2br($this->dados->mensagem['mensagem']); ?></p>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>
