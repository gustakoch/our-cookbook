<section class="content">
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