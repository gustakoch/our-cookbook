<section class="content">
    <div class="col-md-12 d-flex justify-content-center mt-3">
        <div class="nova-receita" style="max-width:500px;">
            <h4>Ingredientes cadastrados</h4>

            <?php if (count($this->dados->ingredientes) > 0) { ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Nome do ingrediente</th>
                            <th scope="col" style="text-align: center; width: 94px;">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($this->dados->ingredientes as $ingrediente) { ?>
                            <tr>
                                <td id="ingrediente<?= $ingrediente['id']; ?>"><?= $ingrediente['ingrediente']; ?></td>
                                <td style="text-align: center; vertical-align: middle;">
                                    <button class="btn-edicao-ingrediente" id="<?= $ingrediente['id']; ?>" title="Editar ingrediente">
                                        <i class="fas fa-edit text-success"></i>
                                    </button>
                                    <a class="btn-excluir-ingrediente" id="<?= $ingrediente['id']; ?>" title="Excluir ingrediente" style="cursor: pointer;">
                                        <i class="fas fa-trash-alt text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <span><em>Não há registros de ingredientes. </em> <i class="fas fa-frown text-danger"></i></span>
            <?php } ?>

            <a href="/cadastros/novoingrediente" class="btn-custom btn-ingrediente">Cadastrar novo ingrediente &raquo;</a>
        </div>
    </div>
</section>
