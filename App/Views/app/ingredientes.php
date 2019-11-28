<header>
    <nav class="navbar navbar-expand-lg navbar-dark">
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

<section>
    <div class="col-md-12 d-flex justify-content-center mt-3">
        <div class="nova-receita" style="max-width:500px;">
            <h4>Cadastro de ingredientes</h4>
            <form action="/novoingrediente" method="post">

                <?php if (isset($_GET['error'])) { ?>
                    <small class="animated bounce text-danger" style="margin-bottom:3px;">* Erro: Por favor, informe o ingrediente a ser cadastrado.</small>
                <?php } ?>
                <?php if (isset($_GET['ok'])) { ?>
                    <small class="animated bounce text-success" style="margin-bottom:3px;">Ingrediente cadastrado com sucesso!</small>
                <?php } ?>

                <input class="form-inputs" type="text" name="ingrediente" id="ingrediente" placeholder="Nome do ingrediente">
                <button id="adicionar-ingrediente" class="btn-custom" type="submit">Adicionar ingrediente &raquo;</button>
            </form>

            <h4 class="mt-3">Ingredientes cadastrados</h4>

            <?php if (count($this->dados->ingredientes) <= 0) { ?>
                <em>Não há cadastros de ingredientes.</em>
            <?php } ?>

            <?php foreach ($this->dados->ingredientes as $ingrediente) { ?>
                <ul class="ingredientes-cadastrados">
                    <li><i class="fas fa-forward"></i>&nbsp; <?= $ingrediente['ingrediente'] ?></li>
                </ul>
            <?php } ?>

        </div>
    </div>
</section>

<footer class="fixed-bottom">
    <div class="main-footer mt-3">
        <span>© 2019 | Todos os direitos reservados.</span>
    </div>
</footer>