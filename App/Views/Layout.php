<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/css/index.css">
    <link rel="stylesheet" href="../../assets/css/admin.css">
    <link rel="stylesheet" href="../../assets/css/btn-switch.css">
    <link rel="stylesheet" href="../../assets/css/animate.css">
    <link rel="icon" href="../../assets/images/logo.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="../../assets/js/jQuery-3.4.1.js"></script>
    <script src="../../assets/js/jquery.mask.min.js"></script>
    <script src="../../assets/js/app.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>Our CookBook</title>
</head>
<body>

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
                                <span id="qtde-porcoes"></span>
                            </div>
                            <div class="icons tempo-preparo">
                                <img src="../../../assets/images/icon-timer.png" width="25">
                                <span id="preparo"></span>
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
    <!-- Fim Modal -->

    <?php if ($_SESSION['id'] != "" && $_SESSION['nome'] != "") { ?>
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
                                <a class="nav-link" href="/receitasfavoritas"><i class="fas fa-heart"></i> Favoritos</a>
                            </li>
                            <li class="navbar-item divided"></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-search"></i> Consultas
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="/ingredientes">Ingredientes</a>
                                    <a class="dropdown-item" href="/receitas">Receitas</a>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-plus"></i> Cadastros
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="/novareceita">Nova Receita</a>
                                </div>
                            </li>

                            <li class="navbar-item divided"></li>
                            <li class="navbar-item">
                                <a class="nav-link" href="/contato"><i class="fas fa-paper-plane"></i> Contato</a>
                            </li>

                            <?php if ($_SESSION['permissao'] == 'admin') { ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-cog"></i> Configurações
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        <a class="dropdown-item" href="/adminsenhas">Alteração de senha</a>
                                        <a class="dropdown-item" href="/mensagens">Mensagens recebidas</a>
                                        <a class="dropdown-item" href="/usuarios">Usuários ativos</a>
                                    </div>
                                </li>
                            <?php } ?>

                            <li class="navbar-item">
                                <a class="nav-link" href="/sair"><i class="fas fa-sign-out-alt"></i> Sair</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
    <?php } else { ?>
        <?php if ($_SERVER['REQUEST_URI'] == "/contato" || $_SERVER['REQUEST_URI'] == "/novamensagem") { ?>
            <header>
                <nav class="navbar navbar-expand-xl navbar-dark">
                    <div class="container">
                        <a class="navbar-brand d-flex" href="/">
                            <img src="../../../assets/images/logo.png" width="50">
                            <div style="margin-left:10px; display:flex; flex-direction:column;">
                                <strong style="margin-top:3px;">Our CookBook</strong>
                                <small style="font-size:14px;">Olá, Convidado!</small>
                            </div>
                        </a>

                        <button class="navbar-toggler" data-toggle="collapse" data-target="#main-menu">
                            <i class="fas fa-bars text-white"></i>
                        </button>
                    </div>
                </nav>
            </header>
        <?php } ?>
    <?php } ?>

    <?php $this->content(); ?>

    <?php if ($_SESSION['id'] != "" && $_SESSION['nome'] != "") { ?>
        <!-- <footer>
            <div class="main-footer">
                <span>© 2019 | Todos os direitos reservados.</span>
            </div>
        </footer> -->
    <?php } ?>
</body>
</html>
