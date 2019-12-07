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
    <script src="../../assets/js/sweetalert2.all.min.js"></script>
    <script src="../../assets/js/jQuery-3.4.1.js"></script>
    <script src="../../assets/js/jquery.mask.min.js"></script>
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
                                <a class="nav-link" href="/receitas"><i class="fas fa-book"></i> Receitas</a>
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
                                        <a class="dropdown-item" href="/adminsenhas">Alteração de senha</a>
                                        <a class="dropdown-item" href="/mensagens">Mensagens recebidas</a>
                                        <a class="dropdown-item" href="/usuarios">Usuários ativos</a>
                                    </div>
                                </li>
                            <?php } ?>

                            <li class="navbar-item divided"></li>
                            <li class="navbar-item">
                                <a class="nav-link" href="/contato"><i class="fas fa-paper-plane"></i> Contato</a>
                            </li>

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

    <script>
        $(function() {
            $('.load-button').click(function() {
                let spinner = $(this).children('.spinner-border-sm');
                let button = $(this).children('.loading');
                $(button).html('Processando... aguarde!');
                $(spinner).addClass('spinner-border');
            });
            $('.load-button-busca').click(function() {
                let spinner = $(this).children('.spinner-border-sm');
                let button = $(this).children('.loading');
                $(button).html('Buscando...');
                $(spinner).addClass('spinner-border');
            });

            $('.refresh-fav').click(function(e) {
                e.preventDefault();
                location.reload();
            });

            $('#telefone').mask('(00) 00009-0000');
        });

        function carregarModal() {
            $('.img-receita').click(function(e) {
                e.preventDefault();

                let idReceita = $(this).attr('id');

                $.ajax({
                    type: "post",
                    url: "/buscarreceitaporid",
                    dataType: 'json',
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
        }

        function alteraStatusUsuario() {
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
                            //
                        },
                        error: function(xhr, status, error) {
                            //
                        }
                    });
                });
            });
        }

        function favoritarReceita() {
            $('.btn-fav').click(function(e) {
                let idReceita = $(this).attr('id');
                let texto = $(this).html();
                $(this).addClass('bounceIn');

                setTimeout(() => {
                    $(this).removeClass('bounceIn');
                }, 300);

                if (texto.indexOf('far') != -1) {
                    $(this).html('<i class="fas fa-heart text-danger"></i>');
                } else {
                    $(this).html('<i class="far fa-heart"></i>');
                }

                $.ajax({
                    url: '/favoritos',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        id_receita: idReceita
                    }
                });
            });
        }

        function geraPreviewImagem() {
            const previewImg = document.querySelector('.preview-img');
            const fileChooser = document.querySelector('.file-chooser');

            if (!fileChooser) {
                return false;
            }

            fileChooser.onchange = e => {
                const fileToUpload = e.target.files.item(0);
                const reader = new FileReader();

                reader.onload = e => previewImg.src = e.target.result;
                reader.readAsDataURL(fileToUpload);

                const imageLoaded = document.querySelector('.preview-img');
                imageLoaded.classList.add('img-loaded');
            };
        }

        function setCapsLockMessage() {
            const inputSenha = document.querySelector('#senha');
            const inputConfirmarSenha = document.querySelector('#confirmar_senha');
            const text = document.querySelector('#txtcapslock');
            const text2 = document.querySelector('#txtcapslock2');

            if (inputSenha === null || inputConfirmarSenha === null)
                return false;

            inputSenha.addEventListener('keyup', function(e) {
                if (e.getModifierState('CapsLock')) {
                    text.style.display = 'block';
                } else {
                    text.style.display = 'none';
                }
            });

            inputConfirmarSenha.addEventListener('keyup', function(e) {
                if (e.getModifierState('CapsLock')) {
                    text2.style.display = 'block';
                } else {
                    text2.style.display = 'none';
                }
            });
        }

        function showHidePasswordText() {
            $('#btn-password').click(function(e) {
                const passwordField = $('#senha');
                const passwordFieldType = passwordField.attr('type');

                if (passwordFieldType == 'password') {
                    $(passwordField).attr('type', 'text');
                    $(this).html('<i class="fas fa-eye-slash"></i>');
                } else {
                    $(passwordField).attr('type', 'password');
                    $(this).html('<i class="fas fa-eye"></i>');
                }
            });

            $('#btn-password-confirmar').click(function(e) {
                const passwordField = $('#confirmar_senha');
                const passwordFieldType = passwordField.attr('type');

                if (passwordFieldType == 'password') {
                    $(passwordField).attr('type', 'text');
                    $(this).html('<i class="fas fa-eye-slash"></i>');
                } else {
                    $(passwordField).attr('type', 'password');
                    $(this).html('<i class="fas fa-eye"></i>');
                }
            });
        }

        alteraStatusUsuario();
        geraPreviewImagem();
        carregarModal();
        favoritarReceita();
        showHidePasswordText();
        setCapsLockMessage();
    </script>
</body>

</html>