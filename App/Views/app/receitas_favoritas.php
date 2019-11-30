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

<header>
    <nav class="navbar navbar-expand-xl navbar-dark">
        <div class="container">
            <a class="navbar-brand d-flex" href="/admin">
                <img src="../../../assets/images/logo.png" width="50">
                <div style="margin-left:10px; display:flex; flex-direction:column;">
                    <strong style="margin-top:3px;">Our CookBook</strong>
                    <small style="font-size:14px;">Olá, <?php echo $_SESSION['nome'] ?>!</small>
                </div>
            </a>

            <button class="navbar-toggler" data-toggle="collapse" data-target="#main-menu">
                <i class="fas fa-bars text-white"></i>
            </button>

            <div class="collapse navbar-collapse" id="main-menu">
                <ul class="navbar-nav ml-auto menu-mobile">
                    <li class="navbar-item">
                        <a class="nav-link" href="/admin"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="navbar-item">
                        <a class="nav-link" href="/receitas"><i class="fas fa-book"></i> Todas as receitas</a>
                    </li>
                    <li class="navbar-item">
                        <a class="nav-link" href="/receitasfavoritas"><i class="fas fa-heart"></i> Favoritos</a>
                    </li>
                    <li class="navbar-item divided"></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-plus"></i> Cadastros
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="/ingredientes">Ingredientes</a>
                            <a class="dropdown-item" href="/novareceita">Receitas</a>
                        </div>
                    </li>

                    <?php if ($_SESSION['permissao'] == 'admin') { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cog"></i> Configurações
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="/usuarios">Usuários</a>
                                <a class="dropdown-item" href="/adminsenhas">Alteração de senha</a>
                            </div>
                        </li>
                    <?php } ?>
                    <li class="navbar-item">
                        <a class="nav-link" href="/sair"><i class="fas fa-sign-out-alt"></i> Desconectar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<section class="content">
    <div class="col-md-12 d-flex justify-content-center mt-3">
        <div class="nova-receita" style="max-width:500px;">
            <h4>Receitas favoritas</h4>
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
                            <button class="btn-fav refresh-fav" id="<?= $receita['id'] ?>" type="button" title="Favoritar receita">
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
                <span><em>Você não possui receitas favoritadas!</em> <i class="fas fa-frown text-danger"></i></span>
            <?php } ?>

        </div>
    </div>
</section>

<footer class="fixed-bottom">
    <div class="main-footer">
        <span>© 2019 | Todos os direitos reservados.</span>
    </div>
</footer>
