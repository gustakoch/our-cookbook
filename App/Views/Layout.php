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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>Our CookBook</title>
</head>

<body>

    <?php $this->content(); ?>

    <script>
        $(function() {
            $('#login').click(function() {
                $(this).html('<i class="fas fa-spinner"></i> Carregando aplicação... aguarde!');
            });
            $('#adicionar-ingrediente').click(function() {
                $(this).html('<i class="fas fa-spinner"></i> Adicionando... aguarde!');
            });
            $('#salvar-receita').click(function() {
                $(this).html('<i class="fas fa-spinner"></i> Salvando receita... aguarde!');
            });
            $('#alterar-senha').click(function() {
                $(this).html('<i class="fas fa-spinner"></i> Alterando senha... aguarde!');
            });
            $('#recuperar-senha').click(function() {
                $(this).html('<i class="fas fa-spinner"></i> Recuperando... aguarde!');
            });
            $('#registrarse').click(function() {
                $(this).html('<i class="fas fa-spinner"></i> Registrando... aguarde!');
            });
        });

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

        favoritarReceita();
        showHidePasswordText();
        setCapsLockMessage();
    </script>
</body>

</html>