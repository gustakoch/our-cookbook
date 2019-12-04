
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

            <?php if (strlen($_GET['busca']) <= 0) { ?>
                <h4>Lista de receitas</h4>
                <small class="animated bounce text-danger" style="margin-bottom:3px;">* Erro: Por favor, informe alguma receita para pesquisar.</small>
            <?php } else { ?>
                <h4>Resultados de: <?php if (isset($_GET['busca'])) { echo $_GET['busca']; } ?></h4>
            <?php } ?>

            <form action="/resultados" method="get">
                <div class="box-pesquisa">
                    <input type="text" name="busca" id="busca" placeholder="Pesquisar receita..." value="<?php if (isset($_GET['busca'])) { echo $_GET['busca']; } ?>">
                    <button type="submit">Buscar</button>
                </div>
            </form>
            </form>

            <?php if (count($this->dados->resultados) > 0) { ?>
                <?php foreach ($this->dados->resultados as $receita) { ?>
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
                <span><em>Não foram encontrados registros!</em> <i class="fas fa-frown text-danger"></i></span>
            <?php } ?>

        </div>
    </div>
</section>

<footer class="fixed-bottom">
    <div class="main-footer">
        <span>© 2019 | Todos os direitos reservados.</span>
    </div>
</footer>

<script>
    $(document).ready(function() {
        $('.img-receita').click(function(e) {
            e.preventDefault();

            let idReceita = $(this).attr('id');

            // VERIFICAR POSSIBILIDADE DE FAZER SOMENTE UMA REQ PARA TRAZER TODOS OS INGREDIENTES
            // E NÃO PARA CADA CLIQUE EM CADA RECEITA!!!

            $.ajax({
                type: "POST",
                url: "/buscar_receita_por_id",
                dataType: 'JSON',
                data: {
                    id: idReceita
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Oops...',
                        text: 'Não foi possível recuperar as informações',
                        confirmButtonText: 'Fechar',
                        footer: 'Erro: ' + error
                    })
                    console.log(status, error);
                },
                success: function(result) {
                    const dados = result.dados_receita[0];
                    const todosIngredientes = result.todos_ingredientes;

                    $('#main-modal').modal('show');

                    const partes = dados.cadastrado_em.split(' ');
                    const data = partes[0].split('-');
                    const dataCompleta = `${data[2]}/${data[1]}/${data[0]}`;
                    const hora = partes[1].split(':');
                    const horaAbreviada = `${hora[0]}:${hora[1]}`;

                    const ingredientes = dados.ingredientes.split(',');

                    $('#lista-ingredientes').html('');
                    todosIngredientes.forEach(function(item) {
                        if (ingredientes.includes(item.id)) {
                            li = $('<li>');
                            $(li).appendTo('#lista-ingredientes');
                            $(li).append(`<i class="fas fa-angle-right"></i> ${item.ingrediente}`);
                        }
                    });

                    $('.modal-title').html(dados.nome_receita);
                    $('#img-receita-modal').attr('src', '../../uploads/' + dados.nome_imagem);
                    $('#publicacao-receita').html(`Publicado em ${dataCompleta} às ${horaAbreviada}`);
                    $('#criacao-receita').html(`Criado por ${dados.nome}`);

                    let modoDeFazer = dados.modo_de_fazer.split('\n').join('<br />');
                    $('#modo-de-preparo').html(modoDeFazer);

                }
            });
        });

        $('#favorito').click(function(e) {
            e.preventDefault();

        });

    });
</script>