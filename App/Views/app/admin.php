<section class="content">
    <div class="ultimas-receitas">
        <h3>Últimas receitas</h3>
    </div>

    <?php foreach ($this->dados->receitas as $receita) { ?>
        <article>
            <div class="col-md-12 d-flex justify-content-center mt-3">

                <div class="card" style="max-width:500px;">
                    <img src="<?= "../../../uploads/" . $receita['nome_imagem'] . ""; ?>" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title"><?= $receita['nome_receita']; ?></h5>
                        <p class="card-text"><?= $receita['descricao']; ?></p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Publicado em <?= $receita['data_cadastro']; ?></small><br>
                        <small class="text-muted">Por <?= $receita['nome']; ?></small>
                    </div>
                </div>

            </div>
        </article>
    <?php } ?>

    <div class="btn-home">
        <a href="/receitas" class="btn-custom" data-dismiss="modal">Todas as receitas &raquo;</a>
    </div>
</section>
