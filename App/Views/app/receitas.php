<section class="content">
    <div class="col-md-12 d-flex justify-content-center mt-3">
        <div class="nova-receita" style="max-width:500px;">
            <h4>Lista de receitas</h4>
            <form action="/resultados" method="get">
                <div class="box-pesquisa">
                    <input type="text" name="busca" id="busca" placeholder="Pesquisar receita...">
                    <button type="submit">Buscar</button>
                </div>
            </form>

            <?php if (isset($this->dados->msg)) { ?>
                <small class="animated bounce text-success" style="margin-bottom:3px;"><?= $this->dados->msg; ?></small>
            <?php } ?>

            <?php if (count($this->dados->receitas) > 0) { ?>
                <?php foreach ($this->dados->receitas as $receita) { ?>
                    <div class="lista-receitas">
                        <img class="img-receita" id="<?= $receita['id']; ?>" src="../../../uploads/<?= $receita['nome_imagem']; ?>">
                        <div class="group-receitas">
                            <div class="info-receitas">
                                <?php
                                    if (strlen($receita['nome_receita']) > 25) {
                                        $nome_receita = substr($receita['nome_receita'], 0, 25) . " ...";
                                    } else {
                                        $nome_receita = $receita['nome_receita'];
                                    }
                                ?>
                                <strong><?= $nome_receita; ?></strong>
                                <?php $descricao = substr($receita['descricao'], 0, 90) . " ..."; ?>
                                <p><?= $descricao; ?></p>
                            </div>

                            <div class="buttons-receita">
                                <div class="editar-excluir">
                                    <a href="/alterar?id=<?= $receita['id']; ?>" class="btn-edicao" title="Editar receita">
                                        <i class="fas fa-edit text-success"></i>
                                    </a>
                                    <button class="btn-excluir" id="<?= $receita['id']; ?>" title="Excluir receita">
                                        <i class="fas fa-trash-alt text-danger"></i>
                                    </button>
                                </div>
                                <button class="btn-fav" id="<?= $receita['id'] ?>" type="button" title="Favoritar receita">
                                    <?php if (!$receita['id_favorito']) { ?>
                                        <i class="far fa-thumbs-up fa-lg"></i>
                                    <?php } else { ?>
                                        <i class="fas fa-thumbs-up text-primary fa-lg"></i>
                                    <?php } ?>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <span><em>Não há registros nessa seção!</em> <i class="fas fa-frown text-danger"></i></span>
            <?php } ?>

        </div>
    </div>
</section>
