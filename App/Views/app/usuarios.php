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
        <div class="configuracoes">
            <h4>Configurações dos usuários</h4>
            <h6>Usuários cadastrados</h6>

            <?php foreach ($this->dados->usuarios as $usuario) { ?>
                <div class="box-usuario mb-3">
                    <div class="imagem">
                        <img src="../../../assets/images/user.svg" alt="Imagem Usuário" width="80">
                        <span><?= $usuario['id'] ?></span>
                    </div>
                    <div class="info-usuario">
                        <strong>Nome do usuário:</strong>
                        <span><?= $usuario['nome'] ?></span>
                        <strong>E-mail:</strong>
                        <span><?= $usuario['email'] ?></span>
                        <strong>Permissão:</strong>
                        <span><?= $usuario['permissao'] ?></span>
                    </div>
                    <div class="status">
                        <strong>Status de acesso</strong>
                        <label class="switch">
                            <input class="onoffelement" type="checkbox" value="<?= $usuario['status_ativado'] ?>" id="<?= $usuario['id'] ?>">
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</section>

<footer>
    <div class="main-footer mt-3">
        <span>© 2019 | Todos os direitos reservados.</span>
    </div>
</footer>

<script>
    $(function() {
        const elements = $('.onoffelement');

        elements.map((index, element) => {
            if (element.value == '1') {
                $(element).prop('checked', true);
            } else if (element.value == '0') {
                $(element).prop('checked', false);
            }

            $('#' + element.id).change(function(e) {
                $.ajax({
                    type: "POST",
                    url: "/update_status_usuario",
                    data: {
                        id: element.id,
                        status: element.value
                    },
                    success: function(result) {
                        //console.log(result);
                    },
                    error: function(xhr, status, error) {
                        //console.log(status, error);
                    }
                });
            });
        });
    });
</script>