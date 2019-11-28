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
        <div class="nova-receita usuarios" style="max-width:500px;">
            <h4>Alteração de senhas</h4>

            <?php if (isset($this->dados->validacao)) { ?>
                <small class="animated bounce text-danger">* Erro: <?= $this->dados->validacao['msg']; ?></small>
            <?php } ?>

            <?php if (isset($this->dados->msg)) { ?>
                <span class="animated bounce text-success" style="margin-bottom:3px;"><?= $this->dados->msg; ?></span>
            <?php } ?>

            <form id="form-alteracao-senha" action="/alterarsenhausuario" method="post">
                <label for="id_usuario"><strong>E-mail do usuário:</strong></label>

                <select class="form-inputs" name="id_usuario" id="id_usuario">
                    <?php foreach ($this->dados->usuarios as $usuario) { ?>
                        <option value="<?= $usuario['id']; ?>" <?php if ($this->dados->validacao['id'] == $usuario['id']) { echo 'selected="selected"'; } ?>><?= $usuario['email'] ?></option>
                    <?php } ?>
                </select>

                <label for="nova_senha"><strong>Nova senha:</strong></label>
                <input class="form-inputs" type="password" name="nova_senha" id="nova_senha" value="<?php if (isset($this->dados->validacao)) { echo $this->dados->validacao['nova_senha']; } ?>" placeholder="Digite a nova senha">

                <label for="confirmar_senha"><strong>Confirme a nova senha:</strong></label>
                <input class="form-inputs" type="password" name="confirmar_senha" id="confirmar_senha" placeholder="Confirme a nova senha">

                <button id="alterar-senha" class="btn-custom" type="submit">Alterar senha &raquo;</button>
            </form>

        </div>
    </div>
</section>

<footer class="fixed-bottom">
    <div class="main-footer mt-3">
        <span>© 2019 | Todos os direitos reservados</span>
    </div>
</footer>
