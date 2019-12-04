<!-- Modal -->
<div class="modal fade" id="main-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border:0;">
                <h5 class="modal-title" id="exampleModalCenterTitle">Nome da receita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <img id="img-receita-modal" src="" alt="Imagem da receita">
                <div class="conteudo-receita">
                    <small id="publicacao-receita">Publicado em </small>
                    <small id="criacao-receita">Criado por </small>

                    <h6>Ingredientes</h6>
                    <ul id="lista-ingredientes"></ul>

                    <h6>Modo de preparo</h6>
                    <span id="modo-de-preparo"></span>

                    <div class="icones-receita">
                        <div class="icons porcoes">
                            <img src="../../../assets/images/icon-porcoes.png" width="25">
                            <span>Rende ??? porções</span>
                        </div>
                        <div class="icons tempo-preparo">
                            <img src="../../../assets/images/icon-timer.png" width="25">
                            <span>Tempo aprox. ???</span>
                        </div>
                    </div>

                </div>

            </div>
            <div class="modal-footer" style="border:0;">
                <button type="button" class="btn btn-block" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

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
                            <button class="btn-fav" id="<?= $receita['id'] ?>" type="button" title="Favoritar receita">
                                <?php if (!$receita['id_favorito']) { ?>
                                    <i class="far fa-heart"></i>
                                <?php } else { ?>
                                    <i class="fas fa-heart text-danger"></i>
                                <?php } ?>
                            </button>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <span><em>Não há registros nessa seção!</em> <i class="fas fa-frown text-danger"></i></span>
            <?php } ?>

        </div>
    </div>
</section>

<footer class="fixed-bottom">
    <div class="main-footer">
        <span>© 2019 | Todos os direitos reservados.</span>
    </div>
</footer>
