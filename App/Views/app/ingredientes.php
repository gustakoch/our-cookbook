<section class="content">
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
                <button class="btn-custom load-button" id="adicionar-ingrediente" type="submit">
                    <span class="spinner-border-sm"></span>
                    <span class="loading">Adicionar &raquo;</span>
                </button>
            </form>

            <h4 class="mt-3">Ingredientes cadastrados</h4>

            <?php if (count($this->dados->ingredientes) <= 0) { ?>
                <em>Não há cadastros de ingredientes.</em>
            <?php } ?>

            <?php foreach ($this->dados->ingredientes as $ingrediente) { ?>
                <ul class="ingredientes-cadastrados">
                    <li><i class="fas fa-angle-right"></i>&nbsp; <?= $ingrediente['ingrediente'] ?></li>
                </ul>
            <?php } ?>

        </div>
    </div>
</section>
