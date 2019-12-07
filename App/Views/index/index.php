<div class="wrapper">
    <img src="../../../assets/images/logo.png" alt="Logotipo" width="100" onclick="window.location='/'" style="cursor:pointer;">
    <h3>Our CookBook</h3>

    <?php if (isset($_GET['error'])) { ?>
        <small class="animated bounce">* Erro: Usuário e/ou senha inválido(s)! Por favor, tente novamente.</small>
    <?php } ?>

    <form action="/login" method="post">
        <?php $value_email = isset($_COOKIE['email']) ? $_COOKIE['email'] : $_GET['email']; ?>
        <input type="email" value="<?php echo $value_email; ?>" name="email" id="email" placeholder="Seu e-mail">

        <div class="show-hide-password">
            <input type="password" name="senha" id="senha" value="<?php if (isset($_COOKIE['senha'])) { echo $_COOKIE['senha']; } ?>" placeholder="Sua senha secreta">
            <button id="btn-password" type="button" title="Mostrar/ocultar senha"><i class="fas fa-eye"></i></button>
        </div>

        <small id="txtcapslock" style="display:none;">ATENÇÃO! A tecla CapLock está ativada!</small>

        <div class="lembrar-recuperar-senha">
            <div class="lembrar-senha">
                <input type="checkbox" name="lembrar_senha" id="lembrar_senha" <?php if (isset($_COOKIE['senha'])) { echo 'checked="checked"'; } ?>>
                <label for="lembrar_senha">Lembrar-me</label>
            </div>
            <div class="recuperar-senha">
                <a href="/recuperacao">Esqueceu sua senha?</a>
            </div>
        </div>

        <button class="btn-custom load-button" id="login" type="submit">
            <span class="spinner-border-sm"></span>
            <span class="loading">Login &raquo;</span>
        </button>

        <div class="info text-center">
            <span>Não possui conta? <a href="/criarconta">Registrar-se.</a></span><br>
            <span>Problemas, dúvidas ou sugestões? <a href="/contato">Entre em contato.</a></span>
        </div>
    </form>
</div>
