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

<footer class="fixed-bottom">
    <div class="main-footer">
        <span>© 2019 | Todos os direitos reservados.</span>
    </div>
</footer>