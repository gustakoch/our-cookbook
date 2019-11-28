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
            <h4>Cadastrar nova receita</h4>

            <?php if (isset($this->dados->dados_receita)) { ?>
                <small class="animated bounce text-danger" style="margin-bottom:3px;">* Erro: <?= $this->dados->dados_receita['msg'] ?></small>
            <?php } ?>
            <?php if (isset($_GET['ok'])) { ?>
                <small class="animated bounce text-success" style="margin-bottom:3px;">Receita cadastrada com sucesso!</small>
            <?php } ?>

            <form action="/cadastronovareceita" method="post" enctype="multipart/form-data">
                <label><strong>Imagem:</strong></label>
                <div class="box-image">
                    <img class="preview-img" src="../../../assets/images/cam.png" height="40" width="40">
                </div>

                <label id="img-label" for="imagem">Clique aqui para selecionar a imagem</label>
                <input class="file-chooser" id="imagem" name="imagem" type="file" accept="image/*" hidden>

                <label for="nome_receita"><strong>Nome da receita:</strong></label>
                <input class="form-inputs" type="text" value="<?= $this->dados->dados_receita['nome_receita'] ?>" name="nome_receita" id="nome_receita" placeholder="Digite o nome da receita">

                <label for="descricao" style="margin-top:10px;"><strong>Descrição da receita:</strong></label>
                <textarea class="form-inputs" name="descricao" id="descricao" rows="3" placeholder="Breve descrição da receita" maxlength="120"><?= $this->dados->dados_receita['descricao'] ?></textarea>

                <label for="ingredientes" style="margin-top:10px;"><strong>Check In de ingredientes:</strong></label>
                <ul class="lista-ingredientes">

                    <?php foreach ($this->dados->ingredientes as $ingrediente) { ?>
                        <?php $this->dados->dados_receita['ingredientes'] = isset($this->dados->dados_receita['ingredientes']) ? $this->dados->dados_receita['ingredientes'] : []; ?>
                        <?php if (in_array($ingrediente['id'], $this->dados->dados_receita['ingredientes'])) { ?>
                            <li>
                                <input type="checkbox" checked name="ingredientes[<?= $ingrediente['id'] - 1 ?>]" id="<?= $ingrediente['id'] ?>" value="<?= $ingrediente['id'] ?>">
                                <label for="<?= $ingrediente['id'] ?>"><?= $ingrediente['ingrediente'] ?></label>
                            </li>
                        <?php } else { ?>
                            <li>
                                <input type="checkbox" name="ingredientes[<?= $ingrediente['id'] - 1 ?>]" id="<?= $ingrediente['id'] ?>" value="<?= $ingrediente['id'] ?>">
                                <label for="<?= $ingrediente['id'] ?>"><?= $ingrediente['ingrediente'] ?></label>
                            </li>
                        <?php } ?>
                    <?php } ?>

                </ul>
                <label for="mododefazer"><strong>Modo de fazer:</strong></label>
                <textarea class="form-inputs" name="modo_de_fazer" id="modo_de_fazer" rows="12" placeholder="Descreva aqui o modo de fazer"><?= $this->dados->dados_receita['modo_de_fazer'] ?></textarea>
                <button id="salvar" class="btn-custom" type="submit">Salvar &raquo;</button>
            </form>
        </div>

    </div>
</section>

<footer>
    <div class="main-footer mt-3">
        <span>© 2019 | Todos os direitos reservados.</span>
    </div>
</footer>

<script>
    $(document).ready(function() {

        $('#salvar').click(function() {
            $(this).html('<i class="fas fa-spinner"></i> Salvando receita...');
        });

    });

    const previewImg = document.querySelector('.preview-img');
    const fileChooser = document.querySelector('.file-chooser');

    fileChooser.onchange = e => {
        const fileToUpload = e.target.files.item(0);
        const reader = new FileReader();

        reader.onload = e => previewImg.src = e.target.result;
        reader.readAsDataURL(fileToUpload);

        const imageLoaded = document.querySelector('.preview-img');
        imageLoaded.classList.add('img-loaded');
    };
</script>